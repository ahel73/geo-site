<?php
// Файл настройки путей подключается в push.php
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';

// Проверяем соответствуют ли куки данным пользователя
require_once PHP . 'proverka_cookie.php';

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$update = " parol = '" . $password . "'";
$where = "id_shifr = '{$_COOKIE['kuk1']}'";

if (!update_tablica($dbc, 'polzovateli', $update, $where)) {
    exit('2:Вы не имеете право изменять данные ' .  __LINE__);
}

// Если всё нормально то обновляем куки
if(isset($_SESSION['polzovatel']['zapomnit'])){
    setcookie("kuk1", $_COOKIE['kuk1'], time() + 60 * 60 * 24 * 30, '/');
    setcookie("kuk2", $password, time() + 60 * 60 * 24 * 30, '/');
}else{
    setcookie("kuk1", $_COOKIE['kuk1'], 0, '/');
    setcookie("kuk2", $password, 0, '/');
}

$_SESSION['polzovatel']['parol'] = $password;

echo '4:Пароль успешно изменён!';