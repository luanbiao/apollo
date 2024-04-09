<?php
require_once 'classes/titulosClass.php';
require_once 'classes/midiasClass.php';

$titulosClass = new Titulos();
$midiasClass = new Midias();

$titulosList = $titulosClass->mostrarTitulos();
$classList = $midiasClass->mostrarMidias();
//print_r($classList);

if ($_POST['nome']){
        $nome = $_POST['filename'];
        $filename = $_POST['nome'];
      /* echo $nome . "<br/>";
        echo $filename;*/

     //   $filename = substr($filename, -4);
        foreach ($classList as $midia) {
            if ($midia['nome'] === $nome) {
                $id_midia = $midia['id'];
                $tituloId = $midia['titulosId'];
                break; 
            }
        }

        $sourcePath = __DIR__ . '/vids/' . $filename;
        $destinationFolder = 'titulos/midias/';
        $destinationPath = $destinationFolder . $id_midia . '.mp4';

       $filename = substr($filename, 0, -4);

       $previewPath = 'titulos/midias/previews/' . $filename . '-preview.mp4';
     //  echo $previewPath;
        $thumbnailPath = 'titulos/midias/thumbs/' . $filename . '-thumbnail.png';
        $titulosDestino = 'titulos/' . $destinationFolder . $tituloId . '.mp4';

        $titulosPreview = 'titulos/previews/' . $filename . '-preview.mp4';

        $titulosThumbs = 'titulos/thumbs/' . $filename . '-thumbnail.png';
       
        if (rename($sourcePath, $destinationPath)) {
            // If successful, rename the preview file
            if (file_exists($previewPath)) {
                rename($previewPath, 'titulos/midias/previews/' . $id_midia . '.mp4');
            }

            // If successful, rename the thumbnail file
            if (file_exists($thumbnailPath)) {
                rename($thumbnailPath, 'titulos/midias/thumbs/' . $id_midia . '.png');
            }
            
            if (file_exists($titulosPreview)) {
                rename($titulosPreview, 'titulos/previews/' . $tituloId . '.mp4');
            }

            // If successful, rename the thumbnail file
            if (file_exists($titulosThumbs)) {
                rename($titulosThumbs, 'titulos/thumbs/' . $tituloId . '.png');
            }
           header('Location: videos.php');
           exit;

        // echo 'Arquivo movido e renomeado com sucesso.';
        } else {
            echo 'Erro ao mover o arquivo da mídia.';
        }

} else {
$nome = $_GET['media_name'];
$temporada = $_GET['season'];
$episodio = $_GET['episode'];

  foreach ($titulosList as $titulo) {
   // $titulo['nome'] = substr($titulo['nome'], 0, -1);
   if ($titulo['nome'] === $nome) {
        $id = $titulo['id'];
        echo $titulo['nome'];
        break; // Stop the loop once the match is found
    }
}

foreach ($classList as $midia) {
   // $midia['nome'] = substr($midia['nome'], 0, -1);
   if ($midia['nome'] === $nome && $midia['temporada'] == $temporada && $midia['episodio'] == $episodio) {
        $id_midia = $midia['id'];
        //echo $titulo['nome'];
        break; // Stop the loop once the match is found
    }
}
  

if (isset($_GET['filename'], $_GET['media_name'])) {
    $filename = $_GET['filename'];

    // Define the source and destination paths
    $sourcePath = __DIR__ . '/vids/' . $filename;
    $destinationFolder = 'titulos/midias/';
    $destinationPath = $destinationFolder . $id_midia . '.' . pathinfo($filename, PATHINFO_EXTENSION);
    $filename = substr($filename, 0, -4);

    $previewPath = 'titulos/midias/previews/' . $filename . '-preview.mp4';
    $thumbnailPath = 'titulos/midias/thumbs/' . $filename . '-thumbnail.png';

    $titulosDestino = 'titulos/' . $destinationFolder . $id . '.' . pathinfo($filename, PATHINFO_EXTENSION);
    $titulosPreview = 'titulos/previews/' . $filename . '-preview.mp4';
    $titulosThumbs = 'titulos/thumbs/' . $filename . '-thumbnail.png';

    if (rename($sourcePath, $destinationPath)) {
        // If successful, rename the preview file
        if (file_exists($previewPath)) {
            rename($previewPath, 'titulos/midias/previews/' . $id_midia . '.mp4');
        }

        // If successful, rename the thumbnail file
        if (file_exists($thumbnailPath)) {
            rename($thumbnailPath, 'titulos/midias/thumbs/' . $id_midia . '.png');
        }
        
        if (file_exists($titulosPreview)) {
            rename($titulosPreview, 'titulos/previews/' . $id . '.mp4');
        }

        // If successful, rename the thumbnail file
        if (file_exists($titulosThumbs)) {
            rename($titulosThumbs, 'titulos/thumbs/' . $id . '.png');
        }
        header('Location: videos.php');
        exit;

       // echo 'Arquivo movido e renomeado com sucesso.';
    } else {
        echo 'Erro ao mover o arquivo da mídia.';
    }
}else {
    echo 'Parâmetros ausentes.';
  
}
}
?>
