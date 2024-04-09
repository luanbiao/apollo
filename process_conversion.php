<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['file'])) {
    $uploadedFile = urldecode($_REQUEST['file']);
    $outputFile = 'output.mkv';  // Keep the output format as MKV

    // Use FFmpeg to cut a 30-second scene starting from the beginning and re-encode
    $ffmpegCommand = "C:\\xampp\\htdocs\\apolo\\ffmpeg\\bin\\ffmpeg -i \"$uploadedFile\" -ss 0 -t 30 -c:v libx265 -c:a aac -strict experimental -movflags faststart $outputFile 2>&1";
    echo "FFmpeg command: $ffmpegCommand";

    exec($ffmpegCommand, $output, $returnCode);

    if ($returnCode !== 0) {
        echo "FFmpeg command failed with code $returnCode<br>";
        echo "Error output: " . implode("<br>", $output);
        exit;
    } else {
        echo "FFmpeg command executed successfully!";
    }

    // Optionally, you can do something with the output file, for example, send it to the user for download
    header('Content-Type: video/x-matroska'); // Set the content type for MKV files
    header('Content-Disposition: attachment; filename=' . basename($outputFile));
    readfile($outputFile);

    // Clean up: delete temporary files if needed
    unlink($uploadedFile);

    // Optionally, if you want to keep the output file after sending it to the user, comment the following line
    unlink($outputFile);
} else {
    echo "Invalid request.";
}
?>
