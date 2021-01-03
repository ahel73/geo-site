<?php

// https://medium.com/@shpaginkirill/вменяемая-инструкция-к-phpmailer-отправка-писем-и-файлов-на-почту-b462f8ff9b5c
// Этот файл взят из инструкции и скоректирован

// Файлы phpmailer
// require 'PHPMailer.php';
// require 'SMTP.php';
// require 'Exception.php';

// Переменные, которые отправляет пользователь
// $name = $_POST['name'];
// $email = $_POST['email'];
// $text = $_POST['text'];
// $mail = new PHPMailer\PHPMailer\PHPMailer();
// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

// echo __FILE__ . ' ' . __LINE__;
// echo '<pre>';
// print_r($mail);
// echo '</pre>';

// try {
//   $msg = "ok";
//   $mail->isSMTP();
//   $mail->CharSet = "UTF-8";
//   $mail->SMTPAuth   = true;
//   // Настройки вашей почты
//   $mail->Host       = 'smtp.yandex.ru'; // SMTP сервера 
//   $mail->Username   = 'nag495@yandex.ru'; // Логин на почте
//   $mail->Password   = '123qsceszadwx'; // Пароль на почте
//   $mail->SMTPSecure = 'SSL';
//   $mail->Port       = 587;
//   $mail->setFrom('nag495@yandex.ru', 'Нагаев А.н.'); // Адрес самой почты и имя отправителя
//   // Получатель письма
//   $mail->addAddress('nag495@yandex.ru');
// $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

  
  
//   // Само письмо
//   // -----------------------
//   $mail->isHTML(true);

//   $mail->Subject = 'Заголовок письма';
//   $mail->Body    = "<b>Имя:</b> $name <br>
//         <b>Почта:</b> $email<br><br>
//         <b>Сообщение:</b><br>$text";
//   // Проверяем отравленность сообщения
//   if ($mail->send()) {
//     echo "$msg";
//   } else {
//     echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
//     echo $mail->ErrorInfo;
//     echo __FILE__ . ' ' . __LINE__;
//     echo '<pre>';
//     print_r($mail);
//     echo '</pre>';
//   }
// } catch (Exception $e) {
//   echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
// }
$massiv_nastoek_dly_pisma = [
  'faili_phpmailer' => [
    'PHPMailer.php',
    'SMTP.php',
    'Exception.php'
  ],
  'put_do_filov' => '',
  'smtp' => 'smtp.yandex.ru',
  'login' => 'nag495@yandex.ru',
  'parol' => '123qsceszadwx',
  'smtp_prefix' => 'SSL',
  'smtp_port' => 587,
  'pochta_otpravitely' => 'nag495@yandex.ru',
  'imy_otpravitely' => 'Нагаев А.Н.',
  'pochta_poluchately' => 'nag495@yandex.ru',
  'zagolovok_pisma' => 'тестовый заголово',
  'telo_pisma' => "<b>Имя:</b> Алексей <br><b>Почта:</b> 1111111<br><br><b>Сообщение:</b><br>222222222"
];
function otpravka_pisma($massiv_nastroek){
  
  $mn = $massiv_nastroek;
  // Необходимо подключить файлы с классом 
  if(isset($mn['include'])){
    if(!is_array($mn['include'])) 
      return 'пути должны быть массивом! '. __FILE__ . ' ' . __LINE__;
    for($i = 0; $i < count($mn['include']); $i++){
      include_once $mn['put_do_filov'] .''. $mn['faili_phpmailer'][$i];
    }
  }
    
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $msg = "ok";

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
  $mail->setFrom($mn['pochta_otpravitely'], $mn['imy_otpravitely']); // Адрес самой почты и имя отправителя
  $mail->addAddress($mn['pochta_poluchately']);// Получатель письма


  // Само письмо
  $mail->isHTML(true); // письмо в HTML формате
  $mail->Subject = $mn['zagolovok_pisma'];
  $mail->Body    = $mn['telo_pisma']; 
  if ($mail->send()){
    return 'письмо отправлено ' . __FILE__ . ' ' . __LINE__;
  }
  else{
    return  'письмо не отправлено ' . __FILE__ . ' ' . __LINE__;
  }
}
 echo otpravka_pisma($massiv_nastoek_dly_pisma);
$massiv_nastoek_dly_pisma['zagolovok_pisma'] = 'gf;gh;fgh;fgh';
echo otpravka_pisma($massiv_nastoek_dly_pisma);
?>
