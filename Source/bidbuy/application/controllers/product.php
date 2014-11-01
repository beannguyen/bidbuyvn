<?php

class productController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('product');
    }

    /**
     * insert new product
     */
    function insert()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_add_product' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $time = new timer();
        $timenow = $time->getDateTime();

        // insert basic information to db
        $data = array();
        $data['post_author'] = UserInfo::getUserId();
        $data['post_date'] = $timenow;
        $data['post_content'] = parent::secure($_POST['input-product-description']);
        $data['post_title'] = parent::secure($_POST['input-product-title']);
        $data['post_name'] = parent::vietnamese_permalink($_POST['input-product-title']);
        $data['post_modified'] = $timenow;
        $data['post_type'] = parent::secure($_POST['input-product-type']);
        $data['post_status'] = parent::secure($_POST['input-product-status']);
        // insert to db then get post ID
        $productId = $this->model->insert($data);

        // add feature image
        $feature_img = parent::secure($_POST['input-feature-url']);
        if ($feature_img == '') { // if no image is selected, feature image will be default

            $feature_img = URL::get_site_url() . '/public/uploads/defaults/no-thumbnail.png';
        }
        // add feature image to post meta
        $data = array(
            'post_id' => $productId,
            'meta_key' => 'feature_img',
            'meta_value' => $feature_img
        );
        $err = $this->model->addMeta($data);
        // for debug
        // var_dump( $err );

        // add gallery
        $gallery = $_POST['input-product-gallery'];
        $galleryArray = unserialize($gallery);
        // if have item in gallery
        if (sizeof($galleryArray) > 0) {

            $data = array(
                'post_id' => $productId,
                'meta_key' => 'product_gallery',
                'meta_value' => $gallery
            );
            $err = $this->model->addMeta($data);
        }

        // add product details
        $detail = array(
            0 => array(
                'post_id' => $productId,
                'meta_key' => 'product_sku',
                'meta_value' => parent::secure($_POST['input-product-sku'])
            ),
            1 => array(
                'post_id' => $productId,
                'meta_key' => 'product_price',
                'meta_value' => parent::secure($_POST['input-product-price'])
            ),
            2 => array(
                'post_id' => $productId,
                'meta_key' => 'product_price_step',
                'meta_value' => parent::secure($_POST['input-product-price-step'])
            ),
            3 => array(
                'post_id' => $productId,
                'meta_key' => 'product_timeout',
                'meta_value' => $_POST['input-product-timeout']
            ),
            4 => array(
                'post_id' => $productId,
                'meta_key' => 'product_top_bid',
                'meta_value' => 0
            )
        );
        foreach ($detail as $k => $v) {

            $err = $this->model->addMeta($v);
        }

        // add product to category
        $this->loadModel('taxonomy');
        $categoryId = parent::secure($_POST['input-product-category']);
        // if user not select category, this product will be moved to default category
        if ($categoryId != '') {

            $taxonomy_id = $this->model->getTaxonomyIdById($categoryId, 'category');
        } else {

            $taxonomy_id = 1;
        }
        // add relationship
        $this->model->addTaxonomyRelationship($taxonomy_id, $productId);

        // redirect back to edit page when process was success
        $_SESSION['jigowatt']['postPublished'] = true;
        URL::redirect_to(URL::get_site_url() . '/admin/dashboard/edit_product/' . $productId);
    }

    function update()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_edit_product' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        $time = new timer();
        $timenow = $time->getDateTime();
        $productId = parent::secure($_POST['input-product-id']);
        // insert basic information to db
        $data = array();
        $data['post_author'] = UserInfo::getUserId();
        $data['post_date'] = $timenow;
        $data['post_content'] = parent::secure($_POST['input-product-description']);
        $data['post_title'] = parent::secure($_POST['input-product-title']);
        $data['post_name'] = parent::secure($_POST['input-permalink-url']);
        $data['post_modified'] = $timenow;
        $data['post_type'] = parent::secure($_POST['input-product-type']);
        // insert to db then get post ID
        $this->model->update($productId, $data);

        // add feature image
        $feature_img = parent::secure($_POST['input-feature-url']);
        if ($feature_img == '') { // if no image is selected, feature image will be default

            $feature_img = URL::get_site_url() . '/public/uploads/defaults/no-thumbnail.png';
        }
        // add feature image to post meta
        $data = array(
            'post_id' => $productId,
            'meta_key' => 'feature_img',
            'meta_value' => $feature_img
        );
        $err = $this->model->addMeta($data);

        // add gallery
        $gallery = $_POST['input-product-gallery'];

        // if have item in gallery
        $data = array(
            'post_id' => $productId,
            'meta_key' => 'product_gallery',
            'meta_value' => $gallery
        );
        $err = $this->model->addMeta($data);

        // add product details
        $detail = array(
            0 => array(
                'post_id' => $productId,
                'meta_key' => 'product_sku',
                'meta_value' => parent::secure($_POST['input-product-sku'])
            ),
            1 => array(
                'post_id' => $productId,
                'meta_key' => 'product_price',
                'meta_value' => parent::secure($_POST['input-product-price'])
            ),
            2 => array(
                'post_id' => $productId,
                'meta_key' => 'product_price_step',
                'meta_value' => parent::secure($_POST['input-product-price-step'])
            ),
            3 => array(
                'post_id' => $productId,
                'meta_key' => 'product_timeout',
                'meta_value' => $_POST['input-product-timeout']
            )
        );
        foreach ($detail as $k => $v) {

            $err = $this->model->addMeta($v);
        }

        // add product to category
        $this->loadModel('taxonomy');
        $categoryId = parent::secure($_POST['input-product-category']);
        // if user not select category, this product will be moved to default category
        if ($categoryId != '') {

            $term_taxonomy_id = $this->model->getTaxonomyIdById($categoryId, 'category');
        } else {

            $term_taxonomy_id = 1;
        }

        // add category relationship
        if (!$this->model->isRelationship($categoryId, $term_taxonomy_id)) {
            $this->model->removeCategoryRelationship($categoryId);
            $this->model->addTaxonomyRelationship($term_taxonomy_id, $categoryId);
        }

        // redirect back to edit page when process was success
        $_SESSION['jigowatt']['postUpdated'] = true;
        URL::redirect_to(URL::get_site_url() . '/admin/dashboard/edit_product/' . $productId);
    }

    /**
     * move a product to trash
     */
    function move_to_trash()
    {
        // if user can not post new thread
        if ( !$this->gen->getPermission( UserInfo::getUserId(), 'can_move_product_to_trash' ) ) {
            URL::redirect_to( URL::get_site_url().'/admin/accessdeny' );
            exit();
        }

        if(isset($_POST['product_id']))
        {
            if( $this->model->delete( $_POST['product_id'] ) )
            {
                echo 1;
            } else
            {
                echo 0;
            }
        } else
        {
            echo 0;
        }
    }

    function activePendingProduct()
    {
        $productId = parent::secure( $_POST['product_id'] );
        $res = $this->model->changeProductStatus( $productId, 'on-process' );
        // if product status change success
        if ( $res ) {

            if ($this->model->createEndDate( $productId ) ) {

                echo 'changed';
                return true;
            } else {

                echo 'can_not_create_end_date';
                return false;
            }
        } else {

            echo 'not-changed';
            return false;
        }
    }

    /**
     * get product slug
     */
    function product_slug()
    {
        echo parent::vietnamese_permalink($_POST['string']);
    }

    /**
     * get serialize gallery array
     */
    function product_gallery()
    {
        $productId = parent::secure($_POST['product_id']);
        $response = $this->model->getGallery($productId);

        echo $response;
    }

    /**
     * suggest smaller number for create pricing steps
     */
    function suggestSmallNumber()
    {
        $this->model->suggestSmallNumber();
    }

    /**
     * suggest pricing step
     */
    function suggestPricingStep()
    {
        $price = parent::secure( $_POST['price'] );
        $pricingStep = $this->model->suggestPricingStep( $price );

        echo $pricingStep;
    }

    /**
     * check for lasted pricing step is already existed
     */
    function findLastedPricingStep()
    {
        $res = $this->model->findLastedPricingStep();
        if ( $res )
            echo 'found';
        else
            echo 'not-found';
    }

    /**
     * add new pricing step
     */
    function addPricingStep()
    {
        // get max stt
        $stt = $this->model->getMaxStt() + 1;

        // insert pricing step to db
        $data = array(
            'min' => parent::secure( $_POST['smaller'] ),
            'max' => parent::secure( $_POST['larger'] ),
            'step' => parent::secure( $_POST['step'] )
        );
        $response = $this->model->newPricingStep( $stt, $data );
        if ( $response == false )
            echo 'error';
        else
            echo $response;
    }

    function updatePricingStep()
    {
        // get data sent
        $data = array(

            'id' => parent::secure( $_POST['id'] ),
            'stt' => parent::secure( $_POST['stt'] ),
            'min' => parent::secure( $_POST['min'] ),
            'max' => parent::secure( $_POST['max'] ),
            'step' => parent::secure( $_POST['step'] )
        );
        $response = $this->model->updatePricingStep( $data );

        if ( $response )
            echo 'updated';
        elseif ( !$response )
            echo 'error';
    }

    function deletePricingStep()
    {
        $stepId = parent::secure( $_POST['step_id'] );
        $res = $this->model->deletePricingStep( $stepId );
        if ( $res ) {

            echo 'deleted';
        } else
            echo 'error';
    }

    /**
     * get pricing step detail
     */
    function getPricingStepDetail()
    {
        $ID = parent::secure( $_POST['step_id'] );
        $details = $this->model->getPricingStepDetail( $ID );

        if ( $details != false ) {

            echo json_encode( $details );
        } else
            echo 'not-found';
    }
}