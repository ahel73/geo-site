<?php
include_once PHP . 'auto_avtoriz.php'
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($title) ? $title : 'Страница сайта'; ?></title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <?php
    if ($_SERVER['PHP_SELF'] == '/add_uchastok.php') {
    ?>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=f7c9492c-9ed7-4bf3-a3e3-95d36735ac83&lang=ru_RU" type="text/javascript">
        </script>
    <?php
    }
    ?>
</head>

<body>