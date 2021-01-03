function open_modal(oe) {
    if (!oe.target.classList.contains('js_open_modal')) return;
    oe.preventDefault();
    document.body.style.overflow = 'hidden'
    var target = oe.target;
    $stroka = '/' + target.dataset.roditel + '/' + target.dataset.name + '.php';
    var ajax = new XMLHttpRequest();
    ajax.open('GET', $stroka, false);
    ajax.send();
    if (ajax.responseText[0] == '1') {
        document.querySelector('.js_podlojka').innerHTML = ajax.responseText.split(':')[1];
        document.querySelector('.js_podlojka').style.display = 'flex';
    } else {
        alert('извините такого окна не существует, обратитесь к разработчикам!')
    }
}

function cloze_modal_okno(oe, flag) {
    if (!(oe && oe.target && oe.target.classList.contains('js_cloze_modal_okno')) && !flag) 
        return;
    
    document.querySelector('.js_podlojka').innerHTML = '';
    document.querySelector('.js_podlojka').style.display = '';
    document.body.style.overflow = 'auto'
}

function submit_form(oe) {
    if (!oe.target.classList.contains('js_submit')) return;
    oe.preventDefault();
    if (proverka_zapolnyemosti_inputov(oe.target.form)) {
        return;
    }
    var ajax = new XMLHttpRequest();
    var fd = new FormData(oe.target.form)
    ajax.open('POST', '/'+ oe.target.dataset.name + '.php', false);
    ajax.send(fd);
    
     

    if (ajax.responseText[0] == '1') {
        // alert(ajax.responseText.split(':')[1]);
        cloze_modal_okno(false, true)
        var ajax = new XMLHttpRequest();
        ajax.open('GET', '/forms/' + oe.target.dataset.dop_okno +'.php', false);
        ajax.send();
        if (ajax.responseText[0] == '1') {
            document.querySelector('.js_podlojka').innerHTML = ajax.responseText.split(':')[1];
            document.querySelector('.js_podlojka').style.display = 'flex';
        }
        
    } else if (ajax.responseText[0] == '2') {
        alert(ajax.responseText.split(':')[1]);
    } else if (ajax.responseText[0] == '3') {
        location.reload(true);
    } else if (ajax.responseText[0] == '4') {
        console.log(ajax.responseText.split(':')[1]);
        var zapros = ajax.responseText.split(':')[1];
        cloze_modal_okno(false, true)
        var ajax = new XMLHttpRequest();
        ajax.open('GET', '/forms/inform_okno.php?text='+ zapros, false);
        ajax.send();
        if (ajax.responseText[0] == '1') {
            document.querySelector('.js_podlojka').innerHTML = ajax.responseText.split(':')[1];
            document.querySelector('.js_podlojka').style.display = 'flex';
        }
    }
}
function proverka_zapolnyemosti_inputov(form) {
    var inputi = form.getElementsByClassName('js_obyzatelniy');
    var flag_nezapolnennosti = false;
    for (var i = 0; i < inputi.length; i++) {

        if (!inputi[i].value) {
            inputi[i].placeholder = inputi[i].dataset.podskazka;
            inputi[i].classList.add('css_ne_zapolnen', 'js_ne_zapolnen');
            

            flag_nezapolnennosti = true;
        }
    }
    if (flag_nezapolnennosti) {
        return true
    } else {
        return false;
    }
}

function otmena_nazapolnennosti(oe) {
    if (!oe.target.classList.contains('js_ne_zapolnen')) return;
    oe.target.classList.remove('css_ne_zapolnen', 'js_ne_zapolnen');
}

function best(oe) {
    if (!oe.target.classList.contains('js_best')) return;
    oe.preventDefault();
    var idUser = oe.target.closest('.js_user').dataset['uzer'];
    var ajax = new XMLHttpRequest();
    ajax.open('GET', '/push.php?method=' + oe.target.dataset.method + '&user=' + idUser, false);
    ajax.send()
    var arrayResponseText = ajax.responseText.split(':');
    alert(arrayResponseText[1]);
    if (arrayResponseText[0] == 1) {
        location.assign('/');
    }
}


document.body.addEventListener('click', function (oe) {
    open_modal(oe);
    cloze_modal_okno(oe);
    submit_form(oe);
    best(oe);
})
document.body.addEventListener('input', function (oe) {
    otmena_nazapolnennosti(oe);
})
