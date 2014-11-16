<?php

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