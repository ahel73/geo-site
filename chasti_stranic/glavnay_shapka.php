<?php

// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

?>
<header class='css_shapka'>
    <div class="css_logo">
        <a href="<?=SAYT?>">название сайта</a>
        
    </div>
    <div class="css_block_avtorizacii">
        <?php
        if (!isset($_SESSION['polzovatel'])) {
        ?>

            <a href="" class='js_open_modal' data-name='registraciy' data-roditel='forms'>
                Зарегистрироваться
            </a>
            <a href="" class='js_open_modal' data-name='avtorizaciy' data-roditel='forms'>
                войти
            </a>
        <?php
        } else {
        ?>
            <a href="/lk.php" >
                <?= empty($_SESSION['imy_polzovately']) ? $linck_kabinet : $_SESSION['imy_polzovately'] . ' ' . @$_SESSION['familiy_polzovately'];?>
            </a>
            <a href="/push.php?vihod=on">
                выйти
            </a>
        <?php
        }
        ?>
    </div>
</header>