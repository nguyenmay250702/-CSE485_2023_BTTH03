<?php
require 'vendor/autoload.php';
require 'config/database.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

if (isset($_GET['email']) && isset($_GET['activation_code'])) {
    $db = new Database();
    $arguments['email'] = $_GET['email'];
    $arguments['activation_code'] = $_GET['activation_code'];
    $sql_update = "UPDATE users SET `status`=1 WHERE email=:email AND activation_code = :activation_code";

    $db->runSQL($sql_update, $arguments);
    echo $twig->render('active_account.html',['mess_success'=>'Kích hoạt tài khoản email thành công']);
} else {
    echo $twig->render('active_account.html',['mess_pail'=>'Bạn phải đăng nhập từ đường dẫn được chúng tôi gửi qua email đã đăng ký']);
}

?>