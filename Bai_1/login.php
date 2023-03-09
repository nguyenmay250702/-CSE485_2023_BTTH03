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
        $username = $result[0]['username'];
        $status = $result[0]['status'];
        $role = $result[0]['role'];
        $password_hash = $result[0]['password'];

        //kiểm tra mk nhập vào có trùng với giá trị mk đã đc băm trong db hay không
        if (password_verify($txt_pass, $password_hash)) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($status == 1) {
                if ($role == 0) header("location:user.php");
                else header("location:admin.php");
            } else {
                echo $twig->render('login_form.html', ['mess' => "tài khoản chưa đc kích hoạt. Vui lòng kích hoạt tài khoản trc khi đăng nhập"]);
            }
        } else {
            echo $twig->render('login_form.html', ['mess' => "password không chính xác. Vui lòng kiểm tra lại thông tin đăng nhâp"]);
        }
    } else {
        echo $twig->render('login_form.html', ['mess' => "email/username không chính xác. Vui lòng kiểm tra lại thông tin đăng nhâp"]);
    }
} else {
    echo $twig->render('login_form.html');
}
?>