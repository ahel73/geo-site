1:<form action="" method="POST">
    <h2>авторизируйтесь для работы на сайте</h2>
    <label for="">
        <input type="text" class='js_obyzatelniy' name='login' data-podskazka='Укожите логин'>
        <span>Логин</span>
    </label>
    <label for="">
        <input type="password" class='js_obyzatelniy' name="password" data-podskazka='Укожите пароль'>
        <span>Пароль</span>
    </label>
    <label for="">
        <input type="checkbox" name="zaponit">
        <span>Запомнить</span>
    </label>
    <input type="hidden" name="avtorizaciy" value='on'>
    <div class="css_block_knopok">

        <button class='css_btn css_submit js_submit' data-name='push' data-dop_okno='vibor_deystviy'>отправить</button>
        <button type="button" class='css_btn js_cloze_modal_okno'>отмена</button>
    </div>
</form>