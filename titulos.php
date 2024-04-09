<?php
// Include the necessary class files and start the session if needed
require_once 'classes/titulosClass.php';
require_once 'classes/categoriasClass.php';

// Create an instance of the Titulos class
$titulosClass = new Titulos();
$categoriasClass = new Categorias();

// Get the list of categories from the database
$categoriesList = $categoriasClass->mostrarCategorias();
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Títulos por Categoria</h2>

    <?php foreach ($categoriesList as $category) : ?>
        <div class="mb-4">
            <h3><?php echo $category['nome']; ?></h3>

            <!-- Display titles in a carousel for each category -->
            <div id="carousel_<?php echo $category['id']; ?>" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php
                $titlesList = $titulosClass->mostrarTitulosCategorias($category['id']);
                $itemCount = count($titlesList);
                $itemsPerSlide = 3; // Set the number of items to display per slide

                for ($i = 0; $i < $itemCount; $i += $itemsPerSlide) {
                    $slideItems = array_slice($titlesList, $i, $itemsPerSlide);
                    ?>
                    <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                        <div class="d-flex">
                        <?php foreach ($slideItems as $title) : ?>
                            <div class="carousel-item-content me-3">
                                <a href="./midias.php?tituloId=<?php echo $title['id']; ?>">
                                    <img src="<?php echo 'titulos/thumbs/' . $title['thumb']; ?>" class="d-block" height="250" alt="<?php echo $title['nome']; ?>">
                                </a>
                            </div>
                        <?php endforeach; ?>

                        </div>
                    </div>
                <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $category['id']; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $category['id']; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Button to navigate to cadastrar_titulos.php -->
    <a href="cadastrar_titulos.php" class="btn btn-primary">Cadastrar Título</a>
</div>

<?php include 'footer.php'; ?>
