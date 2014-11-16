<?php

class Widget_Model extends Model
{

    // constructor
    function __construct()
    {

        parent::__construct();
        $this->db->connect();
    }

    /**
     * Return information for popular posts
     * @param string $type set type for this widget
     * @return array|bool
     */
    function postWidget($type)
    {

        $sql = '';
        if ($type === 'popular_post') {

            // get list most popular post id
            $sql = "SELECT post_id
                    FROM " . DB_PRE . "postmeta, " . DB_PRE . "posts
                    WHERE meta_key = 'post_viewer_count'
                    AND " . DB_PRE . "posts.post_status = 'publish'
                    AND " . DB_PRE . "posts.ID = " . DB_PRE . "postmeta.post_id
                    ORDER BY meta_value DESC
                    LIMIT 6";
        } elseif ($type === 'lasted_post') {


            // get 6 lasted posts Id
            $sql = "SELECT ID
                FROM " . DB_PRE . "posts
                WHERE post_status = 'publish' AND post_type = 'blog_post'
                ORDER BY post_date DESC
                LIMIT 6";
        }
        $query = $this->db->query($sql);
        // if have post
        if ($this->db->numrows($query) != 0) {

            // create array hold all post id sort by number of viewer
            $posts = array();
            while ($row = $this->db->fetch($query)) {

                if ($type === 'popular_post')
                    $posts[] = $row['post_id'];
                elseif ($type === 'lasted_post')
                    $posts[] = $row['ID'];
            }
            // get post information for each post
            $postInfo = $this->getPostInfo($posts);
            return $postInfo;
        } else { // else no post

            return false;
        }
    }

    function related_product($productId, $categorySlug)
    {
        // get 4 posts in the category
        $sql = "SELECT ID
                FROM " . DB_PRE . "posts, (SELECT " . DB_PRE . "term_relationships.object_id
                                FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy, " . DB_PRE . "term_relationships
                                WHERE " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                                    AND " . DB_PRE . "term_taxonomy.term_taxonomy_id = " . DB_PRE . "term_relationships.term_taxonomy_id
                                    AND " . DB_PRE . "terms.slug = '" . $categorySlug . "') AS tb1
                WHERE " . DB_PRE . "posts.ID = tb1.object_id
                    AND " . DB_PRE . "posts.post_status = 'on-process'
                    AND tb1.object_id != " . $productId . "
                    AND " . DB_PRE . "posts.post_type = 'product'
                ORDER BY " . DB_PRE . "posts.post_date
                LIMIT 4";
        $query = $this->db->query($sql);
        // check if no have post
        if ($this->db->numrows($query) > 0) {

            $products = array();
            while ($row = $this->db->fetch($query)) {

                // create an array to hold the post id
                $products[] = $row['ID'];
            }
            // get post information
            $productInfo = $this->getProductInfo($products);
            return $productInfo;
        } else // if no have post
            return false;
    }

    function getProductInfo($productId)
    {
        require_once(ROOT . DS . 'application/models/product_model.php');
        $productModel = new Product_Model();
        $productInfo = array(); // store all post information
        foreach ($productId as $k => $v) {

            $productInfo[$v] = array();
            $productInfo[$v] = $productModel->getProductInfo($v);
        }
        return $productInfo;
    }
}