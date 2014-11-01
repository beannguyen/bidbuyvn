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
    function insert( $data )
    {
        $table = DB_PRE . "posts";
        if ($postId = $this->db->insert($table, $data)) {

            // return new post ID
            return $postId;
        } else {

            // alert user this error
            $_SESSION['jigowatt']['db_error'] = true;
            URL::goBack();
        }
    }

    /**
     * update product info
     * @param $productId
     * @param $data
     * @return bool
     */
    function update( $productId, $data )
    {
        $table = DB_PRE . "posts";
        $where = 'ID = ' . $productId;
        if ( $this->db->update( $table, $data, $where ) )
            return true;
        return false;
    }

    /**
     * add product meta
     * @param $data
     * @return bool
     */
    function addMeta( $data )
    {
        $table = DB_PRE . "postmeta";
        $sql = "SELECT meta_value FROM " . $table . " WHERE post_id = '". $data['post_id'] ."' AND meta_key = '". $data['meta_key'] ."'";
        $query = $this->db->query( $sql );
        if ( $this->db->numrows( $query ) > 0 ) {

            $sql = "UPDATE " . $table . " SET meta_value = '" . $data['meta_value'] . "' WHERE meta_key = '" . $data['meta_key'] . "' AND post_id = " . $data['post_id'];
            if ( $this->db->query( $sql ) )
                return true;
        } else {

            if ( $this->db->insert( $table, $data ) )
                return true;
        }
        return false;
    }

    /**
     * find a product
     * @param $productId
     * @return bool
     */
    function isExistProduct( $productId )
    {
        $sql = "SELECT * FROM " . DB_PRE . "posts WHERE ID = " . $productId;
        $q = $this->db->query($sql);

        if ($this->db->numrows($q) > 0)
            return true;
        return false;
    }

    /**
     * return all product information
     * @param $productId
     * @return array
     */
    function getProductInfo( $productId )
    {
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
        $sql = "SELECT name FROM " . DB_PRE . "login_users WHERE user_id = " . $result['post_author'];
        $q = $this->db->query($sql);
        $res = $this->db->fetch($q);
        $info['product_author'] = array(
            'id' => $result['post_author'],
            'name' => $res['name']
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
        $info['product_gallery'] = unserialize( $result['meta_value'] );
        // get more product meta
        $key = array(
            0 => 'product_sku',
            1 => 'product_price',
            2 => 'product_price_step',
            3 => 'product_timeout',
        );
        // if product is on process, add product_end_date key
        if ( $info['product_status'] == 'on-process' )
            $key[] = 'product_end_date';
        // get value for all key
        foreach ( $key as $k => $v ) {

            $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE post_id = " . $productId . " AND meta_key = '". $v ."'";
            $query = $this->db->query($sql);
            $result = $this->db->fetch($query);
            if ( $v === 'product_timeout' ) {

                $info[$v] = unserialize($result['meta_value']);
            } else
                $info[$v] = $result['meta_value'];
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
        return $info;
    }

    /**
     * change product status to trash
     * @param $productId
     * @return bool
     */
    function delete( $productId )
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
    function getGallery( $productId )
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
        $sql = "SELECT max(max) as smaller_number FROM ". DB_PRE ."product_step";
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query );
        if ( $result['smaller_number'] == null )
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
        $sql = "SELECT max(stt) as max FROM ". DB_PRE ."product_step";
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query );

        $stt = 0;
        if ( $result['max'] != null ) {

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
        $sql = "SELECT stt FROM ". DB_PRE ."product_step WHERE max = -8";
        $query = $this->db->query( $sql );

        if ( $this->db->numrows( $query ) > 0 ) {
            return true;
        }
        return false;
    }

    /**
     * return pricing step for add new product
     * @param $price
     * @return string
     */
    function suggestPricingStep( $price )
    {
        // get valid step for this price
        $sql = "SELECT * FROM ". DB_PRE ."product_step WHERE min < ". $price ." AND ". $price ." <= max";
        $query = $this->db->query( $sql );

        if ( $this->db->numrows( $query ) > 0 ) {

            $result = $this->db->fetch( $query );
        } else {

            $sql = "SELECT * FROM ". DB_PRE ."product_step WHERE stt = " . $this->getMaxStt();
            $query = $this->db->query( $sql );

            $result = $this->db->fetch( $query );
        }

        return json_encode( $result );
    }

    /**
     * add new pricing step to database
     * @param $stt
     * @param $data
     * @return bool|mysqli_result
     */
    function newPricingStep( $stt, $data )
    {
        $sql = "INSERT INTO `". DB_PRE ."product_step`
                (`stt`,
                `min`,
                `max`,
                `step`)
                VALUES
                ('". $stt ."',
                '". $data['min'] ."',
                '". $data['max'] ."',
                '". $data['step'] ."');";
        if ($id = $this->db->query( $sql ) )
            return $id;
        return false;
    }

    /**
     * edit pricing step
     * @param $data
     * @return bool
     */
    function updatePricingStep( $data )
    {
        // update max value for previous step
        if ( $data['stt'] != 0 ) {  // if this is not first step

            $sql = "UPDATE `". DB_PRE ."product_step`
                    SET
                    `max` = ". $data['min'] ."
                    WHERE `stt` = " . ($data['stt'] - 1);
            $this->db->query( $sql );
        }

        // update min value for next step
        if ( $data['stt'] <= $this->getMaxStt() ) { // if this is not lasted step

            $sql = "UPDATE `". DB_PRE ."product_step`
                    SET
                    `min` = ". $data['max'] ."
                    WHERE `stt` = " . ($data['stt'] + 1);
            $this->db->query( $sql );
        }
        // update this step
        $sql = "UPDATE `". DB_PRE ."product_step`
                SET
                `min` = ". $data['min'] .",
                `max` = ". $data['max'] .",
                `step` = ". $data['step'] ."
                WHERE `ID` = ". $data['id'];
        if ( $this->db->query( $sql ) )
            return true;
        return false;
    }

    /**
     * delete pricing step in config
     * @param $stepId
     * @return bool
     */
    function deletePricingStep( $stepId )
    {
        // get stt of step
        $sql = "SELECT * FROM ". DB_PRE ."product_step WHERE ID = " . $stepId;
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query );
        // delete this step
        $sql = "DELETE FROM `". DB_PRE ."product_step`
                WHERE ID = " . $stepId;
        $this->db->query( $sql );

        if ( $result['stt'] != $this->getMaxStt() ) {

            // set max value of previous step for min value of next step
            if ( $result['stt'] != 0 ) { // if this is not first step

                // get max value previous step
                $sql = "SELECT max FROM ". DB_PRE ."product_step WHERE stt = " . ( $result['stt'] - 1 );
                $query = $this->db->query( $sql );
                $res = $this->db->fetch( $query );
                // set min value for next step
                $sql = "UPDATE `". DB_PRE ."product_step`
                        SET
                        `min` = ". $res['max'] ."
                        WHERE `stt` = ". ( $result['stt'] + 1 );
                $this->db->query( $sql );
            }

            // rearrangement
            $range = $this->getMaxStt() - $result['stt'];
            for ( $i = 0; $i < $range; $i++ ) {

                $sql = "UPDATE `". DB_PRE ."product_step`
                        SET
                        `stt` = ". ( $result['stt'] + $i ) ."
                        WHERE `stt` = " . ( $result['stt'] + $i + 1 );
                $this->db->query( $sql );
            }
        }

        return true;
    }

    /**
     * get details pricing step
     * @param $stepId
     * @return array|bool
     */
    function getPricingStepDetail( $stepId )
    {
        $sql = "SELECT * FROM ". DB_PRE ."product_step WHERE ID = " . $stepId;
        $query = $this->db->query( $sql );

        if ( $this->db->numrows( $query ) > 0 ) {

            $details = $this->db->fetch( $query );
            return $details;
        }
        return false;
    }

    /**
     * get all month year from product archive (post_date)
     * @return array
     */
    function getArchives()
    {
        $time = new timer();
        $sql = "SELECT DISTINCT post_date FROM ". DB_PRE ."posts WHERE post_type = 'product';";
        $query = $this->db->query( $sql );

        $archives = array();
        while ( $row = $this->db->fetch( $query ) ) {

            $archives[] = $time->timeFormat( $row['post_date'], 'd M Y' );
        }
        $archives = array_unique( $archives );
        return $archives;
    }

    /**
     * return all list products and information after checking due time
     * @param $filters
     * @return array|bool
     */
    function getAllProducts( $filters )
    {
        // get all product ID
        $sql = "select ID, post_author, post_title, post_status
                from ". DB_PRE ."posts
                where  ". DB_PRE ."posts.post_type = 'product'";
        // add product status filter
        if ( isset ( $filters['status'] ) ) {

            $sql .= " and ". DB_PRE ."posts.post_status = '". $filters['status'] ."'";
        }
        // add date time filter
        if ( isset ( $filters['archive'] ) ) {

            $time = new timer();
            $t = $time->timeFormat( $filters['archive'], 'Y-m-d' );
            // add sql string
            $sql .= " and post_date like '". $t ."%'";
        }
        // if you are a seller, list only your product
        if ( UserInfo::getUserId() != 1 ) {

            $sql .= " and post_author = '". UserInfo::getUserId() ."'";
        }
        // add author filter
        if ( isset ( $filters['seller'] ) ) {

            $sql .= " and ". DB_PRE ."posts.post_author = ". $filters['seller'] ."";
        }
        $sql .= " order by ". DB_PRE ."posts.post_date";

        if ( isset ( $filters['cat'] ) ) {

            $sql = "select ID, post_author, post_title, post_status
                    from bbv_posts, bbv_term_relationships, bbv_term_taxonomy
                    where bbv_term_taxonomy.term_taxonomy_id = bbv_term_relationships.term_taxonomy_id
                    and bbv_term_relationships.object_id = bbv_posts.ID
                    and bbv_term_taxonomy.term_id = " . $filters['cat'];
        }
        // if you are a seller, list only your product on this category
        if ( UserInfo::getUserId() != 1 ) {

            $sql .= " and post_author = '". UserInfo::getUserId() ."'";
        }

        // init page navigation
        if ( isset( $filters['page'] ) ) {

            $page = $filters['page'];
        } else
            $page = 1;
        // set append
        if ( isset ( $filters ) ) {

            // set append
            $append = '';
            foreach ( $filters as $k => $v ) {

                if ( $k !== 'page' ) {

                    $append .= $k . '=' . $v . ';';
                }
            }
            $append = rtrim( $append, ';' );
        }
        $pager = new PageNavigation( $sql, 10, 5, URL::get_site_url() . '/admin/dashboard/products', $page, $append );

        // get sql added limit
        $newSql = $pager->paginate();

        if ( $newSql == false )
            return false;

        /** check for ended product */
        $this->checkProductWhenDueDate();

        $query = $this->db->query( $newSql );
        // get all products information
        $products = array();
        while ( $row = $this->db->fetch( $query ) ) {

            $products[$row['ID']]['product_title'] = $row['post_title'];
            // get author information
            $s = "select username
                from ". DB_PRE ."login_users
                where user_id = " . $row['post_author'];
            $q = $this->db->query( $s );
            $r = $this->db->fetch( $q );
            $products[$row['ID']]['product_author'] = array(

                'id' => $row['post_author'],
                'name' => $r['username']
            );
            $products[$row['ID']]['product_status'] = $row['post_status'];
            // get product category
            $sql = "select ". DB_PRE ."terms.term_id, ". DB_PRE ."terms.name
                    from ". DB_PRE ."terms, ". DB_PRE ."term_relationships, ". DB_PRE ."term_taxonomy
                    where ". DB_PRE ."terms.term_id = ". DB_PRE ."term_taxonomy.term_id
                        and ". DB_PRE ."term_taxonomy.term_taxonomy_id = ". DB_PRE ."term_relationships.term_taxonomy_id
                        and ". DB_PRE ."term_relationships.object_id = " . $row['ID'];
            $q = $this->db->query( $sql );
            $res = $this->db->fetch( $q );
            $products[$row['ID']]['product_category'] = array(

                'id' => $res['term_id'],
                'name' => $res['name']
            );
            // get meta value
            $sql = "SELECT *
                    FROM ". DB_PRE ."postmeta
                    WHERE post_id = " . $row['ID'];
            $q = $this->db->query( $sql );
            while ( $r = $this->db->fetch( $q ) ) {

                $products[$row['ID']][$r['meta_key']] = $r['meta_value'];
            }
        }

        // render navigation
        $products['navigation'] = $pager->renderFullNav( '<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>' );
        return $products;
    }

    /**
     * check timeout for all product when page load
     */
    function checkProductWhenDueDate()
    {
        $time = new timer();
        // query string to get all product
        $sql = "SELECT post_id
                FROM ". DB_PRE ."postmeta
                WHERE meta_key = 'product_end_date'
                AND meta_value <= '". $time->getDateTime() ."'";
        $query = $this->db->query( $sql );
        while ( $row = $this->db->fetch( $query ) ) {

            $this->changeProductStatus( $row['post_id'], 'timeout' );
        }
    }

    /**
     * check product timeout
     * @param $productId
     */
    function checkSingleProductTimeout( $productId )
    {
        $time = new timer();
        $sql = "SELECT count(*) as num FROM ". DB_PRE ."posts WHERE post_status != 'timeout' AND ID = " . $productId;
        $query = $this->db->query( $sql );
        $count = $this->db->fetch( $query );
        if ( $count['num'] > 0 ) {

            // query string to check due date
            $sql = "SELECT post_id
                FROM ". DB_PRE ."postmeta
                WHERE meta_key = 'product_end_date'
                AND meta_value <= '". $time->getDateTime() ."'
                AND post_id = " . $productId;
            $q = $this->db->query( $sql );
            while ( $row = $this->db->fetch( $q ) ) {

                $this->changeProductStatus( $row['post_id'], 'timeout' );
            }
        }
    }

    /**
     * change status to $status
     * @param $productId
     * @param $status
     * @return bool
     */
    function changeProductStatus( $productId, $status )
    {
        $sql = "UPDATE ". DB_PRE ."posts SET post_status = '". $status ."' WHERE ID = " . $productId;
        if ( $this->db->query( $sql ) )
            return true;
        else
            return false;
    }

    /**
     * create product_end_date meta when administrator active this product
     * @param $productId
     * @return bool
     */
    function createEndDate( $productId )
    {
        $time = new timer();
        // get during time
        $sql = "SELECT meta_value FROM ". DB_PRE ."postmeta WHERE meta_key = 'product_timeout' AND post_id = " . $productId;
        $query = $this->db->query( $sql );
        $result = $this->db->fetch( $query );
        $timeout = unserialize( $result['meta_value'] );
        $string = '+' . $timeout[0] . ' days +' . $timeout[1] . 'hours +' . $timeout[2] . 'minutes';
        // set end date
        $endDate = $time->add( $string );
        // add meta
        $meta = array (
            'post_id' => $productId,
            'meta_key' => 'product_end_date',
            'meta_value' => $endDate
        );
        if ($this->addMeta( $meta ) )
            return true;
        return false;
    }
}