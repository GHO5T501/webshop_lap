<div class="navbar">
    <div class="logo_container">
        <h3 class="logo">SHOP</h3>
    </div>
    <div class="link_container">
        <a href="index.php">Start |</a>
        
        <a href="cart.php">Warenkorb</a>
        <!--display when user is admin starts here -->
        <?php
        if (array_key_exists('role', $_SESSION) && $_SESSION['role'] == 1) {
            echo '
            <a href="admin_dashboard.php">|Admin Dashboard</a>';
        }
        ?>
    </div>
    <div class="login_logout_link">
        <?php
        if (array_key_exists('logged_in', $_SESSION) && $_SESSION['logged_in'] == true) {
            echo '<form action="" method="POST" name="logout_form">
                <input type="submit" class="logout_btn" name="logout_btn" value="Logout |">
            </form>';
        } else {
            echo '<a href="login.php">Login |</a>';
        }
        if (isset($_POST['logout_btn'])) {
            include_once 'phpFunctions/usersClass.php';
            $user = new User();
            $user->logout();
        }
        ?>

    </div>
    
</div>