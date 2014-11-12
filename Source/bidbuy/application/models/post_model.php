<?php
class Post_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    /**
     * Return all post information by slug
     * @param $categorySlug
     * @param $postSlug
     * @return array|bool information | can not get the post
     */
    function getPostInfoBySlug($categorySlug, $postSlug)
    {
        $postId = $this->getPostIdBySlug($postSlug);
        // if post is exist
        if ( $postId != false )
            return $postInfo = $this->getPostInfo($postId);
        else
            return false;
    }

    /**
     * Return post ID by slug
     * @param $postSlug
     * @return bool|string can not get post | ID
     */
    function getPostIdBySlug($postSlug)
    {
        $sql = "SELECT ID FROM " . DB_PRE . "posts WHERE post_name = BINARY '" . $postSlug . "'";
        $query = $this->db->query($sql);
        // check is post already existed
        if ( $this->db->numrows( $query ) == 0 )
            return false;
        $res = $this->db->fetch($query);
        return $res['ID'];
    }

    /**
     * get all post information from db
     * @param $postId
     * @return array hold all information
     */
    function getPostInfo($postId)
    {
        // get basic info
        $sql = "SELECT * FROM " . DB_PRE . "posts WHERE ID = " . $postId;
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $info = array(
            'post_id' => $result['ID'],
            'post_modified' => $result['post_date'],
            'post_content' => $result['post_content'],
            'post_title' => $result['post_title'],
            'post_status' => $result['post_status'],
            'post_name' => $result['post_name']
        );
        // get author info
        $sql = "SELECT name FROM " . DB_PRE . "login_users WHERE user_id = " . $result['post_author'];
        $q = $this->db->query($sql);
        $res = $this->db->fetch($q);
        $info['post_author'] = array(
            'id' => $result['post_author'],
            'name' => $res['name']
        );
        // get feature image
        $sql = "SELECT meta_value FROM " . DB_PRE . "postmeta WHERE post_id = " . $postId . " AND meta_key = 'feature_img'";
        $query = $this->db->query($sql);
        $result = $this->db->fetch($query);
        $info['post_feature_img'] = $result['meta_value'];
        // get list taxonomy
        $sql = "SELECT " . DB_PRE . "terms.term_id, " . DB_PRE . "term_taxonomy.taxonomy, " . DB_PRE . "terms.name, " . DB_PRE . "terms.slug
                FROM (" . DB_PRE . "term_relationships INNER JOIN " . DB_PRE . "term_taxonomy ON " . DB_PRE . "term_relationships.term_taxonomy_id = " . DB_PRE . "term_taxonomy.term_taxonomy_id) INNER JOIN " . DB_PRE . "terms ON " . DB_PRE . "term_taxonomy.term_id = " . DB_PRE . "terms.term_id
                WHERE object_id = " . $postId;
        $query = $this->db->query($sql);
        $info['tag'] = '';
        while ($terms = $this->db->fetch($query)) {
            if ($terms['taxonomy'] == 'category')
                $info['category'][] = array(
                    'id' => $terms['term_id'],
                    'name' => $terms['name'],
                    'slug' => $terms['slug']
                );
            else
                $info['tag'] .= $terms['name'] . ',';
        }
        return $info;
    }

    /**
     * get all newest post ID from db
     * @return array
     */
    function getFeaturePost()
    {
        // get list recent post
        $sql = "SELECT " . DB_PRE . "posts.ID
                FROM " . DB_PRE . "posts
                WHERE post_status = 'publish' AND post_type = 'blog_post'
                ORDER BY post_date DESC
                LIMIT 7";
        $q = $this->db->query( $sql );
        $i = 0;
        $featurePost = array();
        while ($list_id = $this->db->fetch($q)) {

            $sql = "SELECT " . DB_PRE . "posts.ID, " . DB_PRE . "posts.post_title, " . DB_PRE . "posts.post_content, " . DB_PRE . "posts.post_name, " . DB_PRE . "postmeta.meta_value
                    FROM " . DB_PRE . "posts INNER JOIN " . DB_PRE . "postmeta ON " . DB_PRE . "posts.ID = " . DB_PRE . "postmeta.post_id
                    WHERE " . DB_PRE . "posts.post_type = 'blog_post' AND " . DB_PRE . "posts.post_status = 'publish' AND " . DB_PRE . "postmeta.meta_key = 'feature_img' AND " . DB_PRE . "posts.ID = " . $list_id['ID'];
            $query = $this->db->query( $sql );
            $result = $this->db->fetch( $query );

            $featurePost[$i] = array();
            foreach ($result as $k => $v) {
                $featurePost[$i][$k] = $v;
            }
            $i++;
        }

        return $featurePost;
    }

    function getPostForCategory( $listCategory )
    {
        $post = array();
        // get list post
        foreach ($listCategory as $k => $v) {
            $post[$v] = array();
            // get list recent post
            $sql = "SELECT `" . DB_PRE . "posts`.ID
                    FROM `" . DB_PRE . "posts` INNER JOIN (SELECT `" . DB_PRE . "term_relationships`.object_id
                                                FROM `" . DB_PRE . "term_taxonomy`, `" . DB_PRE . "term_relationships`
                                                WHERE `" . DB_PRE . "term_taxonomy`.term_taxonomy_id = `" . DB_PRE . "term_relationships`.term_taxonomy_id
                                                            AND `" . DB_PRE . "term_taxonomy`.term_id = " . $v . ") AS `table1` ON `" . DB_PRE . "posts`.ID = `table1`.object_id
                    WHERE " . DB_PRE . "posts.post_status = 'publish'
                    ORDER BY `" . DB_PRE . "posts`.post_date DESC
                    LIMIT 6";
            $q = $this->db->query($sql);
            while ($row = $this->db->fetch($q)) {

                $post[$v][$row['ID']] = array();
                $post[$v][$row['ID']]['ID'] = $row['ID'];

                // get post info
                $sql = "SELECT " . DB_PRE . "posts.post_title, " . DB_PRE . "posts.post_content, " . DB_PRE . "posts.post_name, " . DB_PRE . "postmeta.meta_value
                    FROM " . DB_PRE . "posts INNER JOIN " . DB_PRE . "postmeta ON " . DB_PRE . "posts.ID = " . DB_PRE . "postmeta.post_id
                    WHERE " . DB_PRE . "posts.post_type = 'blog_post' AND " . DB_PRE . "posts.post_status = 'publish' AND " . DB_PRE . "postmeta.meta_key = 'feature_img' AND " . DB_PRE . "posts.ID = " . $row['ID'];
                $query = $this->db->query($sql);
                $result = $this->db->fetch($query);

                foreach ($result as $key => $value) {
                    $post[$v][$row['ID']][$key] = $value;
                }
            }
        }
        return $post;
    }

    function getCategoryInfo($listCategory)
    {
        $category = array();
        foreach ($listCategory as $k => $v) {
            $sql = "SELECT " . DB_PRE . "terms.name, " . DB_PRE . "terms.slug
                    FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy
                    WHERE " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id AND " . DB_PRE . "term_taxonomy.taxonomy = 'category' AND " . DB_PRE . "terms.term_id = " . $v;
            $query = $this->db->query($sql);
            while ($row = $this->db->fetch($query)) {
                $category[$v] = array();
                $category[$v]['id'] = $v;
                $category[$v]['name'] = $row['name'];
                $category[$v]['slug'] = $row['slug'];
            }
        }
        return $category;
    }

    function isExistPost($postId)
    {
        $sql = "SELECT * FROM " . DB_PRE . "posts WHERE ID = " . $postId;
        $q = $this->db->query($sql);

        if ($this->db->numrows($q) > 0)
            return true;
        return false;
    }

    /**
     * Increment post view when user access post url
     * @param $postId
     */
    function incPostView( $postId ) {

        $sql = "SELECT * FROM " . DB_PRE . "postmeta WHERE meta_key = 'post_viewer_count' AND post_id = " . $postId;
        $query = $this->db->query( $sql );
        // check if the post is first update
        if ( $this->db->numrows( $query ) > 0 ) {

            $update = "UPDATE " . DB_PRE . "postmeta
                SET meta_value = meta_value + 1
                WHERE meta_key = 'post_viewer_count' AND post_id = " . $postId;
            $this->db->query( $update );
        } else {
            $insert = "INSERT INTO " . DB_PRE . "postmeta (post_id, meta_key, meta_value)
                        VALUES (". $postId .", 'post_viewer_count', '1')";
            $this->db->query( $insert );
        }
    }

    /**
     * new comment
     * @param $data
     * @return bool
     */
    function postComment( $data )
    {
        $table = DB_PRE . 'comments';
        if ( $this->db->insert( $table, $data ) )
            return true;
        return false;
    }

    /**
     * @param $filters
     * @return bool
     */
    function getAllComments( $filters )
    {
        $sql = "SELECT a.comment_ID, a.comment_post_ID,
                    a.comment_author, a.comment_author_email, a.comment_date,
                    a.comment_content, a.comment_approved,
                    b.post_title
                FROM " . DB_PRE . "comments as a, " . DB_PRE . "posts as b
                WHERE a.comment_post_ID = b.ID
                AND a.comment_type != 'trash'
                ORDER BY a.comment_date DESC";
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
        $url = URL::get_site_url() . '/admin/dashboard/comments';

        $pager = new PageNavigation( $sql, 8, 5, $url, $page, $append, 'backend' );

        // get sql added limit
        $newSql = $pager->paginate();

        if ( $newSql == false )
            return false;
        // execute query
        $query = $this->db->query( $newSql );
        $comments = array();
        while ( $row = $this->db->fetch( $query ) ) {

            foreach ( $row as $k => $v ) {

                $comments[$row['comment_ID']][$k] = $v;
            }
        }

        // render navigation
        $comments['navigation'] = $pager->renderFullNav( '<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>' );
        return $comments;
    }

    function getAllCommentsForPost( $postId )
    {
        $sql = "SELECT a.comment_ID, a.comment_author, a.comment_date, a.comment_content
                FROM ". DB_PRE ."comments as a
                WHERE a.comment_approved = 1
                AND a.comment_post_ID = ". $postId . "
                AND a.comment_type != 'trash'
                ORDER BY a.comment_date DESC";
        $query = $this->db->query( $sql );
        // if post have comments
        $comments = array();
        if ( $this->db->numrows( $query ) > 0 ) {

            while ( $row = $this->db->fetch( $query ) ) {

                foreach ( $row as $k => $v ) {

                    $comments[$row['comment_ID']][$k] = $v;
                }
            }
        } else {

            return false;
        }
        return $comments;
    }

    function approvedComment( $id )
    {
        $table = DB_PRE . 'comments';
        $data = array(
            'comment_approved' => 1
        );
        $where = ' comment_ID = ' . $id;
        if ( $this->db->update( $table, $data, $where ) ) {
            return true;
        }
        return false;
    }

    function deleteComment( $id )
    {
        $table = DB_PRE . 'comments';
        $data = array(
            'comment_type' => 'trash'
        );
        $where = ' comment_ID = ' . $id;
        if ( $this->db->update( $table, $data, $where ) ) {
            return true;
        }
        return false;
    }
}

