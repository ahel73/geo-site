<?php

// 1. Если заходим не на главную и нет кук то перекидываем на главную
if($_SERVER['PHP_SELF'] != '/index.php' && (!isset($_COOKIE['kuk1'] )|| !isset($_COOKIE['kuk2']))){
    header('Location: /');
    exit;
}
// 2. Если есть куки но нет сессионного массива (например первый заход на страницу) то авторизируемся и формируем массив пользователя
elseif(isset($_COOKIE['kuk1']) && isset($_COOKIE['kuk2']) && !isset($_SESSION['polzovatel'])){
    
    // Запрашиваем по идентификатору массив данных по пользователю
    $where = "id_shifr = '{$_COOKIE['kuk1']}'";
    $massiv_polzovately_baza = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where);

    // Если нет массива значит, нет такого пользователя и надо удалить куки и на главную
    if (!is_array($massiv_polzovately_baza)){
        setcookie("kuk1");
        setcookie("kuk2");

        if($_SERVER['PHP_SELF'] != '/index.php'){
            header('Location: /index.php');
            exit;
        }
        // Ставим флаг что бы не сформировать массив пользователя на главной
        $flag_nesootvetstviy = true;
    } 
    // Если массив значит совпадение по идентификатору  идём дальше и надо проверить совпадение по паролю
    else{
        // Если не совпадение по паролю то:
        if($_COOKIE['kuk2'] != $massiv_polzovately_baza[0]->parol){
            setcookie("kuk1");
            setcookie("kuk2");

            if($_SERVER['PHP_SELF'] != '/index.php'){
                header('Location: /index.php');
                exit;
            }
            // Ставим флаг что бы не сформировать массив пользователя на главной
            $flag_nesootvetstviy = true;
        }
    }

    // Если нет флага несовпадения значит все проверки пройдены и надо формировать сессионный массив пользователя
    if(!isset($flag_nesootvetstviy)){
        $_SESSION['polzovatel'] = [];
        $_SESSION['polzovatel']['zapomnit'] = 1; // так как зашли при куках но без сессионного массива значит куки били запомнены, запоминаем это так как это необходимо например для смены пароля при обнавлении кук
        
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
    }
}
?>