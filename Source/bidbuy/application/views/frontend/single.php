<script src='<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/countdown.js' type='text/javascript'></script>
<section class="list-product">
<div class="container">
<div class="row">
<div class="col-sm-9 colums-9">
<?php if ( !$this->notfound && !isset( $this->accessdeny ) ) : ?>
<div class="head-tabs">
    <ul>
        <li class="active"><a href="#" data-loc="tab1">Chi tiết đánh giá</a></li>
        <li><a href="#" data-loc="tab2">Mô tả chi tiết</a></li>
        <li><a href="#" data-loc="tab3">Thông tin thành viên</a></li>
        <li><a href="#" data-loc="tab4">Nhận xét, đánh giá</a></li>
    </ul>
</div>

<!-- end head-tab -->
<div class="tabs">
    <div id="tab1" class="item-tab">
        <div class="row">
            <div class="col-sm-5">
                <div class="slider-product">
                    <ul id="viewport" class="bxslider">

                        <?php
                        $gen = new Generic();

                        echo '<li><img src="'. $gen->getFileNameWithImageSize( $this->productInfo['product_feature_img'], 401, 401 ) .'" /></li>';
                        $gallery = unserialize( $this->productInfo['product_gallery'] );
                        if ( $gallery ) {

                            foreach ( $gallery as $k => $v ) {

                                echo '<li><img src="'. $gen->getFileNameWithImageSize( $v, 401, 401 ) .'" /></li>';
                            }
                        }
                        ?>
                    </ul>

                    <div id="bx-pager">

                        <?php

                        echo '<a data-slide-index="0" href=""><img src="'. $gen->getFileNameWithImageSize( $this->productInfo['product_feature_img'], 51, 51 ) .'" /></a>';
                        $i = 1;
                        if ( $gallery ) {

                            foreach ( $gallery as $k => $v ) {

                                echo '<a data-slide-index="'. $i .'" href=""><img src="'. $gen->getFileNameWithImageSize( $v, 51, 51 ) .'" /></a>';
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="para-product">
                    <h3><?php echo $this->productInfo['product_title']; ?></h3>
                    <p>Tình trạng: <b>Mới 100% Full box</b></p>
                    <p>ID Đấu giá: <b>3857638</b></p>
                    <p>Khu vực: <b>Toàn Quốc</b></p>
                    <p>Thời gian còn lại: <b class="time-left"></b></p>
                    <script type="text/javascript">
                        var countdown = new Countdown({
                            selector: '.time-left',
                            msgAfter: "Đã hết hạn",
                            msgPattern: "{days} ngày, {hours} giờ {minutes} phút {seconds}",
                            dateStart: new Date(),
                            dateEnd: new Date('<?php echo $this->productInfo['product_end_date']; ?>'),
                            onEnd: function() {
                                $('.time-left').text('Đã hết hạn');
                                $('#submit-new-bid').hide();
                            }
                        });
                    </script>
                    <p>Bid bắt đầu: <b><?php echo $this->productInfo['product_price']; ?> đ</b></p>
                    <p>Bid hiện tại: <?php echo $this->productInfo['product_top_bid']; ?> đ</p>
                    <p>Số lượt bid: <a id="ajax-demo"><?php echo $this->productInfo['number_of_bid']; ?> bids</a></p>
                    <!-- ajax -->
                    <div id="ajax-modal"></div>
                    <!-- ajax -->
                    <?php if ( isset( $_SESSION['ssbidbuy']['user_id'] ) ) { ?>
                    <div class="bid">
                        <?php if ( isset( $_SESSION['ssbidbuy']['alreadybid'] ) ) { ?>
                            <div class="alert alert-warning">
                                <strong>Xin lỗi!</strong> Sản phẩm đã hết hạn hoặc bạn đã bid cho sản phẩm này rồi.
                            </div>
                            <?php unset( $_SESSION['ssbidbuy']['alreadybid'] ); ?>
                        <?php } ?>
                        <?php if ( isset( $_SESSION['ssbidbuy']['bid'] ) ) { ?>
                            <?php if ( $_SESSION['ssbidbuy']['bid'] ) { ?>
                                <div class="alert alert-success">
                                    <strong>
                                        Đấu giá thành công
                                    </strong>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger">
                                    <strong>
                                        Đã có lỗi xảy ra, vui lòng làm mới trang và thử lại
                                    </strong>
                                </div>
                            <?php } ?>
                            <?php unset( $_SESSION['ssbidbuy']['bid'] ) ?>
                        <?php } ?>

                        <form id="submit-new-bid" action="<?php echo URL::get_site_url(); ?>/admin/biding/addBid" method="post" role="form">
                            <?php
                            $require = 0;
                            if ( $this->productInfo['product_top_bid'] == 0 )
                                $require = ( $this->productInfo['product_price'] + $this->productInfo['product_price_step'] );
                            else
                                $require = ( $this->productInfo['product_top_bid'] + $this->productInfo['product_price_step'] );
                            ?>
                            <?php if ( $this->productInfo['product_status'] !== 'timeout' ) { ?>
                            <input id="bid_amount" name="bid_amount" type="text" value="<?php echo $require; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $this->productInfo['product_id']; ?>">
                            <input type="hidden" id="bid_amount_require" value="<?php echo $require; ?>">
                            <input type="submit" value="Bid now">
                            <?php } ?>
                        </form>
                    </div>
                    <?php } else { ?>
                    <div class="bid">
                        <p style="color: red;"><a href="<?php echo URL::get_site_url(); ?>/admin/login"> Bạn phải đăng nhập để thực hiện đấu giá</a></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div id="tab2" class="item-tab">
        <?php echo html_entity_decode($this->productInfo['product_content']); ?>
    </div>

    <div id="tab3" class="item-tab">
            <div class="space20"></div>
            <h3 class="form-section"><?php echo $this->productInfo['product_author']['name']; ?></h3>
            <p><?php echo $this->userMetas['about']; ?></p>
            <div class="well">
                <h3>Thông tin</h3>
                <address>
                    <strong>Email     </strong><a href="mailto:<?php echo $this->productInfo['product_author']['email']; ?>"><?php echo $this->productInfo['product_author']['email']; ?></a><br />
                    <strong>Số điện thoại     </strong><?php echo $this->userMetas['phone_num']; ?>
                </address>
            </div>
    </div>

    <div id="tab4" class="item-tab">
            <h3>Comments</h3>
            <a href="#" class="pull-left">
                <img alt="" src="assets/img/blog/9.jpg" class="media-object">
            </a>
            <div class="media-body">
                <?php
                $time = new timer();
                if ( isset( $this->comments ) ) {
                    //var_dump( $this->comments );
                    foreach ( $this->comments as $k => $v ) {

                        ?>
                        <h4 class="media-heading"><?php echo $v['comment_author']; ?> / <em><?php echo $time->timeFormat( $v['comment_date'] ); ?></em></h4>
                        <p><?php echo $v['comment_content']; ?></p>
                        <hr>
                <?php
                    }
                } else {

                    echo '<p>Chưa có bình luận nào</p>';
                }
                ?>
            </div>
            <h3>Leave a Comment</h3>
            <em id="comment_message" style="color: red"></em>
            <form id="post-comment" role="form" action="#">
                <div class="form-group">
                    <label class="control-label">Tên<span class="required">*</span></label>
                    <input id="comment_author" name="comment_author" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">Email<span class="required">*</span></label>
                    <input id="comment_author_email" name="comment_author_email" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label class="control-label">Message<span class="required">*</span></label>
                    <textarea id="comment_content" name="comment_content" class="form-control" rows="3"></textarea>
                </div>
                <button class="margin-top-20 btn blue" type="submit">Đăng bình luận</button>
                <input type="hidden" id="post_id" value="<?php echo $this->productInfo['product_id']; ?>" />
            </form>
    </div>
</div>
<!-- end content-tab -->

<div class="sample-product">
    <div class="row">
        <?php
        $themeFunc = new ThemeFunction();
        $themeFunc->relatedProduct( $this->productInfo['product_id'], $this->categorySlug );
        ?>
    </div>
</div>
<?php elseif ( isset( $this->accessdeny ) || $this->notfound ) : ?>
    <div class="head-tabs">
        <ul>
            <li class="active"><a href="javascript:;">404 - Không tìm thấy</a></li>
        </ul>
    </div>
    <div class="tabs">
        <div class="product-not-found">Không tìm thấy sản phẩm bạn yêu cầu</div>
    </div>
<?php endif; ?>
</div>
<?php require_once( 'sidebar.php' ); ?>
</div>
</div>
</section>
<!-- end detail-product -->