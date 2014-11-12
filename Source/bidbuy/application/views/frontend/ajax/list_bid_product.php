<div class="table-responsive">
    <table class="table">
        <tbody>
        <tr>
            <th>#</th>
            <th>Người đấu giá</th>
            <th>Vào lúc</th>
            <th>Giá trị</th>
        </tr>
        <?php
        if ( isset ( $this->listbid ) ) {
            $i = 1;
            $timer = new timer();
            foreach ( $this->listbid as $k => $v ) {

                ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v['bidder_name']; ?></td>
                    <td><?php echo $timer->timeFormat( $v['biddatetime'], 'H:i d/m/Y'); ?></td>
                    <td><?php echo $v['bidamount']; ?>đ</td>
                    <?php $i++; ?>
                </tr>
        <?php
            }
        } else {

            echo '<tr class="odd"><td class="dataTables_empty"><span style="color: #e23e29">Chưa có dữ liệu</span></td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
