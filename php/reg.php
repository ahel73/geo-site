<?php
// Файл настройки путей подключается в push.php
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';

// echo '1:';
// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

// 1. Проверяем на заполненность и добавляем в строки
if(!isset($_POST['login']) || !isset($_POST['password']) || empty($_POST['login']) || empty($_POST['password'])){
    exit('2:неполно переданные данные');
}

$login = filtr_vhodnoy_stroki($_POST['login'], 4);


// Проверяем логин на существование
$where = "login_polzovately = '" . $login . "'";
if(is_array(vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where))){
    exit('2:такой логин уже существует замените');
}

if(!mysqli_begin_transaction($dbc)) exit('2:ошибка при добавлении попробуйте снова или обратитесь к разработчику');

// Шифруем пароль
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stolbci = 'login_polzovately, parol';
$dannie = "'".$login . "', '" . $password ."'";

$id = insert_dannih_v_tablicu($dbc, 'polzovateli', $stolbci, $dannie);


$id_shufr = password_hash($id, PASSWORD_DEFAULT);
$set = "id_shifr = '{$id_shufr}'";
$where = "id_polzovately = '{$id}'";

if (update_tablica($dbc, 'polzovateli', $set, $where)) {
    mysqli_commit($dbc);
}

// Создаём куки
if(!empty($_POST['zaponit'])){
    setcookie("kuk1", $id_shufr, time() + 60 * 60 * 24 * 30, '/');
    setcookie("kuk2", $password, time() + 60 * 60 * 24 * 30, '/');
}else{
    setcookie("kuk1", $id_shufr, 0, '/');
    setcookie("kuk2", $password, 0, '/');
}
echo '1:поздравляю вы зарегистрированы';



$where = "login_polzovately = '" . $login . "'";
$dannie_polzovately = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where)[0];
$_SESSION['polzovatel'] = [];
// так как зашли при куках но без сессионного массива значит куки били запомнены, запоминаем это так как это необходимо например для смены пароля при обнавлении кук
if (!empty($_POST['zaponit'])) {
    $_SESSION['polzovatel']['zapomnit'] = 1;
}
foreach ($dannie_polzovately as $k => $v) {
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



// // Отправляем письмо 
// $massiv_nastroek = include_once ROOT . 'massivi/massiv_nasstroek_phpmailer.php';
// // Подправляем путь до файлов которые подключаем в функции
// $massiv_nastroek['put_do_filov'] = ROOT . '' . $massiv_nastroek['put_do_filov'];
// // 10.4. заполняем данные для отправки уведомления пользователя. Имя отправителя уже сохранено при разборе массива
// $massiv_nastroek['pochta_poluchately'] = $_GET['mail'];
// $massiv_nastroek['imy_otpravitely'] = 'ACTIVE CAPITAL';
// $massiv_nastroek['zagolovok_pisma'] = 'Теперь вы пользователь сервиса ACTIVE CAPITAL';
// $massiv_nastroek['telo_pisma'] = $_GET['imy'] . '! Ждём Вас на нашем портале!';
// // 10.5. Отправляем письмо
// otpravka_pisma($massiv_nastroek);

// exit('1:регистрация прошла успешно');

// // header('Location: ' . SAYT . 'cabinet.php');
