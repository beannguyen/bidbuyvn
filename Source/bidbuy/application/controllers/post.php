<?php
class postController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('post');
    }

    function postComment()
    {
        $timer = new timer();
        $data = array();
        foreach ( $_POST as $k => $v ) {

            $data[$k] = $v;
        }
        $data['comment_date'] = $timer->getDateTime();
        $data['comment_approved'] = 0;
        $res = $this->model->postComment( $data );
        if ( $res )
            echo json_encode( $data );
        else
            echo 0;
    }

    function confirmPendingComment()
    {
        $comment_id = $_POST['comment_id'];
        if ( $this->model->approvedComment( $comment_id ) ) {

            echo '1';
            return true;
        } else {

            echo '0';
            return false;
        }

    }

    function deleteComment()
    {
        $comment_id = $_POST['comment_id'];
        if ( $this->model->deleteComment( $comment_id ) ) {

            echo '1';
            return true;
        } else {

            echo '0';
            return false;
        }
    }
}