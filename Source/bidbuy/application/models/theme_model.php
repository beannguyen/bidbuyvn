<?php

class Theme_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    /**
     * create new menu item
     * @param string $type
     * @param string $menuItem
     * @param string $content
     * @return boolean
     */
    function createMenu($type, $menuItem, $content)
    {
        $time = new timer();
        $timenow = $time->getDateTime();
        $options = array(
            'post_author' => UserInfo::getUserId(),
            'post_date' => $timenow,
            'post_title' => $menuItem,
            'post_status' => 'publish',
            'post_name' => parent::vietnamese_permalink($menuItem),
            'post_modified' => $timenow,
            'post_type' => 'nav_menu_item'
        );
        $table = DB_PRE . 'posts';
        $menuId = $this->db->insert($table, $options);

        if (!$menuId) {
            return 'db_error';
        }
        // create menu metas
        $metas = array(
            '_menu_item_type' => $type,
            '_menu_item_menu_item_parent' => 0,
            '_menu_item_object_id' => $menuId,
            '_menu_item_object' => $type,
            '_menu_item_rang' => $this->getMaxRangMenu() + 1,
            '_menu_item_url' => ($content === 'http://') ? URL::get_site_url() : $content
        );
        // insert each meta to database
        $error = 0; // error count
        foreach ($metas as $key => $val) {

            // create parameter array
            $param = array(
                'post_id' => $menuId,
                'meta_key' => $key,
                'meta_value' => $val
            );
            $table = DB_PRE . 'postmeta';
            $insertMeta = $this->db->insert($table, $param);
            if (!$insertMeta)
                $error++;
        }
        if ($error > 0)
            return 'db_error';
        // create array of result
        $menuDetail = array(
            'menu_id' => $menuId,
            'menu_type' => $type,
            'menu_name' => $menuItem
        );
        return $menuDetail;
    }

    private function getMaxRangMenu()
    {
        $sql = "SELECT Max(meta_value) as max
                FROM ". DB_PRE ."postmeta
                WHERE meta_key = '_menu_item_rang'";
        $query = $this->db->query( $sql );
        $max = $this->db->fetch( $query );
        // if max not null, no have any menu
        if ( $max['max'] != null )
            return $max['max'];
        // else return 0
        return 0;
    }

    /**
     * update menu option json
     * @param array $options
     * @param string $where
     */
    function updateMenuOption($options, $where)
    {

        // update database
        foreach ($options as $key) {

            $update_sql = "UPDATE " . DB_PRE . "postmeta SET meta_value = ". $key['meta_value'] . "
                           WHERE meta_key = '" . $key['meta_key'] . "' AND " . $where;

            $this->db->query( $update_sql );
        }
    }

    /**
     * create HTML text for menu nestable list
     * @return string
     */
    function getMenu( $type ) {

        // get all parent items from database
        $sql = "SELECT post_id
                FROM " . DB_PRE . "postmeta
                WHERE meta_key = '_menu_item_menu_item_parent'
                AND meta_value = '0'";
        $query = $this->db->query($sql);

        // create an array to hold ID and rang
        $parentItems = array();
        while ($row = $this->db->fetch($query)) {

            $parentItems[] = $row['post_id'];
        }
        $parentItems = $this->getArrayWithRang( $parentItems, true );
        // string to hold the HTML which will load nestable menu
        $responseText = '';
        if ( $type === 'dashboard' ) {


            foreach ($parentItems as $k => $v) {
                $responseText .= "<li id='item-" . $v['_menu_item_object_id'] . "' class='dd-item dd3-item' data-id='" . $v['_menu_item_object_id'] . "'>\n";
                $responseText .= "<div class='dd-handle dd3-handle'></div>\n";
                $responseText .= "<div class='dd3-content'>" . $v['name'] . " <em>(" . $v['_menu_item_type'] . ")</em></div>\n";
                $responseText .= $this->createMenuAsHTML( $type, $v['id'] );
                $responseText .= "</li>\n";
            }
        } elseif ( $type === 'frontend' ) {

            foreach ( $parentItems as $k => $v ) {

                $responseText .= "<li>";
                $responseText .= '<a href="'. $v['_menu_item_url'] .'">' . $v['name'] . '</a>';
                $responseText .= $this->createMenuAsHTML( $type, $v['id'] );
                $responseText .= "</li>";
            }
        } elseif ( $type === 'option' ) {

            foreach ( $parentItems as $k => $v ) {

                $responseText .= '<option class="item-' . $v['_menu_item_object_id'] . '" value="' . $v['_menu_item_object_id'] . '">'. $v['name'] .'</option>\n';
                $responseText .= $this->createMenuAsHTML( $type, $v['id'] );
            }
        }
        return $responseText;
    }

    /* Function menu_showNested
	 * @desc Create inifinity loop for nested list from database
	 * @return echo string
	 */
    private function createMenuAsHTML( $type, $parentID )
    {

        // get all item id which is children of this parent
        $sql = "SELECT post_id FROM " . DB_PRE . "postmeta
                WHERE meta_key = '_menu_item_menu_item_parent'
                AND meta_value = " . $parentID;
        $result = $this->db->query($sql);
        $numRows = $this->db->numrows($result);

        $resText = '';
        if ($numRows > 0) {

            // create children item with order by rang
            $childrenItem = array();
            while ($row = $this->db->fetch($result)) {

                $childrenItem[] = $row['post_id'];
            }
            $childrenItem = $this->getArrayWithRang($childrenItem, true);

            if ( $type === 'dashboard' ) {

                // loop to create HTML text
                $resText .= "<ol class='dd-list'>\n";
                foreach ( $childrenItem as $key => $value ) {

                    $resText .= "<li id='" . $childrenItem[$key]['_menu_item_object_id'] . "' id='" . $childrenItem[$key]['_menu_item_object_id'] . "' class='dd-item dd3-item' data-id='" . $childrenItem[$key]['_menu_item_object_id'] . "'>\n";
                    $resText .= "<div class='dd-handle dd3-handle'></div>\n";
                    $resText .= "<div class='dd3-content'>" . $childrenItem[$key]['name'] . " <em>(" . $childrenItem[$key]['_menu_item_type'] . ")</em></div>\n";
                     // Run this function again (it would stop running when the mysql_num_result is 0
                    $resText .= $this->createMenuAsHTML ( $type, $childrenItem[$key]['id'] );
                    $resText .= "</li>\n";
                }
                $resText .= "</ol>\n";
            } elseif ( $type === 'frontend' ) {

                // loop to create HTML text
                $resText .= '<ul>';
                foreach ( $childrenItem as $key => $value ) {

                    $resText .= '<li>';
                    $resText .= '<a href="#">' . $childrenItem[$key]['name'] . '</a>';
                    $resText .= $this->createMenuAsHTML( $type, $childrenItem[$key]['id'] );
                    $resText .= '</li>';
                }
                $resText .= '</ul>';
            } elseif ( $type === 'option' ) {

                foreach ( $childrenItem as $key => $value ) {

                    $resText .= '<option value="' . $childrenItem[$key]['_menu_item_object_id'] . '">'. $childrenItem[$key]['name'] .'</option>\n';
                    $resText .= $this->createMenuAsHTML( $type, $childrenItem[$key]['id'] );
                }
            }

        }
        return $resText;
    }

    /**
     * return an array hold all data of menu item, sort by rang
     * @param $array
     * @param bool $getInfo
     * @return array
     */
    private function getArrayWithRang($array, $getInfo = false)
    {

        $newArray = array();
        foreach ($array as $key => $val) {
            // get rang of each item
            $sql1 = "SELECT meta_value
                    FROM " . DB_PRE . "postmeta
                    WHERE post_id = " . $val
                . " AND meta_key = '_menu_item_rang'";
            $query1 = $this->db->query($sql1);
            $rang = $this->db->fetch($query1);
            // push this item to array
            if ($rang['meta_value'] != '') {

                $newArray[$rang['meta_value']] = array();
                $newArray[$rang['meta_value']]['id'] = $val;
                // if require to get information
                if ($getInfo) {
                    foreach ($newArray as $k => $v) {
                        $newArray[$rang['meta_value']] = array_merge( $newArray[$rang['meta_value']], $this->getData( $val ) );
                    }
                }
            } else
                $newArray[] = $val;
        }
        // sort parent Items by rang
        ksort($newArray);
        return $newArray;
    }

    /**
     * return array hold all data of menu item
     * @param $itemId
     * @return mixed
     */
    function getData( $itemId ) {

        // get item data
        $sql = "SELECT " . DB_PRE . "posts.post_title, " . DB_PRE . "postmeta.meta_key, " . DB_PRE . "postmeta.meta_value
				FROM " . DB_PRE . "posts, " . DB_PRE . "postmeta
				WHERE " . DB_PRE . "posts.ID = " . DB_PRE . "postmeta.post_id
					and " . DB_PRE . "posts.post_type = 'nav_menu_item'
					and " . DB_PRE . "posts.ID = " . $itemId;
        $query = $this->db->query($sql);
        $i = 0;
        $menuData = array();
        while ( $result = $this->db->fetch( $query ) ) {

            if ($i == 0) {
                // the first time, get item name
                $menuData['name'] = $result['post_title'];
                $i++;
            }
            $menuData[$result['meta_key']] = $result['meta_value'];
        }

        return $menuData;
    }

    /**
     * @param $itemId
     * @return string
     */
    function deleteMenuItem( $itemId )
    {
        // delete item on posts table
        $table = DB_PRE . 'posts';
        $where = 'ID = ' . $itemId . ' AND post_type = "nav_menu_item"';
        $this->db->delete( $table, $where );
        // delete meta of this item
        $table = DB_PRE . 'postmeta';
        $where = 'post_id = ' . $itemId;
        $this->db->delete( $table, $where );
        // all done
        return 'deleted';
    }

    /**
     * update list category id for home box
     * @param $categories
     * @return bool
     */
    function updateHomeBoxOption( $categories ) {

        // delete all box on db and recreate
        $sql = "DELETE FROM `" . DB_PRE . "theme_options` WHERE 1";
        $this->db->query( $sql );
        // insert each category id to db
        foreach ( $categories as $k => $v ) {

            // check if it already existed
            $sql = "SELECT * FROM ".DB_PRE."theme_options WHERE object_id = ".$v;
            $query = $this->db->query( $sql );
            if ( $this->db->numrows( $query ) > 0 ) {

                // already exist
                $update = "UPDATE " . DB_PRE . "theme_options SET stt = " . $k . " WHERE object_id = " . $v;
                $this->db->query( $update );
            } else {

                $insert = "INSERT INTO " . DB_PRE . "theme_options (stt, box_type, object_id) VALUES (".$k.", 'category', ".$v.")";
                $this->db->query( $insert );
            }
        }
        return true;
    }

    function getHomeBox () {

        $sql = "SELECT object_id
                FROM " . DB_PRE . "theme_options
                ORDER BY stt";
        $query = $this->db->query( $sql );

        // create categories id
        $categories = array();
        while ( $result = $this->db->fetch( $query ) ) {

            $categories[] = $result['object_id'];
        }
        return $categories;
    }
}