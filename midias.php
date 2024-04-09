<?php
// Include the necessary class files and start the session if needed
require_once 'classes/titulosClass.php';
require_once 'classes/categoriasClass.php';
require_once 'classes/midiasClass.php';

include 'header.php';
// Verifica se o parâmetro tituloId está setado
if (!isset($_GET['tituloId'])) {
    echo '<div class="header">';
    echo "Nenhuma mídia foi informada";
    echo '</div>';
    // Você pode adicionar mais código aqui, como redirecionar para outra página ou encerrar a execução.
    exit();
}

$tituloId = $_GET['tituloId'];
// Create an instance of the Titulos class
$titulosClass = new Titulos();
$categoriasClass = new Categorias();
$midiasClass = new Midias();
// Get the list of categories from the database
$midiasList = $midiasClass->mostrarMidiasTitulos($tituloId);

// Verifica se há mídias disponíveis para visualização
if (empty($midiasList)) {
    echo "Nenhuma mídia foi encontrada para visualização";
    // Você pode adicionar mais código aqui, como redirecionar para outra página ou encerrar a execução.
    exit();
}

$ultimaMidia = end($midiasList);
?>

<body style="background-color: unset;">
<div class="video-background">
    <video id="video" playsinline autoplay muted loop>
        <source src="./titulos/midias/previews/<?php echo $ultimaMidia['preview']?>" type="video/mp4">
        Seu navegador não suporta a tag de vídeo.
    </video>
</div>

<div class="header">
    <h1 style="margin-bottom: 10px;"><?php echo $ultimaMidia['nome']; ?></h1>
    <span style="font-size: 16px; display: block;"><?php echo "Temporada " . $ultimaMidia['temporada']; ?></span>
    <span style="font-size: 18px; display: block;"><?php echo "Episódio " . $ultimaMidia['episodio']; ?></span>
    <p><?php echo $ultimaMidia['descricao']; ?></p>
    <a href="./assistir.php?midiaId=<?php echo $ultimaMidia['id']; ?>" class="btn btn-assistir">Assistir</a>
</div>

<div class="container-fluid mt-4 corpo p-4 ">
    <?php
    // Group videos by temporada
    $videosByTemporada = [];
    foreach ($midiasList as $video) {
        $temporada = $video['temporada'];
        $videosByTemporada[$temporada][] = $video;
    }
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

<?php foreach ($videosByTemporada as $temporada => $videos) : ?>
    <h2 class="mb-4"><?php echo $videos[0]['nome'] ?></h2>
    <div class="mb-4">
        <h3><?php echo "Temporada " . $temporada; ?></h3>
        <!-- Display videos in a horizontal scroll carousel -->
        <div id="carousel_<?php echo $temporada; ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $itemCount = count($videos);
                $itemsPerSlide = 4; // Set the number of videos to display per slide

                for ($i = 0; $i < $itemCount; $i += $itemsPerSlide) {
                    $slideVideos = array_slice($videos, $i, $itemsPerSlide);
                ?>
                    <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                        <div class="d-flex">
                            <?php foreach ($slideVideos as $video) : ?>
                                <div class="carousel-item-content me-3 position-relative">
                                    <a href="assistir.php?midiaId=<?php echo $video['id']; ?>">
                                        <img src="<?php echo 'titulos/midias/thumbs/' . $video['thumb']; ?>" class="d-block" height=250 alt="<?php echo $video['nome']; ?>">
                                    </a>
                                    <div class="overlay-text">
                                        <h2 class="mb-2"><?php echo "Episódio " . $video['episodio']; ?></h2>
                                        <p><?php echo $video['nome']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $temporada; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $temporada; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
<?php endforeach; ?>


</div>

<?php include 'footer.php'; ?>
