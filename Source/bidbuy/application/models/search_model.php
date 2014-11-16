<?php

class Search_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        // Database connect
        $this->db->connect();
    }

    function searchKeyOnly( $key )
    {
        require_once(ROOT . DS . 'application/models/product_model.php');
        $productModel = new Product_Model();

        $sql = "SELECT ID
                FROM ". DB_PRE ."posts
                WHERE post_type = 'product'
                and post_status = 'on-process'
                and ( (`post_title` LIKE '%".$key."%') OR (`ID` LIKE '%".$key."%') )";

        // init page navigation
        if (isset($_GET['page'])) {

            $page = $_GET['page'];
        } else
            $page = 1;

        $pager = new PageNavigation($sql, 16, 5, URL::curURL(), $page, '', 'search');

        // get sql added limit
        $newSql = $pager->paginate();
        if ($newSql == false)
            return false;

        /** check for ended product */
        $productModel->checkProductWhenDueDate();

        // execute query
        $query = $this->db->query( $newSql );
        // get result
        $result = array();
        while ( $row = $this->db->fetch( $query ) ) {

            $id = $row['ID'];
            $result[$id] = $productModel->getProductInfo( $id );
        }
        $result['navigation'] = $pager->renderFullNav('<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>');
        return $result;
    }

    function searchInCategory( $key, $category )
    {
        require_once(ROOT . DS . 'application/models/product_model.php');
        $productModel = new Product_Model();

        // get all product in category
        $sql = "SELECT t1.object_id
                FROM bbv_term_relationships as t1, bbv_term_taxonomy as t2, bbv_posts as t3
                WHERE t1.term_taxonomy_id = t2.term_taxonomy_id
                AND t3.ID = t1.object_id
                AND t3.post_type = 'product'
                AND t3.post_status = 'on-process'
                AND t2.term_id = " . $category;

        // init page navigation
        if (isset($_GET['page'])) {

            $page = $_GET['page'];
        } else
            $page = 1;

        $pager = new PageNavigation($sql, 16, 5, URL::curURL(), $page, '', 'search');

        // get sql added limit
        $newSql = $pager->paginate();
        if ($newSql == false)
            return false;

        /** check for ended product */
        $productModel->checkProductWhenDueDate();

        // execute query
        $query = $this->db->query( $newSql );

        $result = array();
        while ( $row = $this->db->fetch( $query ) ) {

            if ( $key !== '' ) {

                $sql = "SELECT ID
                    FROM ". DB_PRE ."posts
                    WHERE ID = ". $row['object_id'] ."
                    AND ( (`post_title` LIKE '%".$key."%') OR (`ID` LIKE '%".$key."%') )";
                $q = $this->db->query( $sql );
                $ID = $this->db->fetch( $q )['ID'];
                if ( $ID !== NULL )
                    $result[$ID] = $productModel->getProductInfo( $ID );
            } else {

                $result[$row['object_id']] = $productModel->getProductInfo( $row['object_id'] );
            }
        }
        $result['navigation'] = $pager->renderFullNav('<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>');
        return $result;
    }
}