<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">
    <?php
    include_once 'phpFunctions/productsClass.php';
    $product = new Product();
    $product->get_product($_GET['product_id']);
    if (array_key_exists('logged_in', $_SESSION) && isset($add_to_cart)) {
        $product->add_to_cart($_GET['product_id'], $_SESSION['user_id']);
    }
    if (array_key_exists('role', $_SESSION) && $_SESSION['role'] == 1){
        echo '<div class="delete_product">
        <form action="" method="POST">
            <input type="hidden" value="(product_id)">
            <input type="submit" class="delete_product_btn add_to_cart_btn" value="Delete Product">
        </form>
        </div>';
    }
    if(isset($_POST['add_to_cart'])){
        $product->add_to_cart($_GET['product_id'], $_SESSION['user_id']);
    }
    ?>
    </div>
</div>
</body>

</html>