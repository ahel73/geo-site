<?php
session_start();
$title = 'Личный кабинет';
$linck_kabinet = 'Личный кабинет';

require_once dirname(__FILE__) . '/puti.php';
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';
require_once ROOT . 'chasti_stranic/golova.php';
require_once ROOT . 'chasti_stranic/glavnay_shapka.php';

$user = $_SESSION['polzovatel'];
$fio = $user['imy_polzovately'];
$fio .= empty($fio) ? '' : ' ';
$fio .= empty($user['familiy_polzovately']) ? '' : $user['familiy_polzovately'];

?>
<div class="css_obolochka_main">
    <section class='css_leviy_block_meyna'>
        <a href="/add_uchastok.php" class='css_submit css_psevdo_btn'>добавить участок</a>
        <h2>
            Ваша контактная информация
        </h2>
        <ol>
            <li>
                Ваш логин: <span><?= $user['login_polzovately']; ?></span>
            </li>
            <li>
                <?= !empty($fio) ? $fio : 'Вы не указали как вас звать.'; ?>
            </li>
            <li>
                ваш электронный адрес: <?= !empty($user['email']) ? $user['email'] : 'не указан'; ?>
            </li>


        </ol>
        <a href="" class='js_open_modal css_psevdo_btn' data-name='user_dannie' data-roditel='forms'>
            изменить контактные данные
        </a>
        <a href="" class='js_open_modal css_psevdo_btn' data-name='smena_password' data-roditel='forms'>
            сменить пароль
        </a>

    </section>
    <main>
        <?php
// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

        ?>
    </main>
</div>

<?php
require_once ROOT . 'chasti_stranic/podval.php';
?>