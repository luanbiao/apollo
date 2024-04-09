<?php 
$hideNav = true; 
session_start();
session_destroy();
include 'header.php'; 

if (isset($_POST['tipo'])){
    require_once 'classes/usuariosClass.php';
    require_once 'classes/emailClass.php';
    $emailClass = new GerenteEmails();
    $Usuarios = new Usuarios();

    if ($_POST['tipo'] == "login"){
        $token = $Usuarios->loginUsuario($_POST['login'], $_POST['senha']);
        if (strlen($token) == 64) {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['tk'] = $token;
            header('Location: index.php');
            exit;
        }
    } else if ($_POST['tipo'] == "cadastro"){
        $login_cadastro = $_POST['login_cadastro'];
        $email_cadastro = $_POST['email_cadastro'];
        $senha_cadastro = $_POST['senha_cadastro'];
        $cadastro_resultado = $Usuarios->criarUsuario($_POST['login_cadastro'], $_POST['email_cadastro'], $_POST['senha_cadastro']);
        $emailClass->emailBemVindo($_POST['login_cadastro'],$_POST['email_cadastro']);
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo</title>

    <style>
        /* Adicione este estilo para ocultar a div de cadastro inicialmente */
        .login-dark-cadastro {
            display: none;
        }
    </style>
</head>
<body class="body-video">

<div class="video-login">
    <video id="video-login" playsinline autoplay muted loop>
        <source src="./assets/images/bglogin.mp4" type="video/mp4">
        Seu navegador não suporta esse tipo de vídeo.
    </video>
</div>

<style>
    /* Adicione este estilo para posicionar os ícones ao lado dos campos */
    .form-group {
        display: flex;
        align-items: center;
    }

    .form-group i {
        margin-right: 10px; /* Ajuste o espaçamento conforme necessário */
    }
</style>

<!-- Formulário de Login -->
<div class="login-dark-video text-center" id="loginForm">
    <form method="post">
    <input type="hidden" name="tipo" value="login">
        <img src="./assets/images/apolologo.png" height="75">
        <h4 class="mt-3">Login</h4>
        <div class="form-group mt-3 mb-3">
            <i class="material-icons">account_circle</i>
            <input class="form-control bg-login" type="text" name="login" placeholder="login">
        </div>
        <div class="form-group mb-3">
            <i class="material-icons">lock</i>
            <input class="form-control bg-login" type="password" name="senha" placeholder="senha">
        </div>
        <div class="form-group mb-3"><button class="btn btn-danger btn-block w-100" type="submit">Acessar</button></div>
    </form>
    <div class="form-group mb-3"><button class="btn btn-primary btn-block w-100" onClick="mostrarCadastrar()">Faça seu cadastro</button></div>
    <?php 
    if (isset($cadastro_resultado)){
        echo "<p class='bg-warning text-dark p-2 rounded'>" . $cadastro_resultado . "</p>";
        if ($cadastro_resultado == "Cadastrado com sucesso"){
            echo "Você receberá um e-mail quando aprovado, aguarde.";
        }
    }
    ?>
     <?php 
    if (isset($token)){
        echo "<p class='bg-warning text-dark p-2 rounded'>" . $token . "</p>";
       
    }
    ?>
</div>

<!-- Formulário de Cadastro -->
<div class="login-dark-cadastro text-center" id="cadastroForm">
    <form method="post">
        <input type="hidden" name="tipo" value="cadastro">
        <img src="./assets/images/apolologo.png" height="75">
        <h4 class="mt-3">Cadastro</h4>
        <div class="form-group mt-3 mb-3">
            <i class="material-icons">account_circle</i>
            <input class="form-control bg-login" type="text" name="login_cadastro" placeholder="Digite um login">
        </div>
        <div class="form-group mt-3 mb-3">
            <i class="material-icons">email</i>
            <input class="form-control bg-login" type="email" name="email_cadastro" placeholder="Digite seu e-mail">
        </div>
        <div class="form-group mb-3">
            <i class="material-icons">lock</i>
            <input class="form-control bg-login" type="password" name="senha_cadastro" placeholder="Digite uma senha">
        </div>
        <div class="form-group mb-3">
            <i class="material-icons">lock</i>
            <input class="form-control bg-login" type="password" name="senha_confirma_cadastro" placeholder="Confirme a senha">
        </div>
        <div class="form-group mb-3"><button class="btn btn-danger btn-block w-100" type="submit">Cadastrar</button></div>
       
    </form>
    <div class="form-group mb-3"><button class="btn btn-primary btn-block w-100" onClick="mostrarLogin()">Voltar para Login</button></div>
</div>



<button class="mute-button" onclick="toggleMute()">
    <i class="material-icons" id="soundIcon">volume_up</i>
</button>

<script>
    var video = document.getElementById('video-login');
    var soundIcon = document.getElementById('soundIcon');

    function toggleMute() {
        if (video.muted) {
            video.muted = false;
            soundIcon.innerHTML = 'volume_off';
        } else {
            video.muted = true;
            soundIcon.innerHTML = 'volume_up';
        }
    }

    function mostrarCadastrar() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('cadastroForm').style.display = 'block';
    }

    function mostrarLogin() {
        document.getElementById('cadastroForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block';
    }
</script>

</body>
</html>

<?php include 'footer.php'; ?>
