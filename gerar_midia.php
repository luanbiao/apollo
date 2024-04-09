<?php
require_once 'classes/midiasClass.php';
require_once 'classes/titulosClass.php';

// Create an instance of the Midias class
$midiasClass = new Midias();
$titulosClass = new Titulos();


$nome = $_GET['media_name'];
$temporada = $_GET['season'];
$episodio = $_GET['episode'];
$duracao = $_GET['duracao'];

$titulosList = $titulosClass->mostrarTitulos();

foreach ($titulosList as $titulo) {
 // $titulo['nome'] = substr($titulo['nome'], 0, -1);
 if ($titulo['nome'] === $nome) {
      $id = $titulo['id'];
    //  echo $titulo['nome'];
      break; // Stop the loop once the match is found
  }
}


// Agora você pode usar $lastInsertId como parte do nome do arquivo
//$filename = $lastInsertId . ".mkv";
// Call the criarMidia method
$midiasClass->criarMidia($nome, null, null, null, null, null, $duracao, $temporada, $episodio, $id);

header('Location: videos.php');
exit;
?>
