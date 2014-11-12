<?php
/**
 * Coder: mrbean
 * Date: 11/8/14
 * Time: 10:58 PM
 */

class BidingController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('biding');
    }

    function loadListBid( $productId )
    {
        $listbid = $this->model->loadListBid( $productId );
        if ( $listbid != false )
            $this->view->listbid = $listbid;

        $this->view->render('frontend/ajax/list_bid_product');
    }

    function addBid() {

        $timer = new timer();
        // create data
        $data = array(
            'productid' => $this->gen->secure( $_POST['product_id'] ),
            'bidder' => UserInfo::getUserId(),
            'biddatetime' => $timer->getDateTime(),
            'bidamount' => $this->gen->secure( $_POST['bid_amount'] ),
            'status' => '0'
        );
        // check if user is already bid
        if ( !$this->model->availableBid( $data['bidder'], $data['productid'] ) ){

            $_SESSION['ssbidbuy']['alreadybid'] = true;
            URL::goBack();
            exit();
        }

        // insert to database
        if ( $this->model->addBid( $data ) ) {

            $_SESSION['ssbidbuy']['bid'] = true;
        } else
            $_SESSION['ssbidbuy']['bid'] = false;
        // go back with this flag
        URL::goBack();
        exit();
    }
}