<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>


<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý các sản phẩm đã đấu giá
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="javascript:;">Sản phẩm</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Quản lý các sản phẩm đã đấu giá</a>
                </li>
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
                <div class="caption"><i class="icon-reorder"></i>Các sản phẩm đã đấu giá</div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN TABLE DATA -->
                <div class="row">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th><i class="icon-barcode"></i> Sản phẩm</th>
                            <th><i class="icon-calendar"></i> Ngày đấu giá</th>
                            <th><i class="icon-money"></i> Bid của bạn</th>
                            <th><i class="icon-money"></i> Bid hiện tại</th>
                            <th><i class="icon-filter"></i> Trạng thái sản phẩm</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $generic = new Generic();
                        $timer = new timer();
                        if ( isset ( $this->listbids ) ) {

                            foreach ( $this->listbids as $k => $v ) {
                                if ( $k != 'navigation' ) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo $generic->post_permalink( $v['productid'] ); ?>" target="_blank"><?php echo $v['post_title']; ?></a>
                                        </td>
                                        <td>
                                            <em><?php echo $timer->timeFormat( $v['biddatetime'], 'H:i d/m/Y') ?></em>
                                        </td>
                                        <td>
                                            <?php echo $v['bidamount']; ?>
                                        </td>
                                        <td>
                                            <?php echo $v['top_bid']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ( $v['post_status'] === 'timeout' && $v['status'] == 1 ) {
                                                ?>
                                                <span class="label label-sm label-success">Thành công</span>
                                                <?php
                                            } elseif ( $v['post_status'] === 'on-process' && $v['status'] == 0 ) {
                                                ?>
                                                <span class="label label-sm label-info">Đang tiến hành</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="label label-sm label-warning">Thất bại</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <ul class="pagination pull-right">
                        <?php if ( isset( $this->listbids ) ) echo $this->listbids['navigation']; ?>
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
