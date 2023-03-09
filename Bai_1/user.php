<?php
require 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

session_start();
if(isset($_SESSION['username']) && isset($_SESSION['role']) && ($_SESSION['role']==0)){
    echo $twig->render('user.html');
}else{
    header("location:login.php");
}
?>