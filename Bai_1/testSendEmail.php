<?php
require 'vendor/autoload.php';
require 'interfaces/EmailServerInterface.php';
require 'class/MyEmailSender.php';
require 'class/EmailSender.php';

$emailServer = new MyEmailServer();
$emailSender = new EmailSender($emailServer);
$emailSender->send("2051063448@e.tlu.edu.vn", "Mr.KTDung", "Điểm Danh_9/3", "Nguyễn Thị Mây 62TH1 điểm danh");

?>