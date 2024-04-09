<?php
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class GerenteEmails {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configureMailer();

         // Inicialize o cabeçalho e rodapé no construtor
         $this->cabecalho = '
         <html>
         <head>
             <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
             <style>
             body {
                 background: linear-gradient(to bottom, #ff5733, #333366); 
                 font-family: Arial, sans-serif;
             }
             .container {
                 background: rgba(0, 0, 0, 0.8);
                 backdrop-filter: blur(5px); 
                 border-radius: 10px;
                 margin: 30px auto; 
                 padding: 20px;
                 width: 80%;
                 text-align: center;
                 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
             }
             .container h1 {
                 color: #fff;
             }
             .container p {
                 color: #ccc; 
             }
             .button {
                 background: #007bff; 
                 border: none;
                 color: white;
                 padding: 10px 20px;
                 text-align: center;
                 text-decoration: none;
                 display: inline-block;
                 font-size: 16px;
                 border-radius: 5px;
                 cursor: pointer;
             }
             .footer {
                 font-size: 12px;
                 color: #ccc; 
                 margin-top: 20px;
                 text-align: center;
             }
             </style>
         </head>
         <body>
             <div class="container">
             <img src="https://desesquecedor.com.br/img/logodark.png" height="75">
     ';

     $this->rodape = '
             <div class="footer">
             Este e-mail foi enviado por desesquecedor.com.br
             </div>
         </body>
         </html>
     ';

    }

    private function configureMailer() {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'coliseum.apolloapp@gmail.com';
        $this->mailer->Password = 'iwfy ywli kqzj mtie';
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->setFrom('coliseum.apolloapp@gmail.com', '🎟️ Apollo');
    }

    public function enviarEmail($recipientEmail, $recipientName, $subject, $htmlContent) {
        try {
            $this->mailer->addAddress($recipientEmail, $recipientName);
            $this->mailer->Subject = $subject;
            $this->mailer->isHTML(true);
            $this->mailer->Body = $htmlContent;

            $this->mailer->send();
            return true; // E-mail enviado com sucesso
        } catch (Exception $e) {
            return false; // Erro ao enviar o e-mail
        }
    }


    public function emailBemVindo($usuario, $email){
        $htmlContent = '
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <style>
                    body {
                        background: linear-gradient(to bottom, #ff5733, #333366); 
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        background: rgba(0, 0, 0, 0.8);
                        backdrop-filter: blur(5px); 
                        border-radius: 10px;
                        margin: 30px auto; 
                        padding: 20px;
                        width: 80%;
                        text-align: center;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    }
                    .container h1 {
                        color: #fff;
                    }
                    .container p {
                        color: #ccc; 
                    }
                    .button {
                        background: #007bff;
                        border: none;
                        color: white;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;
                        border-radius: 5px;
                        cursor: pointer;
                    }
                    .footer {
                        font-size: 12px;
                        color: #ccc; 
                        margin-top: 20px;
                        text-align: center;
                    }
                    </style>
                </head>
                <body>
                <div class="container">
                <img src="https://apollo.tiote.com.br/assets/images/apolologo.png" height="75">
                <h1>Cadastro Realizado com Sucesso</h1>
                <p>Olá ' . $usuario .',</p>
                <p>Seu cadastro no nosso site foi realizado com sucesso.</p>
                <p>Aguarde a liberação de um administrador!</p><br/>
                <a href="https://apollo.tiote.com.br" class="button" style="text-decoration: none;">Acesse</a>
                </div>
                <div class="footer">
                Este e-mail foi enviado por apollo.tiote.com.br
                </div>
                </body>
                </html>
                ';

        if ($this->enviarEmail($email, $usuario, "Bem vindo ao Apollo 🧠", $htmlContent)) {
            return 'E-mail enviado com sucesso';
        } else {
            return 'Erro ao enviar o e-mail: ' . $this->mailer->ErrorInfo;
        }

    }

    public function emailAtivado($usuario, $email){
        $htmlContent = '
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <style>
                    body {
                        background: linear-gradient(to bottom, #ff5733, #333366); 
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        background: rgba(0, 0, 0, 0.8);
                        backdrop-filter: blur(5px); 
                        border-radius: 10px;
                        margin: 30px auto; 
                        padding: 20px;
                        width: 80%;
                        text-align: center;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    }
                    .container h1 {
                        color: #fff;
                    }
                    .container p {
                        color: #ccc; 
                    }
                    .button {
                        background: #007bff;
                        border: none;
                        color: white;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;
                        border-radius: 5px;
                        cursor: pointer;
                    }
                    .footer {
                        font-size: 12px;
                        color: #ccc; 
                        margin-top: 20px;
                        text-align: center;
                    }
                    </style>
                </head>
                <body>
                <div class="container">
                <img src="https://apollo.tiote.com.br/assets/images/apolologo.png" height="75">
                <h1>Cadastro Ativado</h1>
                <p>Olá ' . $usuario .',</p>
                <p>Seu cadastro no nosso site foi ativado, agora é só acessar e curtir.</p>
                <a href="https://apollo.tiote.com.br" class="button" style="text-decoration: none;">Acesse</a>
                </div>
                <div class="footer">
                Este e-mail foi enviado por apollo.tiote.com.br
                </div>
                </body>
                </html>
                ';

        if ($this->enviarEmail($email, $usuario, "Bem vindo ao Apollo 🧠", $htmlContent)) {
            return 'E-mail enviado com sucesso';
        } else {
            return 'Erro ao enviar o e-mail: ' . $this->mailer->ErrorInfo;
        }

    }

    public function emailRecuperarSenha($email, $token){
        $htmlContent = $this->cabecalho . '
            <h1>Recuperar Senha</h1>
            <p>Clique no botão abaixo para recuperar sua senha e voltar a usar o desesquecedor.</p>
            <a href="https://desesquecedor.com.br/recuperar_senha.php?token=' . $token . '" class="button" style="text-decoration: none;">Recuperar Senha</a>
            <p>Obrigado por se juntar à nossa manada!</p><br/>
            </div>' . $this->rodape;
    
        if ($this->enviarEmail($email, "elefanTI", "Recuperação de Senha no Desesquecedor 🧠", $htmlContent)) {
            return 'E-mail de recuperação de senha enviado com sucesso';
        } else {
            return 'Erro ao enviar o e-mail: ' . $this->mailer->ErrorInfo;
        }
    }

    public function emailAlterado($usuario, $email){
        $htmlContent = $this->cabecalho . '
            <h1>Sua senha foi alterada</h1>
            <p>Olá <b>' . $usuario .'</b>,</p>
            <p>Agora é só acessar e usar o desesquecedor.</p>
            <a href="https://desesquecedor.com.br" class="button" style="text-decoration: none;">Acessar Desesquecedor</a>
            <p>Obrigado por se juntar à nossa manada!</p><br/>
            </div>' . $this->rodape;
    
        if ($this->enviarEmail($email, $usuario, "Senha alterada com sucesso 🧠", $htmlContent)) {
            return 'E-mail de alteração de senha enviado com sucesso';
        } else {
            return 'Erro ao enviar o e-mail: ' . $this->mailer->ErrorInfo;
        }
    }
    

}
?>