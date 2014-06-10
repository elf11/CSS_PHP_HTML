<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function check_login() {

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

    $existing_user = ORM::for_table('pw_user')->where('usr_username', $username)->find_many();

    if ($existing_user == false) {
        ob_clean();
        echo 'user_doesnt_exist';
        return;
    }

    $user = ORM::for_table('pw_user')->where('usr_username', $username)->find_one();
 
    $randomString = $user->usr_salt;

    $saltedPassword = $password . $randomString;
    $hashedPW = sha1($saltedPassword);

    if ($hashedPW != $user->usr_password) {
        ob_clean();
        echo 'wrong_password';
        return;
    }

    ORM::configure('id_column', 'usr_id');
    $user_found = ORM::for_table('pw_user')->find_one($user->usr_id);

    $log_time = date("Y-m-d H:i:s");
    $user_found->set('usr_last_login', $log_time); 
    $user_found->save();

    ob_clean();
    echo 'ok';
    
}

check_login();

?>
