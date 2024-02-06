<?php
include 'phpFunctions/dbClass.php';

class Product extends Database
{
    function get_all_products()
    {
        $stmt = $this->connect()->prepare('SELECT * FROM products');
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $product) {
            echo '<div class="product">
        <div class="prod_img_container">
            <form action="product.php" method="GET">
                <input type="image" class="product_card_img" src="' . $product->img . '" alt="submit">
                <input type="hidden" name="product_id" value="' . $product->id . '">
            </form>  

        </div>
        <div class="prod_info">
            ' . $product->name . '<br><br>
            ' . $product->price . '€
            <form action="" method="POST" class="add_to_cart_form">
                <input type="hidden" name="product_id" value="' . $product->id . '"><br>
                <input type="submit" value="Zum Warenkorb hinzufügen" name="add_to_cart" class="add_to_cart_btn">
            </form>
        </div>
        </div>';
        }
    }
    function add_to_cart($product_id, $user_id)
    {
        $cart_id = $this->get_cart_id($user_id);
        $rowcount = $this->check_if_item_exists($cart_id, $product_id);
        if ($rowcount >= 1) {
            $stmt = $this->connect()->prepare('UPDATE cart_items SET qty = qty+1 WHERE cart_id = ? AND prod_id = ?');
            $stmt->execute([$cart_id, $product_id]);
        } else {
            $stmt = $this->connect()->prepare('INSERT INTO cart_items (prod_id, cart_id) VALUES (?, ?)');
            $stmt->execute([$product_id, $cart_id]);
        }
    }
    function get_cart_id($user_id)
    {
        $stmt = $this->connect()->prepare('SELECT id FROM carts WHERE user_id = ?');
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        $cart_id = $result->id;
        return $cart_id;
    }
    function get_product($product_id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();

        echo '
                <div class="product_page">
        <div class="product_page_picture">
            <img class="product_page_img" src="' . $result->img . '" alt=""">
        </div>
        <div class="product_page_information">
            <div class="product_name">
                ' . $result->name . '
            </div>
            <div class="product_description">
                ' . $result->description . '
            </div>
            <div class="product_price">
                ' . $result->price . '€
            </div>
            <div class="add_product_to_cart_form">
                <form action="" method="POST" class="add_to_cart_form">
                    <input type="hidden" value="' . $result->id . '"><br>
                    <input type="submit" value="Zum Warenkorb hinzufügen" class="add_to_cart_btn" name="add_to_cart">
                </form>
            </div>
        </div>
        ';
    }
    function check_if_item_exists($cart_id, $prod_id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM cart_items WHERE cart_id = ? AND prod_id = ?');
        $stmt->execute([$cart_id, $prod_id]);
        $rowcount = $stmt->fetchColumn();
        return $rowcount;
    }
    function get_cart_items($user_id)
    {
        $cart_id = $this->get_cart_id($user_id);
        $stmt = $this->connect()->prepare('SELECT * FROM cart_items WHERE cart_id = ?');
        $stmt->execute([$cart_id]);
        $result = $stmt->fetchAll();
        foreach ($result as $product) {
            $this->display_cart_product($product->prod_id);
        }
    }
    function display_cart_product($product_id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        echo '<div class="cart_item"> 
        <div class="prod_cart_img_container">
            <img src="' . $result->img . '" class="prod_cart_img">
        </div>
        <div class="cart_prod_info">
        <div class="prod_name">
            ' . $result->name . '
        </div>
        <div class="price">
            ' . $result->price * $this->get_qty($product_id) . ' €
        </div>
        <div class="qty_form">
        <form action="" method="POST">
            <input type="hidden" name="prod_id" value="' . $product_id . '">
            <label for="qty">Anzahl</label><br>
            <input type="number" name="qty" min="0" value="' . $this->get_qty($product_id) . '"><br><br>
            <input type="submit" name="add_product" class="add_prod_btn" >
        </form>
        </div>
        
        </div>
        </div>
        ';
    }
    function get_qty($product_id)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM cart_items WHERE prod_id = ?');
        $stmt->execute([$product_id]);
        $qty_raw = $stmt->fetch();
        $qty = $qty_raw->qty;
        return $qty;
    }
    function clear_cart($user_id){
        $cart_id = $this->get_cart_id($user_id);
        $stmt = $this->connect()->prepare('DELETE FROM cart_items WHERE cart_id = ?');
        $stmt->execute([$cart_id]);
        header('Location: index.php');
        exit();
    }
    function is_cart_empty($user_id){
        $cart_id = $this->get_cart_id($user_id);
        $stmt = $this->connect()->prepare('SELECT * FROM cart_items WHERE cart_id = ?');
        $stmt->execute([$cart_id]);
        $rowcount = $stmt->fetchColumn();
        if($rowcount <= 1){
            return true;
        }else{
            return false;
        }
    }
    function change_cart_qty($user_id, $new_qty, $product_id){
        $cart_id = $this->get_cart_id($user_id);
        if($new_qty < 1){
            $stmt = $this->connect()->prepare('DELETE FROM cart_items WHERE prod_id = ? AND cart_id = ?');
            $stmt->execute([$product_id, $cart_id]);
            header('Refresh: 1');
            exit();
        }
        else{
            $stmt = $this->connect()->prepare('UPDATE cart_items SET qty = ? WHERE prod_id = ? AND cart_id = ?');
            $stmt->execute([$new_qty, $product_id, $cart_id]);
            header('Refresh: 0.1');
            exit();
        }
        
        
    }
}
