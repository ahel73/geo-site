<?php
session_start();
$title = 'Добавление земельного участка';
$linck_kabinet = 'Личный кабинет';

require_once dirname(__FILE__) . '/puti.php';
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';
require_once ROOT . 'chasti_stranic/golova.php';
require_once ROOT . 'chasti_stranic/glavnay_shapka.php';

?>
<div class="css_obolochka_main">
    <section class='css_leviy_block_meyna'>
        <h1>Страница добавления участка</h1>
        <form action="">
            <div class='css_block_lb'>
                <h2>
                    Данные замлепользователя
                </h2>
                <!-- Надо бы ИНН что бы идентифицировать пользователя, а что если юрлицо -->
                <label for="">
                    <span>Ффамилия</span>
                    <input type="text" name='familiy'>
                </label>
                <label for="">
                    <span>Имя</span>
                    <input type="text" name='imy'>
                </label>
                <label for="">
                    <span>Отчество</span>
                    <input type="text" name='otchestvo'>
                </label>
            </div>
            <div class='css_block_lb'>
                <h2>
                    Данные земельного участка
                </h2>
                <label for="">
                    <span>Год получения з/у</span>
                    <input type="text" name='god_polucheniy'>
                </label>
                <label for="">
                    <span>Кадастровый номер</span>
                    <input type="text" name='kadastroviy_nomer'>
                </label>
            </div>
            <div>
                <input class='css_submit' type="submit" name='add' value='Добавить участок'>
                <input type="reset" value='очистить данные'>
            </div>

        </form>

    </section>
    <main>
        <div id='map' class='css_konteyner_map'></div>
    </main>
</div>


<?php
require_once ROOT . 'chasti_stranic/podval.php';
?>