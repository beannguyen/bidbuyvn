<form action="<?php echo URL::get_site_url(); ?>/search" method="get">
    <div class="input" id="custom">
        <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm" />

        <select class="list" name="category">
            <option value="">Chuyên mục</option>
            <?php
            require_once(ROOT . DS . 'application/views/dashboard/ecommerce/function.php');
            $func = new productFunction();
            $func->returnAllTaxonomy();
            ?>
        </select>
    </div>
    <button type="submit">Search</button>
</form>