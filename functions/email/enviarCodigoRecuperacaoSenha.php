<?php

header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . './../../vendor/autoload.php';

function enviarEmailParaUsuario($usuarioEmail, $usuarioNome, $codigoConfirmacao){

    $codigo = $codigoConfirmacao;

    // Sobre seu email

    $meu_nome = "Ramazani Antonio & Pedro Mawete";
    $meu_email = "cafcontrol66@gmail.com";
    $minha_senha = "blaeupzqnqusmbvc";

    // Sobre o usuário

    $nome_usuario = $usuarioNome;
    $email_usuario = $usuarioEmail;

    // Sua mensagem

    $assunto = "Mudar sua senha";
    $mensagem = "
        Olá $nome_usuario, tudo bem consigo? Esperamos que sim. <hr>
        Aqui está o seu código para redefinir sua senha. Não partilhe com ninguém para sua segurança:
        <br> 
        <h1>$codigo</h1>
    ";

    // PHPMAILER

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();                                  
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $meu_email;
        $mail->Password   = $minha_senha;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom($meu_email, $meu_nome);
        $mail->addAddress($email_usuario, $nome_usuario);
        $mail->addReplyTo($meu_email, $meu_nome);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if($mail->send()){
            return true;
        };
    } catch (Exception $e) {
        return false;
    }

}