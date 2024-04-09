<nav class="navbar navbar-expand-lg topo">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="./assets/images/apolologo.png" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php?catId=9">Animes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php?catId=10">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="livros.php">Livros</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" href="filmes.php">Filmes</a>
                </li>-->
                <!--<li class="nav-item">
                    <a class="nav-link" href="livros.php">Livros</a>
                </li>-->
                <li class="nav-item dropdown "> <!-- Adiciona a classe 'dropdown' ao item 'Admin' -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./cadastrar_usuarios.php">Usuários</a>
                        <a class="dropdown-item" href="./cadastrar_categorias.php">Categorias</a>
                        <a class="dropdown-item" href="./cadastrar_titulos.php">Títulos</a>
                        <a class="dropdown-item" href="./cadastrar_midias.php">Mídias</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./videos.php">Gerenciar Vídeos</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
