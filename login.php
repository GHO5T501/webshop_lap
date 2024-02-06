<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">
    <div class="form_container">
        <form action="" method="POST">
            <label for="email">email</label><br>
            <input type="email" name="email" id="email" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required><br><br>
            <input type="submit" name="login_btn" id="login_btn" value="Login">
        </form><br>
        <div class="register_link">
            <a href="register.php" >Konto erstellen</a>
        </div>
    </div>
    <?php
    if(isset($_POST['login_btn'])){
        include_once 'phpFunctions/usersClass.php'; 
        $user = new User();
        $user->login_user($_POST);
        header('Location:index.php');
    }
         
    
    ?>
</div>
</body>

</html>