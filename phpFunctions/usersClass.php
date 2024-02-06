<?php
include 'phpFunctions/dbClass.php';

class User extends Database{
    public function register_user($user_reg_arr)
    {
        #uebergabewerte auf registerseite legen und mit htmlspecialchars ueberpruefen
        $username = $user_reg_arr['username'];
        $email = $user_reg_arr['email'];
        $hashed_password = password_hash($user_reg_arr['password'], PASSWORD_DEFAULT);

        if (htmlspecialchars($_POST['password']) === htmlspecialchars($_POST['confirm_password'])) {
            $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email=?");
            $stmt->execute([$email]);
            $rowcount = $stmt->fetchColumn();

            if ($rowcount == 0) {
                
                $stmt = $this->connect()->prepare(
                    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
                );
                $stmt->execute([$username, $email, $hashed_password]);
                $this->get_user_id($email);
            } else {
                echo "Account allready exists!";
            }
        } else {
            echo "Passwords do not match";
        }
    }
    public function login_user($user_login_arr)
    {
        $email = $user_login_arr['email'];
        $password = $user_login_arr['password'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
        $rowcount = $stmt->rowCount();
        if ($rowcount == 1) {

            ($user_login_arr);
            $row = $stmt->fetch();
            $password_hashed = $this->get_password($row->email);
            if (password_verify(strval($password), $password_hashed)) {
                $_SESSION['user_id'] = $row->id;
                $_SESSION['user_name'] = $row->username;
                $_SESSION['email'] = $row->email;
                $_SESSION['role'] = $row->is_admin;
                $_SESSION['logged_in'] = true;
            }
        } else {
            $_SESSION['logged_in'] = false;
        }
    }
    function get_password($email)
    {
        $sql = "SELECT password FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
        $hashed_password_raw = $stmt->fetch();
        $hashed_password = $hashed_password_raw->password;
        return strval($hashed_password);
    }
    function logout()
    {
        $_SESSION['logged_in'] = false;
        session_destroy();
        header('Location: index.php');
        exit();
    }
    function get_user_id($email){
        $stmt = $this->connect()->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user_id_raw = $stmt->fetch();
        $user_id = $user_id_raw->id;
        $stmt = $this->connect()->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->execute([$user_id]);
    }
}