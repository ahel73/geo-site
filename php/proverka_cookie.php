<?php
// Если нет кук то выходим
if (!isset($_COOKIE['kuk1']) || !isset($_COOKIE['kuk2'])) {
    exit('2:Вы не имеете право изменять данные ' . __LINE__);
}

// Запрашиваем по идентификатору массив данных по пользователю
$where = "id_shifr = '{$_COOKIE['kuk1']}'";
$massiv_polzovately_baza = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli', $where);

// Если нет массива значит, нет такого пользователя и выходим
if (!is_array($massiv_polzovately_baza)) {
    exit('2:Вы не имеете право изменять данные ' . __LINE__);
}

// Если не совпадение по паролю то:
if ($_COOKIE['kuk2'] != $massiv_polzovately_baza[0]->parol) {
    exit('2:Вы не имеете право изменять данные ' . __LINE__);
}
?>