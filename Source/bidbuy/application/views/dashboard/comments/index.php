<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>


<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý nhận xét
                <small>Tất cả nhận xét</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">

                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Quản lý nhận xét</a>
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
                <div class="caption"><i class="icon-reorder"></i>Tất cả nhận xét <span class="process"></span> </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN TABLE DATA -->
                <div class="row">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th><i class="icon-user"></i> Người đăng</th>
                            <th><i class="icon-comment-alt"></i> Bình luận</th>
                            <th><i class="icon-reorder"></i> Bài viết</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $generic = new Generic();
                        if ( isset ( $this->comments ) ) {

                            foreach ( $this->comments as $key => $val ) {

                                if ( $key !== 'navigation' ) {

                                    ?>
                                    <tr id="item-<?php echo $val['comment_ID']; ?>">
                                        <td>
                                            <?php echo '<strong>'. $val['comment_author'] .'</strong><br /><em>'. $val['comment_author_email'] .'</em>'; ?>
                                        </td>
                                        <td style="width: 40%;">
                                            <p><strong>#<?php echo $val['comment_ID']; ?>: </strong><span class="status-item-<?php echo $val['comment_ID']; ?>"><?php if ( $val['comment_approved'] == 1 ) echo 'Đã duyệt'; else echo 'Đợi duyệt'; ?></span></p>
                                            <p><?php echo $val['comment_content']; ?></p>
                                            <p>đăng lúc: <em><?php echo $val['comment_date']; ?></em></p>
                                        </td>
                                        <td>
                                            <p><a href="<?php echo $generic->post_permalink( $val['comment_post_ID'] ); ?>" target="_blank"> <?php echo $val['post_title']; ?></a></p>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Công cụ</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"><i class="icon-angle-down"></i></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <?php if ( $val['comment_approved'] != 1 ) : ?>
                                                        <li><a href="javascript:;" id="confirm-<?php echo $val['comment_ID']; ?>-btn" onclick="confirmPendingComment(<?php echo $val['comment_ID']; ?>)" class="btn green m-icon">Duyệt <i class="icon-thumbs-up m-icon-white confirm-process"></i></a></li>
                                                    <?php endif; ?>
                                                    <li><a href="javascript:;" onclick="deletePendingComment(<?php echo $val['comment_ID']; ?>)" class="btn blue"><i class="icon-trash delete-process"></i></a></li>
                                                </ul>
                                            </div>
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
                        <?php if ( isset( $this->comments ) ) echo $this->comments['navigation']; ?>
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
