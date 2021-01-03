<?php
  //Соединение с базой данных
  
  if($_SERVER['HTTP_HOST'] == 'geo'){
    define('HOST', 'localhost');
    define('USER_NAME', 'ahel73');
    define('PASSWORD', '');
    define('DATA_BASE', 'geo');
  }else{
    define('HOST', 'localhost');
    define('USER_NAME', 'u0455254_ahel73');
    define('PASSWORD', 'qwerty1122334455');
    define('DATA_BASE', 'u0455254_geo');
  }
  
  
  $dbc = mysqli_connect(HOST, USER_NAME, PASSWORD, DATA_BASE)or die('Ошибка подключения к MySQL серверу.');
  if(!empty($dbc)){
    mysqli_set_charset($dbc, 'utf8');
  }

  
  

  // echo 'кадировкой по умолчанию является: '. mysqli_character_set_name( $dbc ) . "\n";

  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
