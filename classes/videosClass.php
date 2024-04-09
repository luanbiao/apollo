<?php
require_once 'arquivosClass.php';

require_once 'midiasClass.php';

class Videos{
    public function renderizarCurso($info, $categoriesList, $titulosList){
        //print_r($info);
        $Arquivos = new Arquivos();
        echo '<div class="position-relative">';
        echo '<div class="card mb-3 bg-dark text-white">';
        echo '<div class="card-body">';
        $duracao = $Arquivos->pegarDuracao($info['filename']);
        $nomeArquivo = $Arquivos->ajustarNome($info['filename']);
        echo $Arquivos->criarFormularioCurso($info['filename'], $duracao, $titulosList);
        echo "</div></div>";
        echo '<div class="rotate-90 bg-success text-white p-1">
        Curso';
        echo "</div></div>";
    }

    public function renderizarAnime($info, $categoriesList, $titulosList) {
        $Arquivos = new Arquivos();

        echo '<div class="position-relative">
        <div class="card mb-3 bg-dark text-white">
        <div class="card-body">';
        $duracao = $Arquivos->pegarDuracao($info['filename']);

        $tituloExiste = in_array($info['media_name'], array_column($titulosList, 'nome'));
        echo "<div class='mb-4'>";
        echo $tituloExiste ? '<span class="badge bg-danger"><i class="bi bi-info-circle"></i> Título</span>' : '';
        echo "</div>";
        echo $Arquivos->criarFormularioAnime($info['filename'], $duracao);
        echo "</div></div>";
        echo '<div class="rotate-90 bg-warning text-white p-1">
        Anime';
         echo "</div></div>";
    }
}

/*  <div class="col-md-3">
<div class="position-relative">
<div class="bg-light p-3">
  <!-- Conteúdo do segundo card -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Título do Card 2</h5>
      <p class="card-text">Algum texto descritivo sobre o card 2.</p>
      <a href="#" class="btn btn-primary">Botão</a>
    </div>
  </div>
</div>
<div class="rotate-90 bg-primary text-white p-1">
  Legenda 2
</div>
</div>
</div>*/