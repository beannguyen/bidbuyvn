<?php

function getBoxType($type)
{
    $text = '';
    switch ($type)
    {
        case 'tin_rao_vip':
            $text = 'Tin rao V.I.P';
            break;
        case 'tai_san_vip':
            $text = 'Tài sản V.I.P';
            break;
        case 'tin_tuc_noi_bat':
            $text = 'Tin tức nổi bật';
            break;
        case 'kien_thuc_dia_oc':
            $text = 'Kiến thức địa ốc';
            break;
    }
    return $text;
}

function loadListHomepageBox()
{
    $db = new Connect();
    $db = $db->dbObj();
    $db->connect();

    // get all categories from database
    $sql = "SELECT " . DB_PRE . "term_taxonomy.term_taxonomy_id, " . DB_PRE . "terms.term_id, " . DB_PRE . "terms.name
            FROM " . DB_PRE . "terms, " . DB_PRE . "term_taxonomy
            WHERE " . DB_PRE . "terms.term_id = " . DB_PRE . "term_taxonomy.term_id
                AND " . DB_PRE . "term_taxonomy.taxonomy = 'category'";
    $query = $db->query( $sql );
    while ( $category = $db->fetch( $query ) ) { // foreach category, show the option tag include number post

        // check if this category is already added
        $sql1 = "SELECT * FROM " . DB_PRE . "theme_options WHERE object_id = " . $category['term_id'];
        $query1 = $db->query( $sql1 );
        // if found result, flag this is selected
        if ( $db->numrows( $query1 ) > 0 ) {
            $selected = 'selected';
        }
        // echo HTML text
        echo "<option value='" . $category['term_id'] . "' ". $selected .">". $category['name'] ."</option>";
        // set select flag to blank
        $selected = '';
    }
}

function loadNestableMenuList( $menuDetail ) {

    // create nestable menu list
    foreach ( $menuDetail as $k => $v ) {

        echo "<li class='dd-item dd3-item' data-id='" . $menuDetail[$k]['_menu_item_object_id'] . "'>";
        echo "<div class='dd-handle dd3-handle'></div>";
        echo "<div class='dd3-content'>" . $menuDetail[$k]['name'] . " <em>(" . $menuDetail[$k]['_menu_item_type'] . ")</em></div>";
        if ( !empty( $menuDetail[$k]['children'] ) ) {
            echo "<ol class='dd-list'>";
                loadChildrenMenuItem( $menuDetail[$k]['children'] );
            echo "</ol>";
        }
        echo "</li>";
    }
}