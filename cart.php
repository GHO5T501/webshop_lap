<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">

    <div class="cart">
        <?php
        include 'phpFunctions/productsClass.php';
        $product = new Product();
        
        if($product->is_cart_empty($_SESSION['user_id'])){
            echo "<h1 align='center'>Dein Warenkorb ist leer</h1>";
        }else{
            $product->get_cart_items($_SESSION['user_id']);
            echo '<form action="" method="POST" class="buy_form">
            <input type="submit" name="buy_items" class="buy_items" value="Kaufen">
            </form>';
        }
        if(isset($_POST['add_product'])){
            $product->change_cart_qty($_SESSION['user_id'], $_POST['qty'], $_POST['prod_id']);
        }
        if(isset($_POST['buy_items'])){
            $product->clear_cart($_SESSION['user_id']);
        }
        ?>
    </div>
</div>
</div>
</body>

</html>