<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function checkPassword($pwd, &$errors) {
    $errors_init = $errors;
    
    if (strlen($pwd) < 6) {
        $errors[] = "Password too short!";
    }
    
    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "Password must include at least one number!";
    }
    
    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "Password must include at least one letter!";
    }
    
    return ($errors == $errors_init);
}

function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


function create_new_record($username, $password, $usr_salt) {
    $users = ORM::for_table('pw_user')->create();
    $users->usr_username = $username;
    $users->usr_password = $password;
    $users->usr_salt = $usr_salt;
    $reg_time = date("Y-m-d H:i:s");
    $users->usr_register_date = $reg_time;
    #$d1 = new DateTime("0000-00-00 00:00:00");
    $d1 = "0000-00-00 00:00:00";
    $users->usr_last_login = $d1;
    $users->save();
}

function register_user() {

    $username = "";
    $password = "";

    if (!isset($_POST['username']) || empty($_POST['username']) || strlen($_POST['username']) < 6) {
        ob_clean();
        echo 'username';
        return;
    }
    
    $username = $_POST['username'];
    
    if (!isset($_POST['password']) || empty($_POST['password']) || strlen($_POST['password']) < 6) {
        ob_clean();
        echo 'password';
        return;
    }

    $password = $_POST['password'];
 
    $errors = array();

    if (checkPassword($password, $errors) == false) {
        ob_clean();
        echo 'password_strength';
        return;
    }

    if (!isset($_POST['confirm']) || strcmp($password, $_POST['confirm']) != 0) {
        ob_clean();
        echo 'confirm';
        return;
    }


    $existing_user = ORM::for_table('pw_user')->where('usr_username', $username)->find_many();

    if ($existing_user != false) {
        ob_clean();
        echo 'user_exists';
        return;
    }

    $randomString = generateRandomString();

    $saltedPassword = $password . $randomString;
    $hashedPW = sha1($saltedPassword);

    create_new_record($username, $hashedPW, $randomString); 

    ob_clean();
    echo 'ok';
    
}

register_user();

?>
