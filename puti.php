<?php
define('ROOT', dirname(__FILE__) . '/');
$protocol = isset($_SERVER["REQUEST_SCHEME"]) ? $_SERVER["REQUEST_SCHEME"] : $_SERVER['HTTP_X_FORWARDED_PROTO'];
define('SAYT', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/');
define('PHP', ROOT . 'php/');
?>