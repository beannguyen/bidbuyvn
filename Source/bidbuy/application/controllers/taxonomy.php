<?php
class taxonomyController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('taxonomy');
    }

    function newTaxonomy()
    {
        foreach ($_POST as $k => $v) {
            $option[$k] = $v;
        }

        $res = $this->model->addNewTaxonomy($option);
        if ($res) {
            URL::goBack();
        }
    }

    function isCategoryExisted()
    {
        echo $this->model->isCategoryExisted();
    }

    function isOtherCategoryExisted()
    {
        echo $this->model->isOtherCategoryExisted();
    }

    function GetIdUpdate()
    {

        $this->model->SetIdToUpdateCatalogy();

    }

    function updateTaxonomy()
    {

        foreach($_POST as $k => $v)
        {
            $option[$k] = $v;
        }

        if($this->model->updateTaxonomy($option))
        {
            echo '1';
        } else
            echo '0';
    }

    function deleteTaxonomy()
    {
        echo $this->model->deleteTaxonomy();
    }

    function category_slug()
    {
        $term_id = parent::secure($_POST['string']);
        echo $this->model->getCategorySlug($term_id);
    }

    function archive( $slug ) {

        // get list post and information
        //$postsInfo = $this->model->getListPostInCategory( $slug );
        //$this->view->title = "Chuyên mục";
        //$this->view->postInfo = $postsInfo;

        //$this->view->render('frontend/header');
        $this->view->render('frontend/archive');
        //$this->view->render('frontend/footer');
    }
}
