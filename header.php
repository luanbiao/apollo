<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apollo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
    <!-- Seus Estilos CSS Personalizados -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
      if(!isset($hideNav)) {
        include_once("navbar2.php");

        if (!isset($_SESSION['login']) || !isset($_SESSION['tk'])) {
          header ('Location: ./login.php'); 
        }
      }
   ?>


