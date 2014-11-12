<?php require_once(ROOT . DS . 'application/views/dashboard/sidebar.php'); ?>

<div class="page-content">
    <!-- BEGIN PAGE CONTENT-->
    <div class="invoice">
        <div class="row">
            <div class="col-xs-4">
                <h4>Thông tin khách hàng:</h4>
                <ul class="list-unstyled">
                    <?php
                    $customer = unserialize( $this->order['order_shipping'] );
                    foreach ( $customer as $k => $v ) {

                        if ( $v === 'vn' ) {

                            echo '<li>Việt Nam, </li>';
                            continue;
                        }
                        echo '<li>'. $v .', </li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4 invoice-payment">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?php
                $product = unserialize( $this->order['order_summary'] );
                ?>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th class="hidden-480">Tên sản phẩm</th>
                        <th>Tổng giá</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $product['id'] ?></td>
                        <td class="hidden-480"><?php echo $product['name'] ?></td>
                        <td class="hidden-480"><?php echo $product['price'] ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        <strong>Loop, Inc.</strong><br/>
                        795 Park Ave, Suite 120<br/>
                        San Francisco, CA 94107<br/>
                        <abbr title="Phone">P:</abbr> (234) 145-1810
                    </address>
                    <address>
                        <strong>Full Name</strong><br/>
                        <a href="mailto:#">first.last@email.com</a>
                    </address>
                </div>
            </div>
            <div class="col-xs-8 invoice-block">
                <ul class="list-unstyled amounts">
                    <li><strong>Sub - Total amount:</strong> $9265</li>
                    <li><strong>Discount:</strong> 12.9%</li>
                    <li><strong>VAT:</strong> -----</li>
                    <li><strong>Grand Total:</strong> $12489</li>
                </ul>
                <br/>


                <button type="submit" class="btn btn-lg green hidden-print">Submit Your Invoice <i
                        class="icon-ok"></i></button>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>