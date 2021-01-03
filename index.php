<?php
session_start();

$title = 'Стартовая страница';
$linck_kabinet = 'В личный кабинет';
require_once dirname(__FILE__) . '/puti.php';
require_once PHP . 'connection_db.php';
require_once PHP . 'function.php';
require_once ROOT . 'chasti_stranic/golova.php';
require_once ROOT . 'chasti_stranic/glavnay_shapka.php';
?>

<div class='css_obolochka_main css_index'>
    <?php
    
    if (!empty($_SESSION['polzovatel'])) {
        // Получаем массив идентификаторов избранных пользователей и добавляем их в сессию
        $usersBest = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'best_users', " boss_id={$_SESSION['polzovatel']['id_polzovately']}");
        $_SESSION['polzovatel']['bests'] = [];
        if (is_array($usersBest)) {
            foreach ($usersBest as $value) {
                $_SESSION['polzovatel']['bests'][] = $value->best_user_id;
            }
        } 
        



        $users = vozvrat_massiva_chego_ta_iz_bazi($dbc, 'polzovateli');
    ?>
        <h1>Список зарегистрированных пользователей</h1>
        <ol>
            <?php
            foreach ($users as $user) {
                if ($user->login_polzovately == $_SESSION['polzovatel']['login_polzovately']) continue;

                // если идентификатор юзера есть в массиве избранных значить переводим перенную в истину
                $user_best = null;
                if (in_array($user->id_polzovately, $_SESSION['polzovatel']['bests'])) {
                    $user_best = true;
                }
            ?>
                <li class='js_user' data-uzer='<?= $user->id_polzovately ?>'>
                    <p class='name-user'><?= !empty($user->familiy_polzovately) ? $user->familiy_polzovately : 'фамилия не указана' ?> <?= !empty($user->imy_polzovately) ? $user->imy_polzovately : 'имя не указана' ?></p>
                    <p>email: <?= !empty($user->email) ? $user->email : 'не указана' ?></p>
                    <p>логин: <?= $user->login_polzovately ?></p>
                    <p>зарегистрирован: <?= $user->registraciy ?></p>
                    <div class="css_kntnr_buttons">
                        <?= isset($user_best) ?
                            'В избранных <button class="js_best" type="button" data-method="remove">Убрать из избранных</button>'
                            : "<button class='js_best' type='button' data-method='add'>Добавить в избранные</button>" ?>

                    </div>

                </li>
            <?php
            }
            ?>
        </ol>
    <?php
    } else {
        echo '<h1>зарегистриуйтесь либо войдите на сайт</h1>';
    }
    ?>
</div>
<?php
require_once ROOT . 'chasti_stranic/podval.php';
?>