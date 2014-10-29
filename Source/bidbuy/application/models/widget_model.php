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

    function related_post( $postId, $categorySlug )
    {
        // get 5 posts in the category
        $sql = "SELECT ID
                FROM " . DB_PRE . "posts, (SELECT " . DB_PRE . "term_relationships.object_id
                                FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy, " . DB_PRE . "term_relationships
                                WHERE " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                                    AND " . DB_PRE . "term_taxonomy.term_taxonomy_id = " . DB_PRE . "term_relationships.term_taxonomy_id
                                    AND " . DB_PRE . "terms.slug = '". $categorySlug ."') AS tb1
                WHERE " . DB_PRE . "posts.ID = tb1.object_id
                    AND " . DB_PRE . "posts.post_status = 'publish'
                    AND tb1.object_id != " . $postId . "
                ORDER BY " . DB_PRE . "posts.post_date
                LIMIT 5";
        $query = $this->db->query($sql);
        // check if no have post
        if ($this->db->numrows($query) > 0) {

            $posts = array();
            while ($row = $this->db->fetch($query)) {

                // create an array to hold the post id
                $posts[] = $row['ID'];
            }
            // get post information
            $postInfo = $this->getPostInfo($posts);
            return $postInfo;
        } else // if no have post
            return false;
    }

    function getPostInfo($posts)
    {
        require_once(ROOT . DS . 'application/models/post_model.php');
        $postModel = new Post_Model();
        $postInfo = array(); // store all post information
        foreach ($posts as $k => $v) {

            $postInfo[$v] = array();
            $postInfo[$v] = $postModel->getPostInfo($v);
        }
        return $postInfo;
    }
}