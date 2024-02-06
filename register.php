<?php include 'st_html/head.php' ?>

<?php include 'st_html/nav.php' ?>
<div class="content">
    <div class="form_container">
        <form action="" method="POST">
            <label for="user_name">Benutzername</label><br>
            <input type="text" name="username" id="username" required><br>
            <label for="email">email</label><br>
            <input type="email" name="email" id="email" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required><br>
            <label for="confirm_password">Passwort bestätigen</label><br>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>
            <input type="submit" name="login_btn" id="login_btn" value="Login">
        </form>
    </div>
    <?php
    if(isset($_POST['login_btn'])){
        include_once "phpFunctions/usersClass.php";
        $user = new User();
        $user->register_user($_POST);
        header("Location:index.php");
        exit();
    }
    
    
    ?>
</div>
</body>

</html>