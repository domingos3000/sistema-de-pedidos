<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__ . './vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'emailparatestesdeaplicacoes@gmail.com';                     //SMTP username
    $mail->Password   = 'slxjfzzlsvxcfqoh';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('emailparatestesdeaplicacoes@gmail.com', 'Teste de Aplicacoes');
    $mail->addAddress('domingosnkulajw@gmail.com', 'Domingos Nkula Pedro');     //Add a recipient
    $mail->addReplyTo('emailparatestesdeaplicacoes@gmail.com', 'Teste de Aplicacoes');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Testando o PHPMailer';
    $mail->Body    = '<h2>Testado com sucesso!</h2> <p>Os testes foram executados com sucesso!</p>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Email enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar o email: {$mail->ErrorInfo}";
}