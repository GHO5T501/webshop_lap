<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">
    <div class="all_products">
        <?php
            include_once 'phpFunctions/productsClass.php';
            $product = new Product();
            $product->get_all_products();
        ?>
    </div>
        <?php 
            if(isset($_POST['add_to_cart']) && array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] == true){
                $product->add_to_cart($_POST['product_id'], $_SESSION['user_id']);
            }
        ?>
</div>
</body>

</html>