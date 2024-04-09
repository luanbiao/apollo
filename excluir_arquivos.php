<?php
// Define as pastas a serem limpas
$foldersToDeleteMKV = ['./titulos/midias', './titulos/midias/previews', './titulos/previews'];
$foldersToDeletePNG = ['./titulos/midias/thumbs', './titulos/thumbs'];

// Função para excluir arquivos com uma determinada extensão em uma pasta
function deleteFilesByExtension($folder, $extension)
{
    $files = glob("$folder/*.$extension");
    foreach ($files as $file) {
        unlink($file);
    }
}

// Exclui todos os arquivos .mkv nas pastas especificadas
foreach ($foldersToDeleteMKV as $folder) {
    deleteFilesByExtension($folder, 'mkv');
}

// Exclui todos os arquivos .mkv nas pastas especificadas
foreach ($foldersToDeleteMKV as $folder) {
    deleteFilesByExtension($folder, 'mp4');
}

// Exclui todos os arquivos .png nas pastas especificadas
foreach ($foldersToDeletePNG as $folder) {
    deleteFilesByExtension($folder, 'png');
}

echo "Operação concluída. Todos os arquivos .mkv e .png foram excluídos nas pastas especificadas.";
?>
