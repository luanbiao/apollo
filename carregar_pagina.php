<?php
// Importe sua classe
require_once './classes/livrosClass.php';

// Verifique se a solicitação é uma solicitação POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados JSON da solicitação
    $dadosJson = json_decode(file_get_contents('php://input'), true);


    $livro_id = $dadosJson['livro_id'];
    $usuario_id = $dadosJson['usuario_id'];
    echo $livro_id;/*
    $Livros = new Livros();
    $resultado = $Livros->consultarPagina($livro_id, $usuario_id);

    // Responda com JSON
    echo json_encode(['mensagem' => $resultado]);*/
} else {
    // Se não for uma solicitação POST, retorne um erro
    http_response_code(405); // Método não permitido
    echo json_encode(['erro' => 'Método não permitido']);
}
?>
