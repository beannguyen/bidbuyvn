<?php require_once(ROOT . DS . 'application\views\dashboard\sidebar.php'); ?>
<!--  BEGIN PAGE  -->
<div class="page-content">
    <!--  BEGIN PAGE HEADER -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
                Quản lý bài viết
                <small>Viết bài mới</small>
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="../dashboard">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">Quản lý bài viết</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>Viết bài mới</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <!--  END PAGE HEADER -->
    <div class="alert alert-success">
        <strong>Success!</strong> Bài viết đã được đăng thành công.
    </div>
    <div class="row">
        <div class="col-md-9 ">
            <div class="form-main">
                <div class="form-group">
                    <!-- TITLE -->
                    <div id="titlewrap">
                        <input class="form-control" id="exampleInputEmail1" placeholder="Tiêu đề bài viết" type="text">
                    </div>
                    <div id="image-show" style="width: 100%; margin-top: 20px">
                        <img src="http://localhost/vuithuong/wp-content/uploads/2012/07/7015157331_4ff9f7772a_b.jpg"
                             style="max-width: 100%"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- PUBLISH -->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-reorder"></i> Đăng bài
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div id="post-status">
                        <div id="attachment-info">
                            <span id="attachment timestamp">
                                Published on: <b>Jul 20, 2014 @ 12:44</b>
                            </span>

                            <div class="attachment url">
                                <label for="attachment_url">File URL:</label>
                                <input class="widefat urlfield" readonly="readonly" name="attachment_url"
                                       value="http://localhost/vuithuong/wp-content/uploads/2012/07/7015157331_4ff9f7772a_b.jpg"
                                       type="text">
                            </div>
                            <div class="attachment filename">
                                File name: <strong>7015157331_4ff9f7772a_b.jpg</strong>
                            </div>
                            <div class="attachment filetype">
                                File type: <strong>JPG</strong>
                            </div>
                            <div class="attachment filesize">
                                File size: <strong>223 kB</strong>
                            </div>
                            <div class="attachment dimensions">
                                Dimensions: <strong><span id="media-dims-46">1024&nbsp;×&nbsp;683</span> </strong>
                            </div>
                            <a href="javascript:;" class="" style="color: red">
                                Xóa ảnh
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <a href="javascript:;" class="btn green">
                            Cập nhật
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <form>
                <div class="form-group image-library-info">
                    <label class="col-md-3 control-label">Focus Keyword</label>

                    <div class="col-md-9">
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group image-library-info">
                    <label class="col-md-3 control-label">Focus Keyword</label>

                    <div class="col-md-9 image-library-info">
                        <input type="text" class="form-control"/>
                    </div>
                </div>
                <div class="form-group image-library-info">
                    <label class="col-md-3 control-label">Meta description</label>

                    <div class="col-md-9 image-library-info">
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--  END PAGE  -->