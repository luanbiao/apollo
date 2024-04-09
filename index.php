<?php include 'header.php'; ?>

<?php 
include './classes/midiasClass.php'; 
require_once './classes/titulosClass.php';
require_once './classes/categoriasClass.php';

$midias = new Midias();
$listaMidias = $midias->mostrarMidias();
$ultimaMidia = end($listaMidias);

$titulos = new Titulos();
$categorias = new Categorias();

$listaCategorias = $categorias->mostrarCategorias();
//print_r($listaCategorias);
?>

<style>
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 800px; /* Ajuste conforme necessário */
            margin: auto;
        }

        .carousel-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .overlay-text {
            position: absolute;
            top: 50%; /* Ajuste conforme necessário */
            left: 10px; /* Ajuste conforme necessário */
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .overlay-text h2 {
            margin: 0;
            font-size: 18px; /* Ajuste conforme necessário */
        }

        .overlay-text p {
            margin: 0;
            font-size: 14px; /* Ajuste conforme necessário */
        }
    </style>
<div class="wrapper">
<body style="background-color: unset;">
<div class="video-background">
    <video id="video" playsinline autoplay muted loop>
        <source src="./titulos/midias/previews/<?php echo $ultimaMidia['preview']?>" type="video/mp4">
        Seu navegador não suporta a tag de vídeo.
    </video>
</div>

<div class="header">
    <h1 style="margin-bottom: 10px;"><?php echo $titulos->consultarTitulo($ultimaMidia['titulosId'])['nome']; ?></h1>
    <span style="font-size: 16px; display: block;"><?php echo "Temporada " . $ultimaMidia['temporada']; ?></span>
    <span style="font-size: 18px; display: block;"><?php echo "Episódio " . $ultimaMidia['episodio']; ?></span>
    <p><?php echo $ultimaMidia['descricao']; ?></p>
    <a href="./assistir.php?midiaId=<?php echo $ultimaMidia['id']; ?>" class="btn btn-assistir">Assistir</a>
</div>

<div class="corpo mt-4 p-4">
    <div class="container">
    <?php foreach ($listaCategorias as $categoria) : ?>
    <div class="mb-5">
        <h3><?php echo $categoria['nome']; ?></h3>

        <!-- Display titles in a carousel for each category -->
        <div id="carousel_<?php echo $categoria['id']; ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $listaTitulos = $titulos->mostrarTitulosCategorias($categoria['id']);
                $itemCount = count($listaTitulos);
                $itemsPerSlide = 3; // Set the number of items to display per slide

                for ($i = 0; $i < $itemCount; $i += $itemsPerSlide) {
                    $slideItems = array_slice($listaTitulos, $i, $itemsPerSlide);
                    ?>
                    <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                        <div class="d-flex">
                            <?php foreach ($slideItems as $title) : ?>
                                <div class="carousel-item-content me-3 position-relative">
                                    <a href="./midias.php?tituloId=<?php echo $title['id']; ?>">
                                        <img src="<?php echo 'titulos/thumbs/' . $title['thumb']; ?>" class="d-block mx-auto" height="250" alt="<?php echo $title['nome']; ?>">
                                    </a>
                                    <div class="overlay-text">
                                        <h2 class="mb-2"><?php echo $title['nome']; ?></h2>
                                        <?php
                                        $originalDate = $title['dataCriacao'];
                                        $dateTime = new DateTime($originalDate);
                           
                                        setlocale(LC_TIME, 'pt-BR.utf-8');


                                        $dataFormatada = strftime('%d/%m (%A)', $dateTime->getTimestamp());
                                        ?>
                                        <p><?php echo $dataFormatada; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $categoria['id']; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $categoria['id']; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
<?php endforeach; ?>

</div>

<?php include 'footer.php'; ?>