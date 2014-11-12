<?php
class Taxonomy_Model extends Model
{
    public $childcat = array();

    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    public function addNewTaxonomy($option)
    {
        $err = 0;
        $generic = new Generic();

        // basic category information
        if (empty($option['category_slug'])) {
            $option['category_slug'] = $generic->vietnamese_permalink($option['category_name']);
            $sql = "SELECT * FROM " . DB_PRE . "terms WHERE BINARY name = '" . $option['category_name'] . "'";
            $query = $this->db->query($sql);
            if ($this->db->numrows($query) == 0) {
                $select = "SELECT * FROM " . DB_PRE . "terms WHERE " . DB_PRE . "terms.slug LIKE '" . $option['category_slug'] . "%'";
                $q1 = $this->db->query($select);
                if ($this->db->numrows($q1) != 0) {
                    $num = 0;
                    $num = $this->db->numrows($q1) + 1;
                    $option['category_slug'] .= '-' . $num;
                }
            } else {
                $res = $this->db->fetch($query);
                $option['category_slug'] = $res['slug'];
            }
        } else {
            $option['category_slug'] = $generic->vietnamese_permalink($option['category_slug']);
        }

        $s = "SELECT * FROM " . DB_PRE . "terms WHERE slug = '" . $option['category_slug'] . "'";
        $q = $this->db->query($s);
        $termId = 0;
        if ($this->db->numrows($q) == 0) {
            $table = DB_PRE . "terms";
            $data = array(
                'name' => $option['category_name'],
                'slug' => $option['category_slug']
            );
            if ($termId = $this->db->insert($table, $data))
                $err++;
        }

        if ($option['taxonomy'] == 'post_tag')
            $parent = 0;
        else
            $parent = $option['category_parent'];

        $table = DB_PRE . "term_taxonomy";
        $data = array(
            'term_id' => $termId,
            'taxonomy' => $option['taxonomy'],
            'description' => $option['category_description'],
            'parent' => $parent
        );

        if ($term_taxonomy_id = $this->db->insert($table, $data))
            $err++;

        if ($err > 0)
            return $term_taxonomy_id;
        return false;
    }

    public function isCategoryExisted($type = '', $name = '')
    {
        if (empty($type) && empty($name)) {
            $type = parent::secure($_POST['type']);
            $name = parent::secure($_POST['category_name']);
        }

        if (!empty($_POST['category_slug'])) {
            $slug = parent::vietnamese_permalink($_POST['category_slug']);
            $sql = "SELECT *
                        FROM " . DB_PRE . "terms INNER JOIN " . DB_PRE . "term_taxonomy ON " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                        WHERE " . DB_PRE . "terms.slug = '" . $slug . "' AND BINARY " . DB_PRE . "terms.name = '" . $name . "' AND " . DB_PRE . "term_taxonomy.taxonomy = '" . $type . "'";
        } else {
            $slug = parent::vietnamese_permalink($name);
            $sql = "SELECT *
                        FROM " . DB_PRE . "terms INNER JOIN " . DB_PRE . "term_taxonomy ON " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                        WHERE BINARY " . DB_PRE . "terms.name = '" . $name . "' AND " . DB_PRE . "term_taxonomy.taxonomy = '" . $type . "'";

        }

        $qId = $this->db->query($sql);

        if ($this->db->numrows($qId) > 0)
            return 1;
        return 0;
    }

    public function isOtherCategoryExisted()
    {
        $term_id = parent::secure($_POST['category_id']);

        $slug = parent::vietnamese_permalink($_POST['category_slug']);

        $sql = "SELECT slug FROM " . DB_PRE . "terms WHERE term_id = " . $term_id;
        $query = $this->db->query($sql);
        $res = $this->db->fetch($query);

        if ($slug == $res['slug'])
            return 0;

        $sql = "SELECT slug FROM " . DB_PRE . "terms WHERE slug = '" . $slug . "'";
        $qId = $this->db->query($sql);

        if ($this->db->numrows($qId) > 0)
            return 1;
        return 0;
    }

    /**
     * find a taxonomy if it already existed return true
     * @param $taxonomyId
     * @param $type string tag|category
     * @return bool
     */
    function findTaxonomyById( $taxonomyId, $type = 'category' )
    {
        $sql = "select " . DB_PRE . "terms.term_id
                from " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy
                where " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                and " . DB_PRE . "term_taxonomy.taxonomy = '". $type ."'
                and " . DB_PRE . "terms.term_id = '" . $taxonomyId . "'";
        $query = $this->db->query( $sql );
        if ( $this->db->numrows( $query ) > 0 )
            return true;
        return false;
    }

    public function getParentTaxonomy($term_id, $select = false)
    {
        $sql = "SELECT " . DB_PRE . "terms.term_id, " . DB_PRE . "terms.name, " . DB_PRE . "terms.slug, " . DB_PRE . "term_taxonomy.description FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy WHERE " . DB_PRE . "term_taxonomy.parent = " . DB_PRE . "terms.term_id AND " . DB_PRE . "term_taxonomy.term_id = " . $term_id;
        $query = $this->db->query($sql);

        // if not child taxonomy
        if ($this->db->numrows($query) == 0)
            return false;
        $result = $this->db->fetch($query);
        if ($select)
            return "<option value='" . $result['term_id'] . "'>" . $result['name'] . "</option>";
        return $result;
    }

    public function getTaxonomy($term_id)
    {
        $sql = "SELECT " . DB_PRE . "terms.term_id, " . DB_PRE . "terms.name, " . DB_PRE . "terms.slug, " . DB_PRE . "term_taxonomy.description, " . DB_PRE . "term_taxonomy.parent
                FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy
                WHERE " . DB_PRE . "terms.term_id = " . $term_id . " AND " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id";
        $query = $this->db->query($sql);

        if ($this->db->numrows($query) == 0)
            return false;

        $res = $this->db->fetch($query);

        return $res;
    }

    function getTaxonomyIdByName($name, $type)
    {
        $sql = "SELECT term_id FROM " . DB_PRE . "terms WHERE BINARY name = '" . $name . "'";
        $q = $this->db->query($sql);
        $r = $this->db->fetch($q);
        $term_id = $r['term_id'];

        $sql = "SELECT term_taxonomy_id FROM " . DB_PRE . "term_taxonomy WHERE term_id =" . $term_id . " AND taxonomy = '" . $type . "'";
        $query = $this->db->query($sql);
        $res = $this->db->fetch($query);
        $taxonomy_id = $res['term_taxonomy_id'];

        return $taxonomy_id;
    }

    function getTaxonomyIdById($term_id, $type)
    {
        $sql = "SELECT term_taxonomy_id FROM " . DB_PRE . "term_taxonomy WHERE term_id =" . $term_id . " AND taxonomy = '" . $type . "'";
        $query = $this->db->query($sql);
        $res = $this->db->fetch($query);
        $taxonomy_id = $res['term_taxonomy_id'];

        return $taxonomy_id;
    }

    public function updateTaxonomy($option)
    {
        $sql1 = "UPDATE " . DB_PRE . "terms
                    SET name = '" . $option['category_name'] . "',
                        slug = '" . $option['category_slug'] . "'
                    WHERE term_id = " . $option['category_id'];
        $this->db->query($sql1);
        if ($option['type'] == 'category')
            $sql2 = "UPDATE " . DB_PRE . "term_taxonomy SET
                        description = '" . $option['category_description'] . "',
                        parent = " . $option['category_parent'] . "
                        WHERE term_id = " . $option['category_id'] . " AND taxonomy = '" . $option['type'] . "'";
        else
            $sql2 = "UPDATE " . DB_PRE . "term_taxonomy SET
                        description = '" . $option['category_description'] . "'
                        WHERE term_id = " . $option['category_id'] . " AND taxonomy = '" . $option['type'] . "'";
        $this->db->query($sql2);

        return true;
    }

    public function deleteTaxonomy()
    {
        // get list id
        $list_id = parent::secure($_POST['id']);
        // create id array
        $term_id = explode(',', $list_id);
        $errCount = 0;
        foreach ($term_id as $k => $v) {
            $sql = "SELECT COUNT(object_id) as num FROM " . DB_PRE . "term_relationships WHERE term_taxonomy_id = " . $v;
            $query = $this->db->query($sql);
            $num = $this->db->fetch($query);
            // if the category have post
            if ($num['num'] > 0) {
                $errCount++;
                continue;
            }
            // if default category
            if ($v == 1) {
                $errCount++;
                continue;
            }
            // delete category
            $sql = "DELETE FROM " . DB_PRE . "terms WHERE term_id =" . $v;
            $this->db->query($sql);

            $sql = "DELETE FROM " . DB_PRE . "term_taxonomy WHERE term_id = " . $v . " AND taxonomy = 'category'";
            $this->db->query($sql);
        }

        // if all category delete
        if ($errCount == 0)
            echo '1';
        else
            echo 'error';
    }

    function loadListCategory( $categoryList = false )
    {
        // get all categories id
        $sql = "SELECT " . DB_PRE . "terms.term_id, " . DB_PRE . "terms.name FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy WHERE " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id AND " . DB_PRE . "term_taxonomy.taxonomy = 'category'";
        $query = $this->db->query($sql);
        while ($row = $this->db->fetch($query))
            $categories[$row['term_id']] = array(
                'id' => $row['term_id'],
                'name' => $row['name']
            );
        // if require categories list
        if ($categoryList)
            return $categories;
        // get child categories for each category
        foreach ($categories as $k => $v) {
            $sql1 = "SELECT term_id FROM " . DB_PRE . "term_taxonomy WHERE parent = " . $v['id'];
            $query1 = $this->db->query($sql1);
            // check if it is not a parent category
            if ($this->db->numrows($query1) == 0)
                continue;
            $this->childcat[$v['id']] = array();
            while ($row = $this->db->fetch($query1)) {
                $this->childcat[$v['id']][] = $row['term_id'];
            }
        }

        return $this->childcat;
    }

    function getCategorySlug($term_id)
    {
        $sql = "SELECT slug FROM " . DB_PRE . "terms WHERE term_id = " . $term_id;
        $query = $this->db->query($sql);

        $result = $this->db->fetch($query);
        return $result['slug'];
    }

    function getCategoryIdBySlug($slug)
    {

        $sql = "SELECT term_id FROM " . DB_PRE . "terms WHERE slug = '" . $slug . "'";
        $query = $this->db->query($sql);

        // check if category not exist
        if ($this->db->numrows($query) > 0) {

            $categoryId = $this->db->fetch($query);
            return $categoryId['term_id'];
        } else
            return false;
    }

    function getListTags($postId)
    {
        $sql = "SELECT `" . DB_PRE . "term_taxonomy`.term_taxonomy_id
                    FROM `" . DB_PRE . "term_relationships` INNER JOIN `" . DB_PRE . "term_taxonomy` ON `" . DB_PRE . "term_relationships`.term_taxonomy_id = `" . DB_PRE . "term_taxonomy`.term_taxonomy_id
                    WHERE `" . DB_PRE . "term_relationships`.object_id = " . $postId . " AND `" . DB_PRE . "term_taxonomy`.taxonomy = 'post_tag'";
        $query = $this->db->query($sql);
        $tags = array();
        while ($row = $this->db->fetch($query)) {
            $tags[] = $row['term_taxonomy_id'];
        }

        return $tags;
    }

    function isRelationship($object_id, $taxonomy_id)
    {
        $sql = "SELECT * FROM " . DB_PRE . "term_relationships WHERE object_id = " . $object_id . " AND term_taxonomy_id = " . $taxonomy_id;
        $query = $this->db->query($sql);
        if ($this->db->numrows($query))
            return true;
        return false;
    }

    function removeRelationship($object_id, $term_taxonomy_id)
    {
        $sql = "DELETE FROM `" . DB_PRE . "term_relationships` WHERE `term_taxonomy_id` = " . $term_taxonomy_id . " AND object_id = " . $object_id;
        if ($this->db->query($sql))
            return true;
        return false;
    }

    function removeCategoryRelationship($object_id)
    {
        $sql = "SELECT `" . DB_PRE . "term_taxonomy`.term_taxonomy_id
                    FROM `" . DB_PRE . "term_relationships` INNER JOIN `" . DB_PRE . "term_taxonomy` ON `" . DB_PRE . "term_relationships`.term_taxonomy_id = `" . DB_PRE . "term_taxonomy`.term_taxonomy_id
                    WHERE `" . DB_PRE . "term_relationships`.object_id = " . $object_id . " AND `" . DB_PRE . "term_taxonomy`.taxonomy = 'category'";
        $query = $this->db->query($sql);
        while ($res = $this->db->fetch($query)) {
            $sql = "DELETE FROM `" . DB_PRE . "term_relationships` WHERE `term_taxonomy_id` = " . $res['term_taxonomy_id'] . " AND object_id = " . $object_id;
            $this->db->query($sql);
        }

        return true;
    }

    function addTaxonomyRelationship($term_taxonomy_id, $postId)
    {
        if ($this->isRelationship($postId, $term_taxonomy_id))
            return false;
        // add taxonomy relationship
        $table = DB_PRE . "term_relationships";
        $data = array(
            'object_id' => $postId,
            'term_taxonomy_id' => $term_taxonomy_id
        );
        $this->db->insert($table, $data);
    }

    private function getAllProductInCategory( $categoryId, $filters )
    {
        $sql = "SELECT " . DB_PRE . "term_relationships.object_id
                FROM " . DB_PRE . "term_relationships, " . DB_PRE . "term_taxonomy, " . DB_PRE . "posts
                WHERE " . DB_PRE . "term_relationships.term_taxonomy_id = " . DB_PRE . "term_taxonomy.term_taxonomy_id
                AND " . DB_PRE . "term_taxonomy.taxonomy = 'category'
                AND " . DB_PRE . "term_relationships.object_id = " . DB_PRE . "posts.ID
                ANd " . DB_PRE . "posts.post_type = 'product'
                AND " . DB_PRE . "posts.post_status = 'on-process'
                AND " . DB_PRE . "term_taxonomy.term_id = " . $categoryId;

        // init page navigation
        if ( isset( $filters['page'] ) ) {

            $page = $filters['page'];
        } else
            $page = 1;
        $url = URL::curURL();

        $pager = new PageNavigation( $sql, 4, 5, $url, $page, '', 'frontend' );

        // get sql added limit
        $newSql = $pager->paginate();

        $query = $this->db->query( $newSql );

        if ( $this->db->numrows( $query ) > 0 ) {

            // if have post
            $products = array();
            while ( $row = $this->db->fetch( $query ) ) {

                $products[] = $row['object_id'];
            }
            $products['navigation'] = $pager->renderFullNav( '<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>' );
            return $products;
        } else {

            return false;
        }
    }

    function getListProductInCategory( $categoryId, $filters )
    {
        // get all post Id of this category
        $products = $this->getAllProductInCategory( $categoryId, $filters );
        $navigation = $products['navigation'];
        unset( $products['navigation'] );
        // if have post
        if ( $products != false ) {

            require_once(ROOT . DS . 'application/models/widget_model.php');
            $widgetModel = new Widget_Model();
            $productInfo = $widgetModel->getProductInfo( $products );
            $productInfo['navigation'] = $navigation;
            return $productInfo;
        } else {

            return false;
        }
    }
}