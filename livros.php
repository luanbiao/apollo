
<style>
    
.card {
    cursor: pointer; 
}

.titulo{
    font-size: 0.9em;
}

.autor{
    font-size: 0.7em;
}

.card-body{
    min-height: 130px;
    
}   

/* Media query para telas menores, como dispositivos móveis */
@media (max-width: 600px) {
    .titulo {
        font-size: 0.8em; /* Ajuste o tamanho da fonte para telas menores conforme necessário */
    }

    .autor{
        font-size: 0.7em;
        display: none;
    }
    
    .card-body{
        min-height: 100px;
    }
}



.mt-7{
    margin-top: 5rem !important;
}





</style>

<?php 
include 'header.php';
require_once 'classes/livrosClass.php';
require_once 'classes/usuariosClass.php';

$Livros = new Livros();
$Usuarios = new Usuarios();
$listaLivros = $Livros->consultarLivros();

// Verifica se há mídias disponíveis para visualização
if (empty($listaLivros)) {
    echo "Nenhum livro foi encontrado";
    exit();
}

$ultimoLivro = end($listaLivros);

$usuario_id = $Usuarios->consultarUsuario($_SESSION['login']);
$usuario_id = $usuario_id['id'];

?>




<?php
echo '<div class="container-fluid mt-7">';
echo "<div class='row row-cols-2 row-cols-md-2 row-cols-lg-6'>";
foreach ($listaLivros['livro'] as $livro) {
    echo '<div class="mb-4 card-custom">';
    echo "<div class='card text-white text-center fundo'  onClick='lerLivro({$livro['id']})'>";
    echo "<img class='card-img-top' style='max-height: 350px;' src='./titulos/livros/thumbs/{$livro['id']}.png' alt='{$livro['titulo']}'>";
    echo "<div class='card-body d-flex flex-column  justify-content-center '>";
    echo "<h5 class='card-title titulo'>{$livro['titulo']}</h5>";
    echo "<p class='card-text autor'>{$livro['autor']}</p>";

    $pagina = $Livros->consultarPagina($livro['id'], $usuario_id);

    if (($pagina['pagina'] + 5) > $livro['paginas']) {
        echo '<span class="badge bg-success">Concluído</span>';
    } else if ($pagina['pagina'] != 1) {
        $percentagem = ($pagina['pagina'] / $livro['paginas']) * 100;
        echo '<div class="progress">';
        echo '<div class="progress-bar" role="progressbar" style="width: ' . $percentagem . '%; background-color: #007bff;" aria-valuenow="' . $percentagem . '" aria-valuemin="0" aria-valuemax="100">';
        echo number_format($percentagem, 2) . '%';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<span class="badge bg-secondary">Não iniciado</span>';
    }

    echo "</div>"; // fechar card-body
    echo "</div>"; // fechar card
    echo "</div>"; // fechar col
}
echo "</div></div>";
?>







<script>
    function lerLivro(id) {
        // Create a dynamic form
        var form = document.createElement('form');
        form.method = 'post';
        form.action = 'ler.php';

        // Create a hidden input for livro_id
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'livro_id';
        input.value = id;

        // Append the input to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>

</html>