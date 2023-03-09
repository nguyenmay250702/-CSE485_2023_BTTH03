<?php
require 'vendor/autoload.php';
require 'interfaces/EmailServerInterface.php';
require 'class/MyEmailSender.php';
require 'class/EmailSender.php';
require 'config/database.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

if (isset($_POST['btn'])) {
    $txt_email = trim($_POST['txt_email']);
    $txt_user = trim($_POST['txt_user']);
    $txt_pass = trim($_POST['txt_pass']);

    $db = new Database();

    $sql_select = "SELECT * FROM users WHERE email = :txt_email OR username =:txt_user";
    $arguments['txt_email'] = $txt_email;
    $arguments['txt_user'] = $txt_user;

    $result = $db->runSQL($sql_select, $arguments)->fetchAll();

    // kiểm tra xem email đã có trong db chưa
    if (count($result) == 0) { //email chưa tồn tại
        //mã hóa mật khẩu
        $password_hash = password_hash($txt_pass, PASSWORD_DEFAULT);

        //tạo mã code tự động
        $activation_code = md5(rand());

        //thêm tk đó vào trong db
        $sql_insert = "INSERT INTO users (email, username, password, activation_code) VALUES (:txt_email,:txt_user,:password_hash,:activation_code)";
        $arguments['password_hash'] = $password_hash;
        $arguments['activation_code'] = $activation_code;

        $db->runSQL($sql_insert, $arguments);

        //tạo ra đường dẫn kích hoạt
        $path = '<a href="http://localhost/private/BTTH03/CSE485_2023_BTTH03/Bai_1/active_account.php?email=' . $txt_email . '&activation_code=' . $activation_code . '"><button">Kích hoạt tài khoản YoYo</button></a>';

        //gửi link kích hoạt tk vào email
        $emailServer = new MyEmailServer();
        $emailSender = new EmailSender($emailServer);
        $emailSender->send("$txt_email", "Mr.MayTLU", "Kích hoạt tài khoản email", "$path");

        echo $twig->render('register_form.html', ['mess' => "yêu cầu kích hoạt đã được gửi đến $txt_email"]);
    } else {
        echo $twig->render('register_form.html', ['mess' => "email/username đã tồn tại"]);
    }

} else {
    echo $twig->render('register_form.html');
}
?>