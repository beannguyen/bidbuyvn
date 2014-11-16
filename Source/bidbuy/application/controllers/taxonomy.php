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

    function archive( $category ) {

        // init variables
        $notFound = false;
        $title = '';
        $productInfo = array();
        // check for 404 error
        if ( !$this->model->findTaxonomyById( $category['id'] ) ) {

            $notFound = true;
            $title = 'Không tìm thấy chuyên mục';
        } else {

            $slug = $this->model->getCategorySlug( $category['id'] );
            // check if slug on url is ok
            if ( strpos( $category['query'], $slug ) !== FALSE ) {

                // create filter list
                if ( $category['query'] === $slug ) {

                    $filters['page'] = 1;
                } else {

                    $filters['page'] = substr( $category['query'], - ( strlen( $category['query'] ) - strlen( $slug ) - 1 ) );
                }

                $productInfo = $this->model->getListProductInCategory( $category['id'], $filters );

                $title = $this->model->getTaxonomy( $category['id'] )['name'];
            } else {

                $notFound = true;
                $title = 'Không tìm thấy chuyên mục';
            }
        }

        // render to view
        $this->view->title = $title;
        $this->view->notfound = $notFound;
        $this->view->products = $productInfo;

        $this->view->render('frontend/header');
        $this->view->render('frontend/archive');
        $this->view->render('frontend/footer');
    }
}
