<?php
// Файл настройки путей подключается в push.php
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';

// Проверяем соответствуют ли куки данным пользователя
require_once PHP . 'proverka_cookie.php';

// Если всё нормально до обновляем данные пользователя 
$stroka_obnovleniy = ' ';
foreach($_POST as $k => $v){
    if(empty($v)) continue;
    if($k == 'name'){
        $stroka_obnovleniy .= "imy_polzovately = '". filtr_vhodnoy_stroki($v)."',";
    } 
    elseif ($k == 'familiy') {
        $stroka_obnovleniy .= "familiy_polzovately = '" . filtr_vhodnoy_stroki($v) . "',";
    } elseif ($k == 'email') {
        $stroka_obnovleniy .= "email = '" . filtr_vhodnoy_stroki($v) . "',";
    }

}
$stroka_obnovleniy = rtrim($stroka_obnovleniy, ',');


if(!update_tablica($dbc, 'polzovateli', $stroka_obnovleniy, $where)){
    exit('2:Вы не имеете право изменять данные ' .  __LINE__);
}

// Запрашиваем данные для обнавления сессионного массива
$massiv_polzovately_baza = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where);
if (!is_array($massiv_polzovately_baza)) exit('2:неверные данные для авторизации');
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
