<?php
if (isset($_GET['filename'])) {
    $inputFile = __DIR__ . '/vids/' . $_GET['filename'];
    $uploadsFolder = 'titulos/midias/thumbs/';

    if (!file_exists($uploadsFolder)) {
        mkdir($uploadsFolder, 0777, true);
    }
        $thumbnailFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-thumbnail.png';
        $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss 00:00:05 -vframes 1 -q:v 2 \"$thumbnailFile\"";
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            echo 'Error: ' . implode("\n", $output);
        } else {
            header('Location: videos.php');
            exit;
           // echo 'Thumbnail gerado com sucesso: ' . $thumbnailFile;
        }
 
} else {
    echo 'Parâmetros ausentes.';
}
?>