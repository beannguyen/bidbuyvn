<?php

class SearchController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('search');
    }

    function process()
    {
        // get search key
        $key = $this->gen->secure( $_GET['query'] );
        $category = $this->gen->secure( $_GET['category'] );

        // if not enter search key
        if (  $key !== '' ) {

            // if select category
            if ( $category !== '' ) { // get result in selected category

                $searchResult = $this->model->searchInCategory( $key, $category );
            } else { // get result with search key only

                $searchResult = $this->model->searchKeyOnly( $key );
            }

            $this->view->searchResult = $searchResult;

            // no results
            if ( $searchResult === false ) {

                $this->view->title = 'Không tìm thấy sản phẩm yêu cầu';
            }
        } else {

            if ( $category !== '' ) { // get result in selected category

                $this->view->searchResult = $this->model->searchInCategory( $key, $category );
            } else {

                // no results
                $this->view->searchResult = false;
                $this->view->title = 'Không tìm thấy sản phẩm yêu cầu';
            }
        }

        $this->view->render('frontend/header');
        $this->view->render('frontend/search-result');
        $this->view->render('frontend/footer');
    }
}