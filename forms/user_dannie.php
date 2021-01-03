1:<form action="" method="POST">
    <h2>укажите ваши данные</h2>
    <label for="">
        <input type="text" name='name'>
        <span>Имя</span>
    </label>
    <label for="">
        <input type="text" name="familiy">
        <span>Фамилия</span>
    </label>
    <label for="">
        <input type="text" name="email">
        <span>эл.почта</span>
    </label>

    <input type="hidden" name="smena_dannih_user" value='on'>
    <div class="css_block_knopok">

        <button class='css_btn css_submit js_submit' data-name='push' data-dop_okno='vibor_deystviy'>отправить</button>
        <button type="button" class='css_btn js_cloze_modal_okno'>отмена</button>
    </div>
</form>