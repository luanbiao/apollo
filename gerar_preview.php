<?php
if (isset($_GET['filename'])) {
    $inputFile = __DIR__ . '/vids/' . $_GET['filename'];

    // Specify the path for the "uploads" folder
    $uploadsFolder = './titulos/midias/previews/';

    // Create the uploads folder if it doesn't exist
    if (!file_exists($uploadsFolder)) {
        mkdir($uploadsFolder, 0777, true);
    }

    // Generate the output file path inside the "uploads" folder
    $outputFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-preview.mp4';

    // Execute the FFmpeg command to generate a 30-second preview and redirect output to a log file
    $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss 0 -t 15 -c:v libx265 -c:a aac -strict experimental -movflags faststart \"$outputFile\" > output.log 2>&1";
    exec($command, $output, $returnCode);

    if ($returnCode !== 0) {
        echo 'Error: ' . implode("\n", $output);
    } else {
        header('Location: videos.php');
        exit;
        //echo 'Preview gerado com sucesso: ' . $outputFile;
    }
} else {
    echo 'Parâmetros ausentes.';
}
?>
