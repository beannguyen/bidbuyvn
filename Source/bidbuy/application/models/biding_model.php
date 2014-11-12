<?php

/**
 * Created by PhpStorm.
 * User: mrbean
 * Date: 11/8/14
 * Time: 11:00 PM
 */
class Biding_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        // Database connect
        $this->db->connect();
    }

    /**
     * add new bid report
     * @param $data
     * @return bool
     */
    function addBid($data)
    {
        $table = DB_PRE . 'bid_report';
        if ($this->db->insert($table, $data))
            return true;
        return false;
    }

    /**
     * check if user has bid
     * @param $bidder
     * @param $productId
     * @return bool
     */
    function availableBid($bidder, $productId)
    {
        require_once(ROOT . DS . 'application/models/product_model.php');
        $productModel = new Product_Model();

        /** check for ended product */
        $productModel->checkProductWhenDueDate();

        $sql = "SELECT post_status FROM ". DB_PRE ."posts WHERE ID = " . $productId;
        $query = $this->db->query( $sql );
        $res = $this->db->fetch( $query )['post_status'];
        if ( $res === 'timeout' )
            return false;

        $sql = "SELECT *
                FROM " . DB_PRE . "bid_report
                WHERE bidder = " . $bidder . "
                AND productid = " . $productId;
        $query = $this->db->query($sql);
        if ($this->db->numrows($query) > 0)
            return false; // already
        return true; // not yet
    }

    function loadListBid($productId)
    {
        $sql = "SELECT a.*, b.name as bidder_name
                FROM " . DB_PRE . "bid_report as a, " . DB_PRE . "login_users as b
                WHERE productid = " . $productId . "
                AND b.user_id = a.bidder
                ORDER BY bidamount DESC";
        $query = $this->db->query($sql);
        if ($this->db->numrows($query) > 0) {

            $result = array();
            while ($row = $this->db->fetch($query)) {

                foreach ($row as $k => $v) {

                    $result[$row['bidid']][$k] = $v;
                }
            }
            return $result;
        } else {

            return false;
        }
    }

    function loadListBidForBuyer($userId, $filters)
    {
        require_once(ROOT . DS . 'application/models/product_model.php');
        $productModel = new Product_Model();

        $sql = "select a.*, b.post_title, b.post_status
                from " . DB_PRE . "bid_report as a, " . DB_PRE . "posts as b
                where a.productid = b.ID
                and b.post_type = 'product'
                and a.bidder = " . $userId . "
                ORDER BY a.biddatetime DESC";
        // init page navigation
        if (isset($filters['page'])) {

            $page = $filters['page'];
        } else
            $page = 1;
        // set append
        if ( isset ($filters) ) {

            // set append
            $append = '';
            foreach ($filters as $k => $v) {

                if ($k !== 'page') {

                    $append .= $k . '=' . $v . ';';
                }
            }
            $append = rtrim($append, ';');
        }
        $url = URL::get_site_url() . '/admin/dashboard/mybids';
        $pager = new PageNavigation($sql, 4, 5, $url, $page, $append, 'backend');

        // get sql added limit
        $newSql = $pager->paginate();

        if ($newSql == false)
            return false;

        /** check for ended product */
        $productModel->checkProductWhenDueDate();

        $query = $this->db->query($newSql);
        $result = array();
        while ($row = $this->db->fetch($query)) {

            foreach ($row as $k => $v) {

                $result[$row['bidid']][$k] = $v;
            }
            // get product top bid
            $result[$row['bidid']]['top_bid'] = $productModel->getProductTopBid( $row['productid'] );
        }

        // render navigation
        $result['navigation'] = $pager->renderFullNav( '<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>' );
        return $result;
    }
}