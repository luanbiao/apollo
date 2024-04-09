<?php
require_once 'classes/titulosClass.php';
require_once 'classes/midiasClass.php';
require_once 'classes/categoriasClass.php';

// Create an instance of the Titulos class
$titulosClass = new Titulos();
$categoriasClass = new Categorias();
$midiasClass = new Midias();


$catId = $_GET['catid'];
$nome = $_GET['media_name'];
$temporada = $_GET['season'];
$episodio = $_GET['episode'];
$duracao = $_GET['duracao'];




// Call the criarTitulo method
$titulosClass->criarTitulo($nome, null, null, $catId);

$titulosList = $titulosClass->mostrarTitulos();

foreach ($titulosList as $titulo) {
 // $titulo['nome'] = substr($titulo['nome'], 0, -1);
 if ($titulo['nome'] === $nome) {
      $id = $titulo['id'];
    //  echo $titulo['nome'];
      break; // Stop the loop once the match is found
  }
}

$midiasClass->criarMidia($nome, null, $id . ".mkv", null, $duracao, $temporada, $episodio, $id);

header('Location: videos.php');
exit;

?>
