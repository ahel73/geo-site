<?php

if ($_GET['method'] == 'add' && !empty($_GET['user']) && (int) $_GET['user']) {
    
    if (is_array(vozvrat_massiva_chego_ta_iz_bazi($dbc,'best_users', " boss_id={$_SESSION['polzovatel']['id_polzovately']} AND best_user_id={$_GET['user']}"))){
        exit('2:пользователь уже добвлен в избранные');
    }
    
    if (insert_dannih_v_tablicu($dbc, 'best_users', 'boss_id, best_user_id', $_SESSION['polzovatel']['id_polzovately'] . ', ' . $_GET['user']) !== false) {
        exit('1:добавлен');
    } else {
        exit('2:ошибка добавления');
    };
    
} else if ($_GET['method'] == 'remove' && !empty($_GET['user']) && (int) $_GET['user']) {

    if (empty(update_tablica($dbc, 'best_users', null, "boss_id={$_SESSION['polzovatel']['id_polzovately']} AND best_user_id={$_GET['user']}"))) {
        exit('2:ошибка удаления');
    } else {
        exit('1:пользователь удалён из избранных');
    }
    
    

    exit('2:удаляемся');
} else {
    exit('2:некорректные данные');
}
