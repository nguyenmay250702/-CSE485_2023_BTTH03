<?php
require 'vendor/autoload.php';
require 'config/database.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

if (isset($_POST['btn'])) {
    $txt_email_username = trim($_POST['txt_email_username']);
    $txt_pass = trim($_POST['txt_pass']);

    $db = new Database();

    $sql_select = "SELECT * FROM users WHERE email = :txt_email_username OR username =:txt_email_username";
    $arguments['txt_email_username'] = $txt_email_username;

    $result = $db->runSQL($sql_select, $arguments)->fetchAll();
    if (count($result) > 0) {
        //kiểm tra mk
        $pass = $result[0]['password'];
        


    } else {
        echo $twig->render('login_form.html',['mess'=>"Tài khoản không chính xác. Vui lòng kiểm tra lại thông tin đăng nhâp"]);
    }
} else {
    echo $twig->render('login_form.html');
}
?>