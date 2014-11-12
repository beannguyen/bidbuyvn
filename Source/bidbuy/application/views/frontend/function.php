<?php
require_once(ROOT . DS . 'application/models/theme_model.php');
require_once(ROOT . DS . 'application/models/widget_model.php');
class ThemeFunction {

    private $db;
    private $generic;
    private $themeModel;
    private $widgetModel;

    function __construct()
    {
        // DB connect
        $cnn = new Connect();
        $this->db = $cnn->dbObj();
        $this->db->connect();

        // Generic
        $this->generic = new Generic();
        $this->themeModel = new Theme_Model();
        $this->widgetModel = new Widget_Model();
    }

    function get( $string )
    {
        echo $this->generic->getOption( $string );
    }

    function loadFeatureSlide()
    {
        require_once(ROOT . DS . 'application/models/theme_model.php');
        $themeModel = new Theme_Model();

        $options = array(
            1 => array(
                'slider_title' => $themeModel->getThemeOption( 'slider_title_1' ),
                'slider_description' => $themeModel->getThemeOption( 'slider_description_1' ),
                'slider_image' => $themeModel->getThemeOption( 'slider_image_1' ),
                'slider_enabled' => $themeModel->getThemeOption( 'slider_enabled_1' )
            ),
            2 => array(
                'slider_title' => $themeModel->getThemeOption( 'slider_title_2' ),
                'slider_description' => $themeModel->getThemeOption( 'slider_description_2' ),
                'slider_image' => $themeModel->getThemeOption( 'slider_image_2' ),
                'slider_enabled' => $themeModel->getThemeOption( 'slider_enabled_2' )
            ),
            3 => array(
                'slider_title' => $themeModel->getThemeOption( 'slider_title_3' ),
                'slider_description' => $themeModel->getThemeOption( 'slider_description_3' ),
                'slider_image' => $themeModel->getThemeOption( 'slider_image_3' ),
                'slider_enabled' => $themeModel->getThemeOption( 'slider_enabled_3' )
            ),
            4 => array(
                'slider_title' => $themeModel->getThemeOption( 'slider_title_4' ),
                'slider_description' => $themeModel->getThemeOption( 'slider_description_4' ),
                'slider_image' => $themeModel->getThemeOption( 'slider_image_4' ),
                'slider_enabled' => $themeModel->getThemeOption( 'slider_enabled_4' )
            ),
            5 => array(
                'slider_title' => $themeModel->getThemeOption( 'slider_title_5' ),
                'slider_description' => $themeModel->getThemeOption( 'slider_description_5' ),
                'slider_image' => $themeModel->getThemeOption( 'slider_image_5' ),
                'slider_enabled' => $themeModel->getThemeOption( 'slider_enabled_5' )
            )
        );

        foreach ( $options as $k => $v ) {

            if ( $v['slider_enabled'] == 1 ) {

                echo '<li>';
                echo '<img src="'. $v['slider_image'] .'" title="'. $v['slider_title'] .'" alt="'. $v['slider_title'] .'" >';
                echo '<div class="caption">';
                echo '<h2>'. $v['slider_title'] .'</h2>';
                echo '<p>'. $v['slider_description'] .'</p>';
                echo '</div>';
                echo '</li>';
            }
        }
    }

    function loadSocialBox()
    {
        echo '<li><a href="'. $this->generic->getOption('facebook_link') .'"><img src="'. URL::get_site_url() .'/public/frontend/assets/images/icon/facebook.png" alt=""> Facebook</a></li>';
        echo '<li><a href="'. $this->generic->getOption('youtube_link') .'"><img src="'. URL::get_site_url() .'/public/frontend/assets/images/icon/yt.png" alt=""> Youtube</a></li>';
        echo '<li><a href="'. $this->generic->getOption('googleplus_link') .'"><img src="'. URL::get_site_url() .'/public/frontend/assets/images/icon/google_plus.png" alt=""> Google+</a></li>';
    }

    function loadBidApps()
    {
        echo '<a href="'. $this->generic->getOption( 'googleplay_link' ) .'"><img src="'. URL::get_site_url() .'/public/frontend/assets/images/android.png" alt=""></a>';
        echo '<a href="'. $this->generic->getOption( 'appstore_link' ) .'"><img src="'. URL::get_site_url() .'/public/frontend/assets/images/ios.png" alt=""></a>';
    }

    function loadFooterCol( $n = '' )
    {
        if ( $n !== '' ) {

            $text = $this->generic->getOption( 'footer_column_' . $n );
        } else {

            $text = $this->generic->getOption( 'footer_text' );
        }
        echo html_entity_decode( $text );
    }

    function getMenu()
    {
        echo($this->themeModel->getMenu('frontend'));
    }

    function loadProducts( $products )
    {
        if ( $products !== FALSE ) {

            foreach ( $products as $key => $val ) {

                if ( $key !== 'navigation' ) {

                    if ( $val['product_top_bid'] != 0 )
                        $topBid = $val['product_top_bid'];
                    else
                        $topBid = $products[$key]['product_price'];

                    echo '<div class="col-md-4 col-lg-3">';
                    echo '<div class="inner">';
                    echo '<div class="image">';
                    echo '<a href="'. $this->generic->post_permalink( $key ) .'"><img src="'. $this->generic->getFileNameWithImageSize( $val['feature_img'], 193, 141 ) .'" alt="'. $val['product_title'] .'"></a>';
                    echo '</div>';

                    echo '<div class="info">';
                    echo '<h3><span><a href="'. $this->generic->post_permalink( $key ) .'">'. $this->generic->split_words( $products[$key]['product_title'], 30, '...') .'</a></span></h3>';

                    echo '<p>';
                    echo '<span class="time">Time left:</span>';
                    echo '<span class="day"><i id="time_count_down_'. $key .'"></i></span>';
                    echo '<span class="price-bid">Current bid:<br /> '. $topBid .' đ | '. $val['number_of_bid'] .' bids </span>';
                    echo '</p>';

                    echo '<p class="btn">';
                    echo '<a href="'. $this->generic->post_permalink( $key ) .'" class="bid">Bid Ngay</a>';
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    // check time for product
                    if ( $products[$key]['product_status'] === 'on-process' ) {

                        ?>
                        <script type="text/javascript">
                            var countdown = new Countdown({
                                selector: '#time_count_down_<?php echo $key; ?>',
                                msgAfter: "Đã hết hạn",
                                msgPattern: "{days} ngày, {hours} giờ {minutes} phút {seconds}",
                                dateStart: new Date(),
                                dateEnd: new Date('<?php echo $products[$key]['product_end_date']; ?>'),
                                onEnd: function() {
                                    $('#product_status_row_<?php echo $key; ?>').text('Đã hết hạn');
                                }
                            });
                        </script>
                    <?php
                    }
                }
            }
        } else {

            echo '<div class="product-not-found">Không tìm thấy sản phẩm nào trong mục này</div>';
        }
    }

    function relatedProduct ( $productId, $categorySlug )
    {
        $productInfo = $this->widgetModel->related_product( $productId, $categorySlug );
        if ( $productInfo != FALSE ) {

            foreach ( $productInfo as $product ) {

                if ( $product['product_top_bid'] != 0 )
                    $topBid = $product['product_top_bid'];
                else
                    $topBid = $product['product_price'];

                echo '<div class="col-md-4 col-lg-3">';
                echo '<div class="inner">';
                echo '<div class="image">';
                echo '<a href="'. $this->generic->post_permalink( $product['product_id'] ) .'"><img src="'. $this->generic->getFileNameWithImageSize( $product['feature_img'], 193, 141 ) .'" alt="'. $product['product_title'] .'"></a>';
                echo '</div>';

                echo '<div class="info">';
                echo '<h3><span><a href="'. $this->generic->post_permalink( $product['product_id'] ) .'">'. $this->generic->split_words( $product['product_title'], 30, '...') .'</a></span></h3>';

                echo '<p>';
                echo '<span class="time">Time left:</span>';
                echo '<span class="day"><i id="time_count_down_'. $product['product_id'] .'"></i></span>';
                echo '<span class="price-bid">Current bid:<br /> '. $topBid .' đ | '. $product['number_of_bid'] .' bids </span>';
                echo '</p>';

                echo '<p class="btn">';
                echo '<a href="'. $this->generic->post_permalink( $product['product_id'] ) .'" class="bid">Bid Ngay</a>';
                echo '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // check time for product
                if ( $product['product_status'] === 'on-process' ) {

                    ?>
                    <script type="text/javascript">
                        var countdown = new Countdown({
                            selector: '#time_count_down_<?php echo $product['product_id']; ?>',
                            msgAfter: "Đã hết hạn",
                            msgPattern: "{days} ngày, {hours} giờ {minutes} phút {seconds}",
                            dateStart: new Date(),
                            dateEnd: new Date('<?php echo $product['product_end_date']; ?>'),
                            onEnd: function() {
                                $('#product_status_row_<?php echo $product['product_id']; ?>').text('Đã hết hạn');
                            }
                        });
                    </script>
                <?php
                }
            }
        }
    }
}