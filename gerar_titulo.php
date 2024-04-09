<?php
include 'header.php'; 
require_once 'classes/titulosClass.php';
require_once 'classes/categoriasClass.php';

$titulosClass = new Titulos();
$categoriasClass = new Categorias();

if (isset($_GET['media_name'])) {

    $catId = $_GET['catid'];
    $nome = $_GET['media_name'];
    $filename = $_GET['filename'];

    // Call the criarTitulo method
    $titulosClass->criarTitulo($nome, null, null, $catId);

    $titulosList = $titulosClass->mostrarTitulos();

    foreach ($titulosList as $titulo) {
        if ($titulo['nome'] === $nome) {
            $id = $titulo['id'];
            break;
        }
    }

    echo "<div class='row'>
    <div class='col-md-6 p-4'>
        <form method='post'>
            <input type='hidden' name='tituloId' value='{$id}'>
            <div class='mb-3'>
                <label for='tituloThumb' class='form-label'>Duração do Thumb (mm:ss):</label>
                <input type='text' class='form-control' id='duracaoThumb' name='duracaoThumb' pattern='[0-5]?[0-9]:[0-5][0-9]' inputmode='numeric' title='Use o formato mm:ss' value='0:20' required>
            </div>
            <button type='submit' name='carregarThumb' class='btn btn-primary w-100'>Carregar Thumb</button>
        </form>
    </div>
    <div class='col-md-6 p-4'>
        <form method='post'>
            <input type='hidden' name='tituloId' value='{$id}'>
            <div class='mb-3'>
                <label for='duracaoPreview' class='form-label'>Duração do Preview (mm:ss):</label>
                <input type='text' class='form-control' id='duracaoPreview' name='duracaoPreview' pattern='[0-5]?[0-9]:[0-5][0-9]' inputmode='numeric' title='Use o formato mm:ss' value='0:15' required>
            </div>
            <button type='submit' name='carregarPreview' class='btn btn-primary w-100'>Carregar Preview</button>
        </form>
    </div>
</div>";

}

// Verificar se o formulário de Carregar Thumb foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carregarThumb'])) {
    $tituloId = $_POST['tituloId'];
    $duracao = $_POST['duracaoThumb'];

    $mensagem = $titulosClass->extrairThumbTitulo($tituloId, $duracao, $filename);
    $titulosClass->extrairPreviewTitulo($tituloId, $duracao, $filename);
   // echo $mensagem;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carregarPreview'])) {
    $tituloId = $_POST['tituloId'];
    $duracao = $_POST['duracaoPreview'];

    // Chamar a função para extrair o Preview
    $mensagem = $titulosClass->extrairPreviewTitulo($tituloId, $duracao, $filename);
   // echo $mensagem;
}

// Exibir a mensagem de sucesso se existir
//if (isset($mensagem)) {
  //  echo '<div class="alert alert-success">' . $mensagem . '</div>';
//}




//header('Location: gerar_midia.php?id=' . $id);
//exit;
?>