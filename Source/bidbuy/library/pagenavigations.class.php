<?php
/**
 * Created by BeanNguyen.
 * To create a page navigation
 * User: mrbean
 * Date: 10/30/14
 * Time: 10:22 PM
 */

class PageNavigation extends Connect {

    // member variables
    private $db;
    var $php_self;
    var $rows_per_page = 10; //Number of records to display per page
    var $total_rows = 0; //Total number of rows returned by the query
    var $links_per_page = 5; //Number of links to display per page
    var $sql = "";
    var $debug = false;
    var $page = 1;
    var $max_pages = 0;
    var $offset = 0;
    var $append = ""; //Parameters to append to pagination links
    var $type; // navigation for frontend or backend

    /**
     * Constructor
     */
    function __construct( $sql, $rows_per_page = 10, $links_per_page = 5, $url = '', $page = 1, $append = "", $type )
    {
        // Call the connection
        $this->db = parent::dbObj();
        $this->db->connect();
        // set up custom settings
        $this->rows_per_page = (int)$rows_per_page;
        if ( intval($links_per_page ) > 0 ) {
            $this->links_per_page = (int)$links_per_page;
        } else {
            $this->links_per_page = 5;
        }
        $this->sql = $sql;
        $this->append = $append;
        $this->php_self = $url;
        $this->page = intval( $page );
        $this->type = $type;
    }

    /**
     * Executes the SQL query and initializes internal variables
     *
     * @access public
     * @return resource
     */
    function paginate() {

        //Find total number of rows
        $all_rs = $this->db->query( $this->sql );
        if (! $all_rs) {
            if ($this->debug)
                echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
            return false;
        }
        $this->total_rows = $this->db->numrows( $all_rs );

        //Return FALSE if no rows found
        if ($this->total_rows == 0) {
            if ($this->debug)
                echo "Query returned zero rows.";
            return FALSE;
        }

        //Max number of pages
        $this->max_pages = ceil($this->total_rows / $this->rows_per_page );
        if ($this->links_per_page > $this->max_pages) {

            $this->links_per_page = $this->max_pages;
        }

        //Check the page value just in case someone is trying to input an aribitrary value
        if ($this->page > $this->max_pages || $this->page <= 0) {

            $this->page = 1;
        }

        //Calculate Offset
        $this->offset = $this->rows_per_page * ($this->page - 1);

        //Fetch the required result set
        $rs = $this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}";
        return $rs;
    }

    function createURL ( $page )
    {
        $url = '';
        if ( $this->type === 'backend' )
        {
            $url .= $this->php_self . '/page=' . $page;

            if ( $this->append !== '' )
                $url .= ';' . $this->append;
        } elseif ( $this->type === 'search' ) {

            if ( strpos( $this->php_self, 'page=' ) !== FALSE ) {

                $temp = substr( $this->php_self, 0, strpos( $this->php_self, 'page=' ) + 5);
                $url .= $temp . $page;
            } else {

                $url .= $this->php_self . '&page=' . $page;
            }
        } else {

            if ( $this->php_self === ( URL::get_site_url() . '/' ) ) {

                $url .= $this->php_self . 'trang-chu/page-' . $page . '.html';
            } else {

                global $get;
                if ( $get != null ) {

                    if ( strpos( $get, 'tab-ending-bid' ) !== FALSE ) {

                        $url .= URL::get_site_url() . '/trang-chu/tab-ending-bid' . '-' . $page . '.html';
                    } elseif ( strpos( $get, 'tab-top-bid' ) !== FALSE ) {

                        $url .= URL::get_site_url() . '/trang-chu/tab-top-bid' . '-' . $page . '.html';
                    } elseif ( strpos( $get, 'page' ) !== FALSE ) {

                        $url .= URL::get_site_url() . '/trang-chu/page' . '-' . $page . '.html';
                    }
                }

                global $get_category;
                if ( $get_category != null ) {

                    require_once(ROOT . DS . 'application/models/taxonomy_model.php');
                    $taxonomyModel = new Taxonomy_Model();
                    $slug = $taxonomyModel->getCategorySlug( $get_category['id'] );
                    if ( strpos( $get_category['query'], $slug ) !== FALSE ) {
                        $url .= URL::get_site_url() . '/category/' . $get_category['id'] . '/' . $slug . '-' . $page . '.html';
                    }
                }
            }
        }
        return $url;
    }
    /**
     * show the next icon
     * @param string $tag icon for next item
     * @return bool|int
     */
    function renderNext( $tag = '&gt;&gt;' ) {

        if ($this->total_rows == 0)
            return FALSE;

        if ( $this->page < $this->max_pages ) {
            $url = $this->createURL( $this->page + 1 );
            return '<li class="next" ><a href="' . $url . '">' . $tag . '</a></li>';
        } else {
            return '<li class="next disabled"><a href="javascript:;">' . $tag . '</a></li>';
        }
    }

    /**
     * Show prev number of page
     * @param string $tag icon for prev item
     * @return bool|int
     */
    function renderPrev( $tag = '&lt;&lt;' ) {

        if ($this->total_rows == 0)
            return FALSE;

        if ($this->page > 1) {

            $url = $this->createURL($this->page - 1);
            return '<li class="prev" ><a href="' . $url . '">' . $tag . '</a></li>';
        } else {
            return '<li class="prev disabled"><a href="javascript:;">' . $tag . '</a></li>';
        }
    }

    function renderNav($prefix = '<li>', $suffix = '</li>') {

        if ($this->total_rows == 0)
            return FALSE;

        $batch = ceil($this->page / $this->links_per_page );
        $end = $batch * $this->links_per_page;
        if ($end == $this->page) {

            //$end = $end + $this->links_per_page - 1;
            //$end = $end + ceil($this->links_per_page/2);
        }
        if ($end > $this->max_pages) {

            $end = $this->max_pages;
        }
        $start = $end - $this->links_per_page + 1;
        $links = '';

        for($i = $start; $i <= $end; $i ++) {

            if ($i == $this->page) {
                $links .= ' <li class="active"><a href="javascript:;">' . $i . '</a></li>';
            } else {

                $url = $this->createURL( $i );
                $links .= ' ' . $prefix . '<a href="' . $url . '">' . $i . '</a>' . $suffix . ' ';
            }
        }

        return $links;
    }

    function renderFullNav( $prevTag = '&lt;&lt;', $nextTag = '&gt;&gt;' ) {

        return $this->renderPrev( $prevTag ) . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext( $nextTag );
    }

    /**
     * Set debug mode
     *
     * @access public
     * @param bool $debug Set to TRUE to enable debug messages
     * @return void
     */
    function setDebug($debug) {
        $this->debug = $debug;
    }
} 