<?php
// Файл настройки путей подключается в push.php
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';

// 1. Проверяем на заполненность и добавляем в строки
if (!isset($_POST['login']) || !isset($_POST['password']) || empty($_POST['login']) || empty($_POST['password'])) {
    exit('2:неполно переданные данные');
}

// 2. Очищаем логин и запрашиваем из базы данные по логину 
$login = filtr_vhodnoy_stroki($_POST['login'], 4);

$where = "login_polzovately = '" . $login . "'";
$massiv_polzovately_baza = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where);
if (!is_array($massiv_polzovately_baza)) exit('2:неверные данные для авторизации');

// 3. проверяем пароль
if(!password_verify($_POST['password'], $massiv_polzovately_baza[0]->parol)) exit('2:неверные данные для авторизации');
// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($massiv_polzovately_baza[0]);
// echo '</pre>';

// 4. Создаём куки
if (!empty($_POST['zaponit'])) {
    setcookie("kuk1", $massiv_polzovately_baza[0]->id_shifr, time() + 60 * 60 * 24 * 30, '/');
    setcookie("kuk2", $massiv_polzovately_baza[0]->parol, time() + 60 * 60 * 24 * 30, '/');
} else {
    setcookie("kuk1", $massiv_polzovately_baza[0]->id_shifr, 0, '/');
    setcookie("kuk2", $massiv_polzovately_baza[0]->parol, 0, '/');
}

// 5. Создаём сессионный масив по пользователю
$_SESSION['polzovatel'] = [];

// так как зашли при куках но без сессионного массива значит куки били запомнены, запоминаем это так как это необходимо например для смены пароля при обнавлении кук
if (!empty($_POST['zaponit'])){
    $_SESSION['polzovatel']['zapomnit'] = 1; 
}

foreach ($massiv_polzovately_baza[0] as $k => $v) {
    if ($k == 'registraciy') {
        $data_i_vremy = explode(' ', $v);
        $_SESSION['polzovatel']['data_reg'] = explode('-', $data_i_vremy[0]);
        $_SESSION['polzovatel']['vremy_reg'] = explode(':', $data_i_vremy[1]);
        switch ($_SESSION['polzovatel']['data_reg'][1]) {
            case '01':
                $mesyc = 'января';
                break;
            case '02':
                $mesyc = 'февраля';
                break;
            case '03':
                $mesyc = 'марта';
                break;
            case '04':
                $mesyc = 'апреля';
                break;
            case '05':
                $mesyc = 'мая';
                break;
            case '06':
                $mesyc = 'июня';
                break;
            case '07':
                $mesyc = 'июля';
                break;
            case '08':
                $mesyc = 'августа';
                break;
            case '09':
                $mesyc = 'сентября';
                break;
            case '10':
                $mesyc = 'октября';
                break;
            case '11':
                $mesyc = 'ноября';
                break;
            case '12':
                $mesyc = 'декабря';
                break;
        }
        $_SESSION['polzovatel']['data_reg'][3] = $mesyc;
    } else {
        $_SESSION['polzovatel'][$k] = $v;
    }
}
// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
echo 3;

