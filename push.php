<?php
session_start();
// Эта страница используется для перенаправления на другие страница
require_once dirname(__FILE__) . '/puti.php';
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';


// Регистрация пользователя
if(isset($_POST['registraciy'])){
    require_once PHP . 'reg.php';
    exit;
}

// авторизация пользователя
if (isset($_POST['avtorizaciy'])) {
    require_once PHP . 'avtoriz.php';
    exit;
}

// смена контактных данных пользователя smena_dannih_user
if (isset($_POST['smena_dannih_user'])) {
    require_once PHP . 'izminenue_dannih_uzera.php';
    exit;
}

// Смена пароля
if (isset($_POST['smena_password'])) {
    require_once PHP . 'izminenue_paroly.php';
    exit;
}

// Если выход
if (!empty($_GET['vihod'])) {
    setcookie("kuk1");
    setcookie("kuk2");
    unset($_SESSION['polzovatel']);
    header('Location: ' . SAYT);
    exit;
}

// если избранные
// Если выход
if (!empty($_GET['method'])) {
    require_once PHP . 'best.php';
    exit;
}

// если не одно из условий не выполнено то переходим на главную
header("Location: ".SAYT);

  
?>