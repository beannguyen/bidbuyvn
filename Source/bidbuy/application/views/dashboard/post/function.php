<?php

class postFunction
{
    private $db;
    private $generic;
    private $isLoaded = array(); // store id is loaded
    private $categoryList = array();
    private $childCategoryTree = array();
    private $checked = 0;
    function __construct()
    {
        // DB connect
        $cnn = new Connect();
        $this->db = $cnn->dbObj();
        $this->db->connect();

        // Generic
        $this->generic = new Generic();
    }

    function returnAllTaxonomy($type = 'category', $table = false, $without = false, $its = false)
    {
        $sql = "SELECT * FROM ".DB_PRE."terms, ".DB_PRE."term_taxonomy WHERE ".DB_PRE."terms.term_id = ".DB_PRE."term_taxonomy.term_id AND taxonomy = '".$type."'";
        $q = $this->db->query($sql);
        $i = 0;
        while($row = $this->db->fetch($q))
        {
            if(!$table)
            {
                if(($without != false && $row['term_id'] == $without) || $row['term_id'] == $its)
                    continue;
                else
                    echo ("<option value='".$row['term_id']."'>".$row['name']."</option>");
            }
            else
            {
                $query = $this->db->query("SELECT COUNT(object_id) as num FROM ".DB_PRE."term_relationships WHERE term_taxonomy_id = ".$row['term_taxonomy_id']);
                $count = $this->db->fetch($query);
                $count = $count['num'];

                echo "<tr class='user-catalog'>";
                echo "<td class='center'><input type='checkbox' id='checkbox_".$i."' class='checkboxes' value=".$row['term_id']." /></td>";
                echo "<td><a href=".URL::get_site_url()."/admin/dashboard/modify_taxonomy/".$row['term_id']."/".$type.">".$row['name']."</a></td>";
                echo "<td><span title='".$row['description']."'>".$this->generic->split_words($row['description'], 30, '...')."</span></td>";
                echo "<td>".$row['slug']."</td>";
                echo "<td>".$count."</td>";
                echo "</tr>";

                $i++;
            }
        }
    }

    function isParentCategory($term_id)
    {
        $sql = "SELECT parent FROM ".DB_PRE."term_taxonomy WHERE term_id = ".$term_id;
        $query = $this->db->query($sql);

        $result = $this->db->fetch($query);
        if($result['parent'] != 0)
        {
            return true;
        }
        return false;
    }
    function returnAllCategories($childTree, $categories, $selected = false)
    {

        $this->categoryList = $categories;
        $this->childCategoryTree = $childTree;

        if($selected != false)
            $this->checked = $selected;

        foreach($this->childCategoryTree as $key => $value)
        {
            // check if this id is loaded
            if(!empty($this->isLoaded[$key]))
                continue;
            // else push it into loaded array
            $this->isLoaded[] = $key;
            if(!$this->isParentCategory($key))
                $this->loadCategoryWithChild($this->categoryList[$key]);
        }

        foreach($this->categoryList as $key => $value)
        {
            if(!empty($this->isLoaded) && in_array($key, $this->isLoaded))
                continue;
            $this->isLoaded[] = $value['id'];
            $this->loadCategoryWithoutChild($value);
        }
    }

    function loadCategoryWithoutChild($category)
    {
        $check = '';
        if($category['id'] == $this->checked)
            $check = 'checked';
        echo "<li id='category-".$category['id']."'>";
        echo "<label class='selectit'>";
        echo "<input value=".$category['id']." name='post_category[]' id='in-category-".$category['id']."' class='categorychecklist' type='checkbox' $check>";
        echo $category['name'];
        echo "</label>";
        echo "</li>";
    }

    function loadCategoryWithChild($category)
    {
        $check = '';
        if($category['id'] == $this->checked)
            $check = 'checked';
        echo "<li id='category-".$category['id']."'>";
        echo "<label class='selectit'>";
        echo "<input value=".$category['id']." name='post_category[]' id='in-category-".$category['id']."' class='categorychecklist' type='checkbox' $check>";
        echo $category['name'];
        echo "</label>";
        echo "<ul class='children'>";
        foreach($this->childCategoryTree[$category['id']] as $k => $v)
        {
            $this->isLoaded[] = $v;
            if(!empty($this->childCategoryTree[$v]))
            {
                $this->loadCategoryWithChild($this->categoryList[$v]);
            } else
                $this->loadCategoryWithoutChild($this->categoryList[$v]);
        }
        echo "</ul>";
        echo "</li>";
    }

    function getTaxonomyForPost($postId, $taxonomy, $key = false)
    {
        $sql = "SELECT `".DB_PRE."terms`.term_id, `".DB_PRE."terms`.name
            FROM (`".DB_PRE."term_relationships` INNER JOIN `".DB_PRE."term_taxonomy` ON `".DB_PRE."term_relationships`.term_taxonomy_id = `".DB_PRE."term_taxonomy`.term_taxonomy_id) INNER JOIN `".DB_PRE."terms` ON `".DB_PRE."term_taxonomy`.term_id = `".DB_PRE."terms`.term_id
            WHERE `".DB_PRE."term_taxonomy`.taxonomy = '".$taxonomy."' AND `".DB_PRE."term_relationships`.object_id = ".$postId;

        $query = $this->db->query($sql);
        $res = $this->db->fetch($query);

        if($taxonomy == 'category')
        {
            if($key == 'name')
            {
                return $res['name'];
            } else
                return $res['term_id'];
        } else
        {
            $tags = '';
            while($res)
            {
                $tags .= "<a href='".URL::get_site_url()."/admin/allpost/tag/".$res['term_id']."' title='Nhấn để xem tất cả bài viết trong chuyên mục ".$res['name']."'>".$res['name']."</a>,";
            }
            return $tags;
        }
    }

    function loadPostList( $postStatus )
    {

        $sql = "SELECT `".DB_PRE."posts`.ID,`".DB_PRE."posts`.post_title, `".DB_PRE."posts`.post_author, `".DB_PRE."login_users`.username, `".DB_PRE."posts`.post_date, `".DB_PRE."posts`.post_modified, `".DB_PRE."posts`.post_author, `".DB_PRE."posts`.post_status  FROM `".DB_PRE."posts` INNER JOIN `".DB_PRE."login_users` ON `".DB_PRE."posts`.post_author = `".DB_PRE."login_users`.user_id
                WHERE `".DB_PRE."posts`.post_type = 'blog_post'";
        if ( $postStatus === 'publish' || $postStatus === 'draft' || $postStatus === 'trash' ) {
            $sql .= " AND post_status = '" . $postStatus . "'";
        }
        $sql .= " ORDER BY post_date DESC";
        $query = $this->db->query($sql);

        while($post = $this->db->fetch($query))
        {
            echo "<tr class='odd gradeX'>";
            echo "<td class='center'><input type='checkbox' class='checkboxes' value='".$post['ID']."'/></td>";
            echo "<td><a href='".URL::get_site_url()."/admin/dashboard/editpost/".$post['ID']."' title='Nhấn để chỉnh sửa ".$post['post_title']."'>".$post['post_title']."</a></td>";
            echo "<td><a href='".URL::get_site_url()."/admin/allpost/author/".$post['post_author']."' title='Nhấn để xem tất cả bài viết của tác giả ".$post['username']."'>".$post['username']."</a></td>";
            echo "<td><a href='".URL::get_site_url()."/admin/allpost/category/".$this->getTaxonomyForPost($post['ID'], 'category', 'id')."' title='Nhấn để xem tất cả bài viết trong chuyên mục ".$this->getTaxonomyForPost($post['ID'], 'category', 'name')."'>".$this->getTaxonomyForPost($post['ID'], 'category', 'name')."</a></td>";
            if($post['post_date'] == $post['post_modified'])
                echo "<td>".$post['post_modified']."<br /><small>Last modified</small></td>";
            else
                echo "<td>".$post['post_date']."</td>";
            if($post['post_status'] == 'publish')
                echo "<td><span class='label label-sm label-success'>Đã đăng</span></td>";
            elseif($post['post_status'] == 'draft')
                echo "<td><span class='label label-sm label-warning'>Bản nháp</span></td>";
            else
                echo "<td><span class='label label-sm label-danger'>Đã xóa</span></td>";
        }
    }
}