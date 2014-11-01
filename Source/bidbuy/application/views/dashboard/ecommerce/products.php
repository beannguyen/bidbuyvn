<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>


<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý người dùng
                <small>Tất cả người dùng</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Quản lý giỏ hàng</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>Tất cả hàng hóa</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!--  END PAGE HEADER -->
    <!--  BEGIN PAGE CONTENT -->
    <div class="col-md-12">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet gren">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i>Tất cả hàng hóa</div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN ORDERS TOOLBAR -->
                <div class="custom-toolbar row">
                    <div class="item">
                        <a href="<?php echo URL::get_site_url(); ?>/admin/add_product" class="btn green">Thêm mới <i class="icon-plus"></i></a>
                    </div>
                    <div class="item">
                        <select id="product-status-filter" class="form-control input-medium">
                            <option value="-1">Trạng thái</option>
                            <option value="on-process">Đang tiến hành</option>
                            <option value="pending">Đợi duyệt</option>
                            <option value="timeout">Đã hết hạn</option>
                            <option value="draft">Bản nháp</option>
                            <option value="trash">Đã xóa</option>
                        </select>
                        <input type="hidden" id="status-selected" value="<?php if ( isset( $this->filters['status'] ) ) { echo $this->filters['status']; } else { echo ''; } ?>" />
                    </div>
                    <div class="item">
                        <select id="product-archive-filter" class="form-control input-medium">
                            <option value="-1">Tất cả các ngày</option>
                            <?php
                            if ( isset( $this->archives ) ) {

                                foreach ( $this->archives as $k => $v ) {

                                    echo '<option>'. $v .'</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" id="archive-selected" value="<?php if ( isset( $this->filters['archive'] ) ) { $time = new timer(); echo $time->timeFormat( $this->filters['archive'], 'd M Y' ); } else { echo ''; } ?>">
                    </div>
                    <?php if ( UserInfo::getUserId() == 1 ): ?>
                    <div class="item">
                        <select id="seller-filter" class="form-control input-medium select2me" data-placeholder="Chọn tên người bán...">
                            <option value=""></option>
                            <?php
                            require('function.php');
                            $func = new productFunction();
                            $func->loadListSeller();
                            ?>
                        </select>
                        <input type="hidden" id="selected_seller" value="<?php if ( isset( $this->filters['seller'] ) ) { echo $this->filters['seller']; } else { echo ''; } ?>" />
                    </div>
                    <?php endif; ?>
                </div>
                <!-- END ORDERS TOOLBAR -->
                <!-- BEGIN TABLE DATA -->
                <script src='<?php echo URL::get_site_url(); ?>/public/dashboard/assets/plugins/countdown.js' type='text/javascript'></script>
                <div class="row">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th><i class="icon-info-sign"></i> Trạng thái</th>
                            <th><i class="icon-file"></i> Tên</th>
                            <th>Danh mục</th>
                            <th class="hidden-xs"><i class="icon-truck"></i> Giá khởi điểm</th>
                            <th>Bước giá</th>
                            <th>Bid cao nhất</th>
                            <th><i class="icon-calendar"></i> Thời gian còn lại</th>
                            <th><i class="icon-cog"></i> Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ( isset( $this->productInfo ) ) {

                                //var_dump($this->productInfo);
                                foreach ( $this->productInfo as $key => $val ) {

                                    if ( $key !== 'navigation' ) {


                                        // create time
                                        $duetime = unserialize( $this->productInfo[$key]['product_timeout'] );
                                        // create some data
                                        $status = '';
                                        switch( $this->productInfo[$key]['product_status'] ) {

                                            case 'on-process' :
                                                $status = 'Đang tiến hành';
                                                $time = $duetime[0] . ' ngày : ' . $duetime[1] . ' giờ : ' . $duetime[2] . ' phút';
                                                break;
                                            case 'pending' :
                                                $status = 'Đợi duyệt';
                                                $time = 'Đợi duyệt';
                                                break;
                                            case 'draft' :
                                                $status = 'Bản nháp';
                                                $time = 'Chưa hoạt động';
                                                break;
                                            case 'trash' :
                                                $status = 'Đã xóa';
                                                $time = 'Đã bị xóa';
                                                break;
                                            case 'timeout' :
                                                $status = 'Đã hết hạn';
                                                $time = 'Hết hạn';
                                                break;
                                            default:
                                                $status = 'Đang tiến hành';
                                                $time = $duetime[0] . ' ngày : ' . $duetime[1] . ' giờ : ' . $duetime[2] . ' phút';
                                                break;
                                        }

                                        // render row into table
                                        echo '<tr>';
                                        echo '<td id="product_status_row_'. $key .'" >'. $status .'</td>';
                                        echo '<td><a href="'. URL::get_site_url() .'/admin/dashboard/edit_product/'. $key .'" title="'. $this->productInfo[$key]['product_title'] .'"><strong>'. $this->generic->split_words( $this->productInfo[$key]['product_title'], 40, '...') .'</strong></a> <br /> by <a href="'. URL::get_site_url() .'/admin/dashboard/products/seller='. $this->productInfo[$key]['product_author']['id'] .'"><em>'. $this->productInfo[$key]['product_author']['name'] .'</em></a></td>';
                                        echo '<td><a href="'. URL::get_site_url() .'/admin/dashboard/products/cat='. $this->productInfo[$key]['product_category']['id'] .'">'. $this->productInfo[$key]['product_category']['name'] .'</a></td>';
                                        echo '<td>'. $this->productInfo[$key]['product_price'] .'</td>';
                                        echo '<td>'. $this->productInfo[$key]['product_price_step'] .'</td>';
                                        echo '<td>'. $this->productInfo[$key]['product_top_bid'] .'</td>';
                                        echo '<td id="time_count_down_'. $key .'">'. $time . '</td>';
                                        echo '<td>';
                                            echo '<a href="'. URL::get_site_url() .'/admin/dashboard/edit_product/'. $key .'" class="btn blue"><i class="icon-eye-open"></i></a>';
                                        echo '</td>';
                                        echo '</tr>';

                                        // check time for product
                                        if ( $this->productInfo[$key]['product_status'] === 'on-process' ) {

                                            ?>
                                            <script type="text/javascript">
                                                var countdown = new Countdown({
                                                    selector: '#time_count_down_<?php echo $key; ?>',
                                                    msgAfter: "Đã hết hạn",
                                                    msgPattern: "{days} ngày, {hours} giờ {minutes} phút {seconds}",
                                                    dateStart: new Date(),
                                                    dateEnd: new Date('<?php echo $this->productInfo[$key]['product_end_date']; ?>'),
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

                                echo '<tr class="odd"><td class="dataTables_empty" colspan="6" valign="top">No data available in table</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <ul class="pagination pull-right">
                        <?php
                        if ( isset( $this->productInfo ) )
                            echo $this->productInfo['navigation'];
                        ?>
                    </ul>
                </div>
                <!-- END TABLE DATA -->
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
    <!--  END PAGE CONTENT -->
</div>
<!--  END PAGE  -->
