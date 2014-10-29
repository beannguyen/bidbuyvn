<?php
class postController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('post');
    }

    /**
     * Show post for viewer
     * @param string $categorySlug the slug of category which contain this post
     * @param string $postSlug post slug
     */
    function post_show($categorySlug, $postSlug)
    {
        // get post information
        /* $this->view->postInfo = $this->model->getPostInfoBySlug($categorySlug, $postSlug);
        $this->view->categorySlug = $categorySlug;

        // if post not found, notfound flag is true
        $notfound = false;
        if ( $this->view->postInfo == false )
            $notfound = true;
        $this->view->notfound = $notfound;

        // render to view
        if ( !$notfound ) {

            // set page title
            $this->view->title = $this->view->postInfo['post_title'];

            // increment pageview
            $this->model->incPostView( $this->view->postInfo['post_id'] );
        } else
            $this->view->title = 'Không tìm thấy bài viết';  */
        // $this->view->render('frontend/header');
        $this->view->render('frontend/single');
        // $this->view->render('frontend/footer');
    }
}