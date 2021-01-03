<?php

/*
  - 1 - filtr_vhodnoy_stroki -  проверяет данные полученные из форм  браузера на допустимость безопасности
  - 2 - vozvrat_massiva_chego_ta_iz_bazi - запрашивает данные из одной таблицы указанной в аргументе формирует массив и возвращает его
  - 3 - return_svg_img Функция возвращает svg изображение, что бы минимизировать код в пхп файле
  - 4 - otpravka_pisma - отправка электронного письма
  - 5 - insert_dannih_v_tablicu - добавляет данные в таблицу.
  - 6 - update_tablica - обнавляет данные в таблицы и возвращает количество изминённых строк
*/






// - 1 - filtr_vhodnoy_stroki - проверяет данные полученные из форм  браузера на допустимость безопасности
function filtr_vhodnoy_stroki($string, $flag_type = 1, $flag_tag = true)
{

    /*  ПРОВЕРЯЕТ ВХОДНЫЕ СТРОКИ И ПРИ НЕОБХОДИМОСТИ ПРЕОБРАЗУЕТ ИХ В ЧИСЛА
   * - $string - входная строка
   * 
   * - $flag_type - определяет тип данных который необходимо вернуть из функции в случаи успешной обработки строки
   *   - 1 - строка
   *   - 2 - целое число
   *   - 3 - дробное число
   *   - 4 - строка с удалёнными начальными и конечными пробелами
   * 
   * - $flag_tag - указывает удалять или нет html теги в строке
   *   - true - не удалять
   *   - false - удалять
   * 
  
   * htmlentities - экранирует теги и кавычки, 
   * addslashes - экранирует специальные символы, напрмиер '-' коментарий MySql
   * strip_tags - удаляет теги, можно указать какие не удалять
   * При выводе данных проверять если имеется теги скрипт или стиль то превращать открывающую скобку в сущность
  */
    // return htmlspecialchars($string); //- преобраует скобки в сущности
    // return addslashes($string); // - экранирует символы


    if ($flag_type == 2 || $flag_type == 3) {
        $string = trim($string);
        if ($flag_type == 2) return filter_var($string, FILTER_VALIDATE_INT);
        if ($flag_type == 3) return filter_var($string, FILTER_VALIDATE_FLOAT);
    } else {
        if ($flag_type == 4) {
            $string = trim($string);
        }
        if ($flag_tag === false) {
            // удаляем теги
            $string = filter_var($string, FILTER_SANITIZE_STRING);
        }

        // Превращаем <>&"' в html сущности
        $string = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        // Заменяем -- на их сущности и возвращаем. Два тере используются для комментов в базе данных поэтом их заменяем на сущности
        return preg_replace('/\s--\s/', '&#32;&#45;&#45;&#32;', $string);
    }
}



// - 2 - vozvrat_massiva_chego_ta_iz_bazi - запрашивает данные из одной таблицы указанной в аргументе формирует массив и возвращает его
// Сделал по дибильному если надо отправить полный запрос то мы его передаём в имя таблицы и ставим в парметре полный запрос истину
// Ещё затупил что возвращается два в случаи неудачи, надо учитывать, так как возникают ошибки если не учитываю поэтому лучше делать проверку массив или нет
/**
 *  - 2 - vozvrat_massiva_chego_ta_iz_bazi - запрашивает данные из одной таблицы формирует массив и возвращает его
 * 
 * Сделал по дибильному если надо отправить полный запрос то мы его передаём в имя таблицы и ставим в парметре полный запрос истину Ещё затупил что возвращается два в случаи неудачи, надо учитывать, так как возникают ошибки если не учитываю поэтому лучше делать проверку массив или нет
 * 
 * @param object $id_dbc объект подключения mysqli
 * @param string $tab_bazi имя базы данных
 * @param string $where параметры сравнения указываемые после оператора WHERE, по умолчанию пустая строка
 * @param string $string_dannih имена извлекаемых столбцов по умолчанию *
 * @param string $string_sort сортировка по умолчанию пустая строка
 * @param string $sort сортировка выдачи, по умолчанию ASC
 * @param string $polniy_zapros строка полного запроса, по умолчанию '', если не пустая строка то все другие параметры игнорируются
 * @return array|int|bool Индексный если есть что возвразать, если выборка не вернула резульат то 2, если ошибка то false
 */
function vozvrat_massiva_chego_ta_iz_bazi($id_dbc, $tab_bazi, $where = '', $string_dannih = '*', $string_sort = '', $sort = 'ASC', $polniy_zapros = '')
{

    if (empty($polniy_zapros)) {
        $stroka_zaprosa = "SELECT " . $string_dannih . " FROM " . $tab_bazi;
    } else {
        $stroka_zaprosa = $tab_bazi;
    }

    $return_massiv = [];

    if (!empty($where)) {
        $stroka_zaprosa .= ' WHERE ' . $where;
    }

    if (!empty($string_sort)) {
        $stroka_zaprosa .=  " ORDER BY " . $string_sort . " " . $sort;
    }
    
    $obj_zaprosa = mysqli_query($id_dbc, $stroka_zaprosa);
    

    if ($obj_zaprosa->num_rows == 0) {
        return 2;
    }
    while ($stroka_zaprosa = mysqli_fetch_object($obj_zaprosa)) {
        $return_massiv[] = $stroka_zaprosa;
    }
    
    return $return_massiv;
}




/** - 3 - return_svg_img Функция возвращает svg изображение, что бы минимизировать код в пхп файле, в качестве параметрова указывается:
    * - путь до файла
    * - набор применяемых классов - что бы классы были вставлены, в файле svg изображения необходимо указать вывод аргумента с именем класса в нужном месте кода. Для этого файлу svg даём расширение php
    * - data_atr - строка дата атрибуттов которые можно вставить в свг
    * - ВАЖНО 
    */
function return_svg_img($path, $class_name = '', $data_atr = '')
{
    $class = (!empty($class_name)) ? 'class="' . $class_name . '" ' : "";
    return require $_SERVER['DOCUMENT_ROOT'] . '' . $path;
}




// - 4 - otpravka_pisma - отправка электронного письма 
function otpravka_pisma($massiv_nastroek)
{
    // Массив с настройками по умолчанию не забудь подключить перед вызовом и изменить нужные элементы массива
    $mn = $massiv_nastroek;

    // Необходимо подключить файлы с классом 
    if (isset($mn['faili_phpmailer'])) {
        if (!is_array($mn['faili_phpmailer']))
            return 'пути должны быть массивом! ' . __FILE__ . ' ' . __LINE__;
        for ($i = 0; $i < count($mn['faili_phpmailer']); $i++) {
            include_once $mn['put_do_filov'] . '' . $mn['faili_phpmailer'][$i];
        }
    }

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // Настройки вашей почты
    $mail->isSMTP(); // Указываем, что отправляем сообщение методом smtp
    $mail->CharSet = "UTF-8"; // кодировка
    $mail->SMTPAuth   = true; // Сообщаем что нужна аутентификация, сопадение логин пароль  
    $mail->Host       = $mn['smtp']; // SMTP сервера 
    $mail->Username   = $mn['login']; // Логин на почте
    $mail->Password   = $mn['parol']; // Пароль на почте
    $mail->SMTPSecure = $mn['smtp_prefix']; // Префикс соединения «», «ssl» или «tls»
    $mail->Port       = $mn['smtp_port'];; // Порт для SMTP сервера
    // на заметку изминение почты отправителя не отправляет письмо, изминеие имени отправляет и во входящем письме указывается изминённое имя
    $mail->setFrom($mn['pochta_otpravitely'], $mn['imy_otpravitely']); // Адрес самой почты и имя отправителя.  
    $mail->addAddress($mn['pochta_poluchately']); // Получатель письма
    // Если надо копию то: (Надо сделать циклом получателей)
    $mail->addAddress('nag495@yandex.ru');


    // Само письмо
    $mail->isHTML(true); // письмо в HTML формате
    $mail->Subject = $mn['zagolovok_pisma'];
    $mail->Body    = $mn['telo_pisma'];
    if ($mail->send()) {
        // отправлено
        return true;
    } else {
        // не отправлено
        return  null;
    }
}




/**
 *  - 5 - insert_dannih_v_tablicu  добавляет данные в таблицу. 
 * 
 * @param object $obj_dbs  объект подключения mysqli
 * @param string table_name  имя таблицы
 * @param string $stroka_stolbcov  строка столбцов
 * @param string $stroka_dannih  строка добавляемых данных
 * @param string $polniy_zapros полный запрос
 * @return int в случае удачи id пользователя либо 0
 */
function insert_dannih_v_tablicu($obj_dbs, $table_name, $stroka_stolbcov, $stroka_dannih, $polniy_zapros = '')
{
    
    if (empty($polniy_zapros)) {
        $zapros = "INSERT INTO " . $table_name . " (" . $stroka_stolbcov . ") VALUES (" . $stroka_dannih . ")";
    } else {
        $zapros = $polniy_zapros;
    }
   
    if (!mysqli_query($obj_dbs, $zapros)) {
        return 0;
    }


    return mysqli_insert_id($obj_dbs);
}

// - 6 - update_tablica - обнавляет данные в таблицы и возвращает количество изминённых строк
function update_tablica($obj_dbs, $table_name, $chto_menyem, $sravnenie)
{
    if (!empty($chto_menyem)) {
        $update_string = "UPDATE {$table_name} SET {$chto_menyem} WHERE {$sravnenie}";
    } else {
        $update_string = "DELETE FROM {$table_name} WHERE {$sravnenie}";
    }
    
    if (!mysqli_query($obj_dbs, $update_string)) {
        return 0;
    }

    return mysqli_affected_rows($obj_dbs);
}
