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

    function findLastedPricingStep()
    {
        $sql = "SELECT stt FROM ". DB_PRE ."product_step WHERE max = -8";
        $query = $this->db->query( $sql );

        if ( $this->db->numrows( $query ) > 0 ) {
            return true;
        }
        return false;
    }

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
}