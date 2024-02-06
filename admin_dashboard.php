<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">
    <div class="form_container upload_form">
        <form class="product_upload_form" action="" method="POST">
            <label for="prod_name">Produktname</label><br>
            <input type="text" name="prod_name" class="prod_name upload_input" required><br>
            <label for="prod_description">Produktbeschreibung</label><br>
            <textarea name="prod_description" class="prod_description upload_input" rows="10" cols="22" required></textarea><br>
            <label for="prod_price">Preis</label><br>
            <input type="number" name="prod_price" class="prod_price upload_input" min="0.5" step=".01" required><br>
            <label for="prod_img">Produktbild</label><br>
            <input type="file" name="prod_img" class="prod_img" accept="image/png, image/jpeg" required><br><br>
            <input type="submit" name="prod_create" id="prod_create">
        </form>
    </div>
</div>
</body>

</html>