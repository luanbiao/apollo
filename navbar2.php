<?php 
require_once './classes/usuariosClass.php';
$Usuarios = new Usuarios;
$admin = $Usuarios->consultarAdmin($_SESSION['login']);

 ?>
<link rel="stylesheet" href="./assets/css/background.css"><style>


    #menu-btn {
      cursor: pointer;
      margin-right: 20px;
      font-size: 2.5em;
    }

    #menu {
      position: fixed;
      top: 0;
      right: -300px; 
      height: 100%;
      width: 250px;
      z-index: 99;
      padding-left: 20px;

      background-color: rgba(0,0,0,0.8); /*#121112;*/
      transition: right 0.3s ease-in-out;
    }

    #menu a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #fff;
      font-size: 18px;

    }

    #menu a:hover{
      /*  color: red;*/
        background-color: #990000;
    }

    .cabecalho {
      top: 0;
      z-index: 3;
      padding: 10px;
    background-color: rgba(0,0,0,1); /*#121112;*/
      text-align: center;
      display: flex;
      justify-content: space-between;
      align-items: center;
  /*   position: sticky;*/
   position: fixed;
    width: -webkit-fill-available;


    }

    #close-btn{
        cursor: pointer;
    }
</style>

<div id="menu">
  <span id="close-btn" class="material-icons mt-4">close</span>

    <hr>
    <a href="./index.php">Home</a>
    <a href="./categorias.php?catId=9">Animes</a>
    <a href="./categorias.php?catId=10.php">Cursos</a>
    <a href="./livros.php">Livros</a>
    <!--<a href="./quadrinhos.php">Quadrinhos</a>-->
    <hr>
    <a href="./cadastrar_usuarios.php">Gerenciar Usuários</a>
    <a href="./cadastrar_categorias.php">Gerenciar Categorias</a>
    <a href="./cadastrar_titulos.php">Gerenciar Títulos</a>
    <a href="./cadastrar_midias.php">Gerenciar Mídias</a>
    <hr>
    <a href="./videos.php">Enviar Vídeos</a>
    <a href="./leituras.php">Enviar Livros</a>
    <a href="./login.php" id="sair">Sair</a>
  </div>

  <div class="cabecalho" id="cabecalho">
    <img src="./assets/images/apolologo.png" height="45">
    <span id="menu-btn" class="material-icons">menu</span>
</div>

<div class="background">
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
   <span></span>
</div>


  <script>
    document.addEventListener("DOMContentLoaded", function () {

      const menuButton = document.getElementById("menu-btn");
      const menu = document.getElementById("menu");
      const closeBtn = document.getElementById("close-btn");

      // Event listener for menu button
      menuButton.addEventListener('click', toggleMenu);
      closeBtn.addEventListener('click', toggleMenu);
      function toggleMenu() {
        menu.style.right = menu.style.right === '0px' ? '-300px' : '0px';
      }
    });
  </script>