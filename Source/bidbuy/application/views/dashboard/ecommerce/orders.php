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
                <li>Tất cả hóa đơn</li>
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
                <div class="caption"><i class="icon-reorder"></i>Tất cả hóa đơn <?php if ( isset( $this->activesellerorders ) ) echo 'bán'; else echo 'mua'; ?> </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN ORDERS TOOLBAR -->
                <div class="custom-toolbar row">
                    <div class="item">
                        <select id="orders-archive-filter" class="form-control input-medium">
                            <option>Tất cả các ngày</option>
                            <?php
                            if ( isset( $this->archives ) ) {

                                foreach ( $this->archives as $k => $v ) {

                                    echo '<option>'. $v .'</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" id="archive-selected" value="<?php if ( isset( $this->filters ) ) echo $this->filters['archive']; ?>">
                        <input type="hidden" id="type-orders" value="<?php if ( isset( $this->activesellerorders ) ) echo 'seller'; else echo 'buyer'; ?>" />
                    </div>
                </div>
                <!-- END ORDERS TOOLBAR -->
                <!-- BEGIN TABLE DATA -->
                <div class="row">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th><i class="icon-info-sign"></i> Trạng thái</th>
                            <th><i class="icon-file"></i> Hóa Đơn</th>
                            <th class="hidden-xs"><i class="icon-truck"></i> Địa Chỉ Khách Hàng</th>
                            <th><i class="icon-calendar"></i> Ngày lập</th>
                            <th><i class="icon-shopping-cart"></i> Tổng cộng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        if ( isset( $this->orders ) ) {

                            $generic = new Generic();
                            foreach ( $this->orders as $key => $val ) {

                                if ( $key !== 'navigation' ) :
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ( $val['post_status'] === 'awaiting')
                                            echo 'Đợi xử lý';
                                        elseif ( $val['post_status'] === 'processing' )
                                            echo 'Đang tiến hành';
                                        else
                                            echo 'Kết thúc';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#">#<?php echo $val['ID']; ?></a> for <strong><a href="<?php $product = unserialize( $val['order_summary'] ); echo $generic->post_permalink( $product['id']); ?>" target="_blank"><?php echo $product['name']; ?></a></strong>
                                    </td>
                                    <td>
                                        <?php
                                        $customInfo = unserialize( $val['order_shipping'] );
                                        $string = '';
                                        for ( $i = 0; $i < sizeof( $customInfo ); $i++ ) {

                                            if ( $customInfo[$i] === 'vn' ) {

                                                $string .= 'Việt Nam, ';
                                                continue;
                                            }
                                            $string .= $customInfo[$i] . ', ';
                                        }
                                        $string = rtrim( $string, ', ');
                                        echo $string;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $time = new timer();
                                        echo $time->timeFormat( $val['post_date'], 'd/m/Y' );
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $product['price'] . 'đ';
                                        ?>
                                    </td>
                                </tr>
                        <?php
                                endif;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <ul class="pagination pull-right">
                        <?php if ( isset( $this->orders ) ) echo $this->orders['navigation']; ?>
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
