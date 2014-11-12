<?php

class Product_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        // Database connect
        $this->db->connect();
    }

    /**
     * insert new product
     * @param $data
     * @return id
     */
    function insert($data)
    {
        $table = DB_PRE . "posts";
        if ($postId = $this->db->insert($table, $data)) {

            // return new post ID
            return $postId;
        } else {

            // alert user this error
            $_SESSION['ssbidbuy']['db_error'] = true;
            URL::goBack();
        }
    }

    /**
     * update product info
     * @param $productId
     * @param $data
     * @return bool
     */
    function update($productId, $data)
    {
        $table = DB_PRE . "posts";
        $where = 'ID = ' . $productId;
        if ($this->db->update($table, $data, $where))
            return true;
        return false;
    }

    /**
     * add product meta
     * @param $data
     * @return bool
     */
    function addMeta($data)
    {
        $table = DB_PRE . "postmeta";
        $sql = "SELECT meta_value FROM " . $table . " WHERE post_id = '" . $data['post_id'] . "' AND meta_key = '" . $data['meta_key'] . "'";
        $query = $this->db->query($sql);
        if ($this->db->numrows($query) > 0) {

            $sql = "UPDATE " . $table . " SET meta_value = '" . $data['meta_value'] . "' WHERE meta_key = '" . $data['meta_key'] . "' AND post_id = " . $data['post_id'];
            if ($this->db->query($sql))
                return true;
        } else {

            if ($this->db->insert($table, $data))
                return true;
        }
        return false;
    }

    /**
     * find a product
     * @param $productId
     * @return bool
     */
    function isExistProduct($productId)
    {
        $sql = "SELECT * FROM " . DB_PRE . "posts WHERE ID = " . $productId;
        $q = $this->db->query($sql);

        if ($this->db->numrows($q) > 0)
            return true;
        return false;
    }

    /**
     * change product status to trash
     * @param $productId
     * @return bool
     */
    function delete($productId)
    {
        $table = DB_PRE . 'posts';
        $data = array(
            'post_status' => 'trash'
        );
        $where = "ID = " . $productId;

        if ($this->db->update($table, $data, $where))
            return true;
        return false;
    }

    /**
     * return serialize string of gallery array
     * @param $productId
     * @return mixed
     */
    function getGallery($productId)
    {
        $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE post_id = " . $productId . " AND meta_key = 'product_gallery'";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        return $result['meta_value'];
    }

    /**
     * return smallest step for pricing step config
     */
    function suggestSmallNumber()
    {
        // get min smaller_number
        $sql = "SELECT max(max) as smaller_number FROM " . DB_PRE . "product_step";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        if ($result['smaller_number'] == null)
            echo 0;
        else
            echo $result['smaller_number'];
    }

    /**
     * get max stt in pricing step
     * @return int
     */
    function getMaxStt()
    {
        $sql = "SELECT max(stt) as max FROM " . DB_PRE . "product_step";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);

        $stt = 0;
        if ($result['max'] != null) {

            $stt = $result['max'];
        }

        return $stt;
    }

    /**
     * find -8 number in pricing step
     * @return bool
     */
    function findLastedPricingStep()
    {
        $sql = "SELECT stt FROM " . DB_PRE . "product_step WHERE max = -8";
        $query = $this->db->query($sql);

        if ($this->db->numrows($query) > 0) {
            return true;
        }
        return false;
    }

    /**
     * return pricing step for add new product
     * @param $price
     * @return string
     */
    function suggestPricingStep($price)
    {
        // get valid step for this price
        $sql = "SELECT * FROM " . DB_PRE . "product_step WHERE min < " . $price . " AND " . $price . " <= max";
        $query = $this->db->query($sql);

        if ($this->db->numrows($query) > 0) {

            $result = $this->db->fetch($query);
        } else {

            $sql = "SELECT * FROM " . DB_PRE . "product_step WHERE stt = " . $this->getMaxStt();
            $query = $this->db->query($sql);

            $result = $this->db->fetch($query);
        }

        return json_encode($result);
    }

    /**
     * add new pricing step to database
     * @param $stt
     * @param $data
     * @return bool|mysqli_result
     */
    function newPricingStep($stt, $data)
    {
        $sql = "INSERT INTO `" . DB_PRE . "product_step`
                (`stt`,
                `min`,
                `max`,
                `step`)
                VALUES
                ('" . $stt . "',
                '" . $data['min'] . "',
                '" . $data['max'] . "',
                '" . $data['step'] . "');";
        if ($id = $this->db->query($sql))
            return $id;
        return false;
    }

    /**
     * edit pricing step
     * @param $data
     * @return bool
     */
    function updatePricingStep($data)
    {
        // update max value for previous step
        if ($data['stt'] != 0) { // if this is not first step

            $sql = "UPDATE `" . DB_PRE . "product_step`
                    SET
                    `max` = " . $data['min'] . "
                    WHERE `stt` = " . ($data['stt'] - 1);
            $this->db->query($sql);
        }

        // update min value for next step
        if ($data['stt'] <= $this->getMaxStt()) { // if this is not lasted step

            $sql = "UPDATE `" . DB_PRE . "product_step`
                    SET
                    `min` = " . $data['max'] . "
                    WHERE `stt` = " . ($data['stt'] + 1);
            $this->db->query($sql);
        }
        // update this step
        $sql = "UPDATE `" . DB_PRE . "product_step`
                SET
                `min` = " . $data['min'] . ",
                `max` = " . $data['max'] . ",
                `step` = " . $data['step'] . "
                WHERE `ID` = " . $data['id'];
        if ($this->db->query($sql))
            return true;
        return false;
    }

    /**
     * delete pricing step in config
     * @param $stepId
     * @return bool
     */
    function deletePricingStep($stepId)
    {
        // get stt of step
        $sql = "SELECT * FROM " . DB_PRE . "product_step WHERE ID = " . $stepId;
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        // delete this step
        $sql = "DELETE FROM `" . DB_PRE . "product_step`
                WHERE ID = " . $stepId;
        $this->db->query($sql);

        if ($result['stt'] != $this->getMaxStt()) {

            // set max value of previous step for min value of next step
            if ($result['stt'] != 0) { // if this is not first step

                // get max value previous step
                $sql = "SELECT max FROM " . DB_PRE . "product_step WHERE stt = " . ($result['stt'] - 1);
                $query = $this->db->query($sql);
                $res = $this->db->fetch($query);
                // set min value for next step
                $sql = "UPDATE `" . DB_PRE . "product_step`
                        SET
                        `min` = " . $res['max'] . "
                        WHERE `stt` = " . ($result['stt'] + 1);
                $this->db->query($sql);
            }

            // rearrangement
            $range = $this->getMaxStt() - $result['stt'];
            for ($i = 0; $i < $range; $i++) {

                $sql = "UPDATE `" . DB_PRE . "product_step`
                        SET
                        `stt` = " . ($result['stt'] + $i) . "
                        WHERE `stt` = " . ($result['stt'] + $i + 1);
                $this->db->query($sql);
            }
        }

        return true;
    }

    /**
     * get details pricing step
     * @param $stepId
     * @return array|bool
     */
    function getPricingStepDetail($stepId)
    {
        $sql = "SELECT * FROM " . DB_PRE . "product_step WHERE ID = " . $stepId;
        $query = $this->db->query($sql);

        if ($this->db->numrows($query) > 0) {

            $details = $this->db->fetch($query);
            return $details;
        }
        return false;
    }

    /**
     * get all month year from product archive (post_date)
     * @param $type
     * @return array
     */
    function getArchives( $type = 'product' )
    {
        $time = new timer();
        $sql = "SELECT DISTINCT post_date FROM " . DB_PRE . "posts WHERE post_type = '". $type ."';";
        $query = $this->db->query($sql);

        $archives = array();
        while ($row = $this->db->fetch($query)) {

            $archives[] = $time->timeFormat($row['post_date'], 'd M Y');
        }
        $archives = array_unique($archives);
        return $archives;
    }

    /**
     * return all list products and information after checking due time
     * @param $filters hold all filter
     * @param $type
     * @return array|bool
     */
    function getAllProducts($filters, $type = 'backend')
    {
        if (isset ($filters['cat'])) {

            $sql = "select ID, post_author, post_title, post_status
                    from " . DB_PRE . "posts, " . DB_PRE . "term_relationships, " . DB_PRE . "term_taxonomy
                    where " . DB_PRE . "term_taxonomy.term_taxonomy_id = " . DB_PRE . "term_relationships.term_taxonomy_id
                    and " . DB_PRE . "term_relationships.object_id = " . DB_PRE . "posts.ID
                    and " . DB_PRE . "term_taxonomy.term_id = " . $filters['cat'];

            // if you are a seller, list only your product on this category
            if (!isset($_SESSION)) {

                if (UserInfo::getUserId() != 1) {

                    $sql .= " and post_author = '" . UserInfo::getUserId() . "'";
                }
            }
        } elseif (isset($filters['tab'])) {

            if ($filters['tab'] === 'top-bid') {

                $sql = "SELECT count(*) as num, " . DB_PRE . "posts.ID, " . DB_PRE . "posts.post_author, " . DB_PRE . "posts.post_title, " . DB_PRE . "posts.post_status
                        FROM " . DB_PRE . "bid_report, " . DB_PRE . "posts
                        WHERE " . DB_PRE . "bid_report.productid = " . DB_PRE . "posts.ID
                        AND " . DB_PRE . "posts.post_status = 'on-process'
                        AND " . DB_PRE . "posts.post_type = 'product'
                        GROUP BY " . DB_PRE . "bid_report.productid
                        ORDER BY num DESC";
            } else {

                $sql = "SELECT " . DB_PRE . "posts.ID, " . DB_PRE . "posts.post_author, " . DB_PRE . "posts.post_title, " . DB_PRE . "posts.post_status
                        FROM " . DB_PRE . "postmeta, " . DB_PRE . "posts
                        WHERE meta_key = 'product_end_date' 
                        AND ABS( DATEDIFF(meta_value, NOW() ) ) != 0
                        AND " . DB_PRE . "postmeta.post_id = " . DB_PRE . "posts.ID
                        AND " . DB_PRE . "posts.post_status = 'on-process'
                        GROUP BY " . DB_PRE . "postmeta.post_id
                        ORDER BY ABS( DATEDIFF(meta_value, NOW() ) ) ASC";
            }
        } else {

            // get all product ID
            $sql = "select ID, post_author, post_title, post_status
                from " . DB_PRE . "posts
                where  " . DB_PRE . "posts.post_type = 'product'";
            // add product status filter
            if (isset ($filters['status'])) {

                $sql .= " and " . DB_PRE . "posts.post_status = '" . $filters['status'] . "'";
            }
            // add date time filter
            if (isset ($filters['archive'])) {

                $time = new timer();
                $t = $time->timeFormat($filters['archive'], 'Y-m-d');
                // add sql string
                $sql .= " and post_date like '" . $t . "%'";
            }
            // if you are a seller, list only your product
            if (isset($_SESSION) && $type === 'backend') {

                if (UserInfo::getUserId() != 1) {

                    $sql .= " and post_author = '" . UserInfo::getUserId() . "'";
                }
            }
            // add author filter
            if (isset ($filters['seller'])) {

                $sql .= " and " . DB_PRE . "posts.post_author = " . $filters['seller'] . "";
            }
            $sql .= " order by " . DB_PRE . "posts.post_date";
        }

        // init page navigation
        if (isset($filters['page'])) {

            $page = $filters['page'];
        } else
            $page = 1;
        // set append
        if (isset ($filters)) {

            // set append
            $append = '';
            foreach ($filters as $k => $v) {

                if ($k !== 'page') {

                    $append .= $k . '=' . $v . ';';
                }
            }
            $append = rtrim($append, ';');
        }
        $url = URL::get_site_url() . '/admin/dashboard/products';
        if ($type === 'frontend')
            $url = URL::curURL();

        $pager = new PageNavigation($sql, 4, 5, $url, $page, $append, $type);

        // get sql added limit
        $newSql = $pager->paginate();

        if ($newSql == false)
            return false;

        /** check for ended product */
        $this->checkProductWhenDueDate();

        $query = $this->db->query($newSql);
        // get all products information
        $products = array();
        while ($row = $this->db->fetch($query)) {

            $products[$row['ID']]['product_title'] = $row['post_title'];
            // get author information
            $s = "select username
                from " . DB_PRE . "login_users
                where user_id = " . $row['post_author'];
            $q = $this->db->query($s);
            $r = $this->db->fetch($q);
            $products[$row['ID']]['product_author'] = array(

                'id' => $row['post_author'],
                'name' => $r['username']
            );
            $products[$row['ID']]['product_status'] = $row['post_status'];
            // get product category
            $sql = "select " . DB_PRE . "terms.term_id, " . DB_PRE . "terms.name
                    from " . DB_PRE . "terms, " . DB_PRE . "term_relationships, " . DB_PRE . "term_taxonomy
                    where " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                        and " . DB_PRE . "term_taxonomy.term_taxonomy_id = " . DB_PRE . "term_relationships.term_taxonomy_id
                        and " . DB_PRE . "term_relationships.object_id = " . $row['ID'];
            $q = $this->db->query($sql);
            $res = $this->db->fetch($q);
            $products[$row['ID']]['product_category'] = array(

                'id' => $res['term_id'],
                'name' => $res['name']
            );
            // get meta value
            $sql = "SELECT *
                    FROM " . DB_PRE . "postmeta
                    WHERE post_id = " . $row['ID'];
            $q = $this->db->query($sql);
            while ($r = $this->db->fetch($q)) {

                $products[$row['ID']][$r['meta_key']] = $r['meta_value'];
            }

            // get product top bid
            $products[$row['ID']]['product_top_bid'] = $this->getProductTopBid($row['ID']);

            // count number of bids
            $sql = "SELECT count(*) as num FROM " . DB_PRE . "bid_report WHERE productid = " . $row['ID'];
            $q = $this->db->query($sql);
            $products[$row['ID']]['number_of_bid'] = $this->db->fetch($q)['num'];
        }

        // render navigation
        $products['navigation'] = $pager->renderFullNav('<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>');
        return $products;
    }

    /**
     * get max bid amount for a product
     * @param $productId
     * @return int
     */
    function getProductTopBid($productId)
    {
        $topbid = 0;
        $sql = 'SELECT max(bidamount) as max FROM ' . DB_PRE . 'bid_report Where productid = ' . $productId;
        $qu = $this->db->query($sql);
        $max = $this->db->fetch($qu)['max'];
        if ($max != NULL)
            $topbid = $max;
        return $topbid;
    }

    /**
     * return all product information
     * @param $productId
     * @return array
     */
    function getProductInfo($productId)
    {
        /** is this product timeout */
        $this->checkSingleProductTimeout($productId);

        // get basic info
        $sql = "SELECT * FROM " . DB_PRE . "posts WHERE ID = " . $productId;
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $info = array(
            'product_id' => $result['ID'],
            'product_modified' => $result['post_date'],
            'product_content' => $result['post_content'],
            'product_title' => $result['post_title'],
            'product_status' => $result['post_status'],
            'product_name' => $result['post_name']
        );
        // get author info
        $sql = "SELECT name, email FROM " . DB_PRE . "login_users WHERE user_id = " . $result['post_author'];
        $q = $this->db->query($sql);
        $res = $this->db->fetch($q);
        $info['product_author'] = array(
            'id' => $result['post_author'],
            'name' => $res['name'],
            'email' => $res['email']
        );
        // get feature image
        $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE post_id = " . $productId . " AND meta_key = 'feature_img'";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $info['product_feature_img'] = $result['meta_value'];
        // get gallery image
        $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE post_id = " . $productId . " AND meta_key = 'product_gallery'";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $info['product_gallery'] = unserialize($result['meta_value']);
        // get more product meta
        $sql = "SELECT *
                    FROM " . DB_PRE . "postmeta
                    WHERE post_id = " . $productId;
        $q = $this->db->query($sql);
        while ($r = $this->db->fetch($q)) {

            if ($r['meta_key'] === 'product_timeout')
                $info[$r['meta_key']] = unserialize($r['meta_value']);
            else
                $info[$r['meta_key']] = $r['meta_value'];
        }

        // get list taxonomy
        $sql = "SELECT " . DB_PRE . "terms.term_id, " . DB_PRE . "term_taxonomy.taxonomy, " . DB_PRE . "terms.name, " . DB_PRE . "terms.slug
                FROM (" . DB_PRE . "term_relationships INNER JOIN " . DB_PRE . "term_taxonomy ON " . DB_PRE . "term_relationships.term_taxonomy_id = " . DB_PRE . "term_taxonomy.term_taxonomy_id) INNER JOIN " . DB_PRE . "terms ON " . DB_PRE . "term_taxonomy.term_id = " . DB_PRE . "terms.term_id
                WHERE object_id = " . $productId;
        $query = $this->db->query($sql);
        while ($terms = $this->db->fetch($query)) {
            if ($terms['taxonomy'] == 'category')
                $info['category'][] = array(
                    'id' => $terms['term_id'],
                    'name' => $terms['name'],
                    'slug' => $terms['slug']
                );
        }

        // get product top bid
        $info['product_top_bid'] = $this->getProductTopBid($productId);

        // count number of bids
        $sql = "SELECT count(*) as num FROM " . DB_PRE . "bid_report WHERE productid = " . $productId;
        $q = $this->db->query($sql);
        $info['number_of_bid'] = $this->db->fetch($q)['num'];

        return $info;
    }

    /**
     * Return all post information by slug
     * @param $categorySlug
     * @param $productSlug
     * @return array|bool information | can not get the post
     */
    function getProductInfoBySlug($categorySlug, $productSlug)
    {
        $productId = $this->getProductIdBySlug($productSlug);
        // if post is exist
        if ($productId != false)
            return $postInfo = $this->getProductInfo($productId);
        else
            return false;
    }

    /**
     * Return post ID by slug
     * @param $productSlug
     * @return bool|string can not get post | ID
     */
    function getProductIdBySlug($productSlug)
    {
        $sql = "SELECT ID FROM " . DB_PRE . "posts WHERE post_name = BINARY '" . $productSlug . "'";
        $query = $this->db->query($sql);
        // check is post already existed
        if ($this->db->numrows($query) == 0)
            return false;
        $res = $this->db->fetch($query);
        return $res['ID'];
    }

    /**
     * Increment post view when user access post url
     * @param $productId
     */
    function incProductView($productId)
    {

        $sql = "SELECT * FROM " . DB_PRE . "postmeta WHERE meta_key = 'post_viewer_count' AND post_id = " . $productId;
        $query = $this->db->query($sql);
        // check if the post is first update
        if ($this->db->numrows($query) > 0) {

            $update = "UPDATE " . DB_PRE . "postmeta
                SET meta_value = meta_value + 1
                WHERE meta_key = 'product_viewer_count' AND post_id = " . $productId;
            $this->db->query($update);
        } else {
            $insert = "INSERT INTO " . DB_PRE . "postmeta (post_id, meta_key, meta_value)
                        VALUES (" . $productId . ", 'product_viewer_count', '1')";
            $this->db->query($insert);
        }
    }

    /**
     * check timeout for all product when page load
     */
    function checkProductWhenDueDate()
    {
        $time = new timer();
        // query string to get all product
        $sql = "SELECT a.post_id
                FROM " . DB_PRE . "postmeta as a, " . DB_PRE . "posts as b
                WHERE a.post_id = b.ID
                and b.post_status != 'timeout'
                and meta_key = 'product_end_date'
                AND meta_value <= '" . $time->getDateTime() . "'";
        $query = $this->db->query($sql);
        while ($row = $this->db->fetch($query)) {

            // change status to timeout
            $this->changeProductStatus($row['post_id'], 'timeout');
            // create orders for product
            $this->createOrder( $row['post_id'] );
        }
    }

    /**
     * check product timeout
     * @param $productId
     */
    function checkSingleProductTimeout($productId)
    {
        $time = new timer();
        $sql = "SELECT count(*) as num FROM " . DB_PRE . "posts WHERE post_status != 'timeout' AND ID = " . $productId;
        $query = $this->db->query($sql);
        $count = $this->db->fetch($query);
        if ($count['num'] > 0) {

            // query string to check due date
            $sql = "SELECT post_id
                FROM " . DB_PRE . "postmeta
                WHERE meta_key = 'product_end_date'
                AND meta_value <= '" . $time->getDateTime() . "'
                AND post_id = " . $productId;
            $q = $this->db->query($sql);
            while ($row = $this->db->fetch($q)) {

                $this->changeProductStatus($row['post_id'], 'timeout');
                // create orders for product
                $this->createOrder( $row['post_id'] );
            }
        }
    }

    function createOrder( $productId )
    {
        /** get information to insert order meta */
        // get customer id
        $sql = 'SELECT bidder, bidamount
                FROM ' . DB_PRE . 'bid_report
                where bidamount = (select max(bidamount) from ' . DB_PRE . 'bid_report where productid = ' . $productId . ')
                and productid = ' . $productId;
        $query = $this->db->query($sql);

        /** check if product no have bid */
        if ( $this->db->numrows( $query ) > 0 ) {

            $res = $this->db->fetch($query);
            $cusID = $res['bidder'];
            $price = $res['bidamount'];

            // get product seller
            $sql = "SELECT post_author FROM " . DB_PRE . "posts WHERE ID = " . $productId;
            $query = $this->db->query($sql);
            $author = $this->db->fetch($query)['post_author'];

            // get this time
            $timer = new timer();
            $now = $timer->getDateTime();

            // prepare data
            $data = array(
                'post_author' => $author,
                'post_date' => $now,
                'post_status' => 'awaiting',
                'post_modified' => $now,
                'post_type' => 'orders'
            );

            // insert order to db
            $table = DB_PRE . 'posts';
            $orderId = $this->db->insert($table, $data);

            // get user information
            $sql = "SELECT name FROM " . DB_PRE . "login_users WHERE user_id = " . $cusID;
            $queryid = $this->db->query($sql);
            $userInfo = $this->db->fetch( $queryid );

            $meta = array(
                'phone_num' => '',
                'address' => '',
                'city' => '',
                'country' => '',
            );
            foreach ($meta as $key => $value) {
                $sql = "SELECT meta_value FROM " . DB_PRE . "members_meta WHERE meta_key = '" . $key . "' AND user_id =" . $cusID;
                $q = $this->db->query($sql);
                $res = $this->db->fetch($q);
                $userMeta[$key] = $res['meta_value'];
            }
            // user address
            $address = array(
                0 => $userInfo['name'],
                1 => $userMeta['address'],
                2 => $userMeta['city'],
                3 => $userMeta['country'],
                4 => $userMeta['phone_num']
            );

            // product information
            $sql = "SELECT post_title FROM " . DB_PRE . "posts WHERE ID = " . $productId;
            $query = $this->db->query($sql);
            $productName = $this->db->fetch($query)['post_title'];
            $product = array(
                'id' => $productId,
                'name' => $productName,
                'price' => $price
            );

            // prepare meta data
            $metas = array(
                'custID' => $cusID,
                'order_shipping' => serialize($address),
                'order_summary' => serialize($product)
            );

            foreach ($metas as $k => $v) {

                $sql = "INSERT INTO " . DB_PRE . "postmeta(`post_id`,
                                                        `meta_key`,
                                                        `meta_value`)
                                                        VALUES
                                                        (" . $orderId . ",
                                                        '" . $k . "',
                                                        '" . $v . "');";
                $this->db->query( $sql );
            }
        }
    }

    function getAllOrders( $filters, $user = 'seller', $type = 'backend' )
    {
        $sql = '';
        if ( $user === 'seller' ) {

            $sql = 'select a.ID, a.post_author, a.post_date, a.post_status, a.post_type
                from '. DB_PRE .'posts as a
                where post_type = "orders"
                and post_author = ' . UserInfo::getUserId();

            // add date time filter
            if (isset ($filters['archive'])) {

                $time = new timer();
                $t = $time->timeFormat($filters['archive'], 'Y-m-d');
                // add sql string
                $sql .= ' and post_date like "' . $t . '%"';
            }

            $sql .= ' order by post_date DESC';

        } else {

            $sql = "select a.ID, a.post_author, a.post_date, a.post_status, a.post_type
                    from bbv_posts as a, bbv_postmeta as b
                    where a.post_type = 'orders'
                    and b.meta_key = 'custID'
                    and b.meta_value = ". UserInfo::getUserId() ."
                    and a.ID = b.post_id";
            // add date time filter
            if (isset ($filters['archive'])) {

                $time = new timer();
                $t = $time->timeFormat($filters['archive'], 'Y-m-d');
                // add sql string
                $sql .= ' and a.post_date like "' . $t . '%"';
            }

            $sql .= ' order by a.post_date DESC';
        }

        // init page navigation
        if (isset($filters['page'])) {

            $page = $filters['page'];
        } else
            $page = 1;
        // set append
        if (isset ($filters)) {

            // set append
            $append = '';
            foreach ($filters as $k => $v) {

                if ($k !== 'page') {

                    $append .= $k . '=' . $v . ';';
                }
            }
            $append = rtrim($append, ';');
        }
        $url = URL::get_site_url() . '/admin/dashboard/orders';

        $pager = new PageNavigation($sql, 4, 5, $url, $page, $append, 'backend');

        // get sql added limit
        $newSql = $pager->paginate();

        if ( $newSql === FALSE )
            return false;

        $query = $this->db->query( $newSql );

        $orders = array();
        while( $row = $this->db->fetch( $query ) ) {

            // get simple information
            foreach ( $row as $k => $v ) {

                $orders[$row['ID']][$k] = $v;
            }
            // get meta value
            $sql = "SELECT * FROM ". DB_PRE ."postmeta where post_id = " . $row['ID'];
            $q = $this->db->query( $sql );
            while ( $r = $this->db->fetch( $q ) ) {

                $orders[$row['ID']][$r['meta_key']] = $r['meta_value'];
            }

            // get seller name
            $sql = "SELECT name FROM ". DB_PRE ."login_users WHERE user_id = " . $row['post_author'];
            $q = $this->db->query( $sql );
            $orders[$row['ID']]['author_name'] = $this->db->fetch( $q )['name'];
        }
        $orders['navigation'] = $pager->renderFullNav('<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>');
        return $orders;
    }

    function getOrder( $orderId )
    {
        $sql = "SELECT a.ID, a.post_author, a.post_date, a.post_status, a.post_type FROM ". DB_PRE ."posts as a WHERE ID = " . $orderId;
        $query = $this->db->query( $sql );

        if ( $this->db->numrows( $query ) == 0 )
            return false;

        $result = $this->db->fetch( $query );

        $order = array();
        // get simple information
        foreach ( $result as $k => $v ) {

            $orders[$k] = $v;
        }

        // get meta value
        $sql = "SELECT * FROM ". DB_PRE ."postmeta where post_id = " . $orderId;
        $q = $this->db->query( $sql );
        while ( $r = $this->db->fetch( $q ) ) {

            $order[$r['meta_key']] = $r['meta_value'];
        }

        return $order;
    }

    /**
     * change status to $status
     * @param $productId
     * @param $status
     * @return bool
     */
    function changeProductStatus($productId, $status)
    {
        $sql = "UPDATE " . DB_PRE . "posts SET post_status = '" . $status . "' WHERE ID = " . $productId;
        if ($this->db->query($sql))
            return true;
        else
            return false;
    }

    /**
     * create product_end_date meta when administrator active this product
     * @param $productId
     * @return bool
     */
    function createEndDate($productId)
    {
        $time = new timer();
        // get during time
        $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE meta_key = 'product_timeout' AND post_id = " . $productId;
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $timeout = unserialize($result['meta_value']);
        $string = '+' . $timeout[0] . ' days +' . $timeout[1] . 'hours +' . $timeout[2] . 'minutes';
        // set end date
        $endDate = $time->add($string);
        // add meta
        $meta = array(
            'post_id' => $productId,
            'meta_key' => 'product_end_date',
            'meta_value' => $endDate
        );
        if ($this->addMeta($meta))
            return true;
        return false;
    }
}