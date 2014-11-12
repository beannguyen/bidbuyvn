<?php

class frontendController extends Controller
{
    function __construct() {
        parent::__construct();
    }

    function index( $filterString = '' )
    {
        // get filter
        if ( strpos( $filterString, 'page' ) !== FALSE ) { // filter string not contain page

            $filters['status'] = 'on-process';
            $filters['page'] = substr( $filterString, - (sizeof( $filterString ) - 6) );
        } elseif ( strpos( $filterString, 'tab' ) !== FALSE ) {

            $filters['tab'] = substr( $filterString, - (sizeof( $filterString ) - 5), 7 );
            if ( $filters['tab'] === 'top-bid' ) {

                $this->view->topBid = 'active';
                $page = substr( $filterString, 12);
                if ( $page !== FALSE )
                    $filters['page'] = $page;
            } else {

                $filters['tab'] = substr( $filterString, - (sizeof( $filterString ) - 5), 10 );
                if ( $filters['tab'] === 'ending-bid' ) {

                    $this->view->endingBid = 'active';
                    $page = substr( $filterString, 15);
                    if ( $page !== FALSE )
                        $filters['page'] = $page;
                }
            }
        } else {

            // set default settings
            $filters['status'] = 'on-process';
            $filters['page'] = 1;
            $this->view->all = 'active';
        }

        // get list post
        $this->loadModel( 'product' );
        $products = $this->model->getAllProducts( $filters, 'frontend' );
        $this->view->products = $products;

        $this->view->title = $this->gen->getOption('site_title');

        $this->view->render('frontend/header');
        $this->view->render('frontend/index');
        $this->view->render('frontend/footer');
    }
}