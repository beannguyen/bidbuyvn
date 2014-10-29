<?php
class themeController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('theme');
    }

    /**
     * Create a new menu
     * Return status of processing
     */
    function createMenu() {

        // get ajax request
        $type = parent::secure($_POST['type']);
        $menuItem = parent::secure($_POST['menu_item']);
        $content = parent::secure($_POST['content']);
        // get status of process
        $res = '';
        if ( $type === 'custom' ) {

            $result = $this->model->createMenu( $type, $menuItem, $content );
            if ( is_array($result) ) {

                $res = array();
                $res = array_merge( $res, $result );
            }
        } elseif ( $type === 'category' ) {
            $categories = explode( ',', $content );
            // get information and insert to db
            $error = 0; # count error
            $res = array();
            $i = 0;
            foreach ( $categories as $key => $val ) {
                // require taxonomy model
                require_once(ROOT . DS . 'application/models/taxonomy_model.php');
                $taxonomyModel = new Taxonomy_Model();
                $category = $taxonomyModel->getTaxonomy( $val );
                // create data
                $item = $category['name'];
                $link = URL::get_site_url() . '/category/' . $category['slug'] . '.html';
                $result = $this->model->createMenu( $type, $item, $link );

                if ( $result === 'db_error' )
                    $error++;

                $res[$i] = $result;
                $i++;
            }
            if ( $error > 0 )
                $res = 'db_error';
        }
        // response status for process
        if ( $res === 'db_error' ) {
            echo $res;
            return false;
        } else {
            echo json_encode( $res );
            return true;
        }
    }

    function updateMenuOption() {

        // Get the JSON string
        $jsonString = $_POST['json_menu_list'];

        // Decode it into an array
        $jsonDecoded = json_decode(  $jsonString, true, 64 );

        // Dump the array to debug
        // var_dump($this->parseJsonArray($jsonDecoded));

        // Run the function above
        $readableArray = $this->parseJsonArray($jsonDecoded);

        // Loop through the "readable" array and save changes to DB
        foreach ($readableArray as $key => $value) {

            // $value should always be an array, but we do a check
            if (is_array($value)) {

                // Update DB
                $options = array(
                    0 => array(
                        'meta_key' => '_menu_item_menu_item_parent',
                        'meta_value' => $value['parentID']
                    ),
                    1 => array(
                        'meta_key' => '_menu_item_rang',
                        'meta_value' => $key
                    )
                );
                $where = "post_id=" . $value['id'];
                $this->model->updateMenuOption( $options, $where );
            }
        }

        echo 'success';
    }

    /**
     * delete menu item and some meta
     */
    function deleteMenuItem ()
    {
        $itemId = parent::secure( $_POST['id'] );
        // delete item
        $response = $this->model->deleteMenuItem( $itemId );

        echo $response;
    }

    /**
     * Function to parse the multidimentional array into a more readable array
	 * Got help from stackoverflow with this one:
	 * http://stackoverflow.com/questions/11357981/save-json-or-multidimentional-array-to-db-flat?answertab=active#tab-top
	 */
    private function parseJsonArray($jsonArray, $parentID = 0)
    {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray['children'])) {
                $returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
            }
            $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }

        return $return;
    }

    function updateHomeBoxOption() {

        if ( isset( $_POST['home_box_multi_select'] ) ) {

            $categories = $_POST['home_box_multi_select'];
            $res = $this->model->updateHomeBoxOption( $categories );
            // if updated
            if ( $res ) {
                URL::redirect_to( URL::get_site_url() . '/admin/dashboard/theme_option/updated' );
            } else {
                URL::redirect_to( URL::get_site_url() . '/admin/dashboard/theme_option/failed' );
            }
        } else {
            URL::redirect_to( URL::get_site_url() . '/admin/dashboard/theme_option/failed' );
        }
    }
}