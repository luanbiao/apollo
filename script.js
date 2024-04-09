function gerarTitulo(filename, catId, mediaName, season, duracao, episode) {
    // Obter a seleção do #categoriasId
    var selectedCategoryId = document.getElementById('categoriasId').value;

    // Construir a URL dinamicamente
    var url = 'gerar_titulo.php?' + new URLSearchParams({
        filename: filename,
        catid: selectedCategoryId,
        media_name: mediaName,
        season: season,
        duracao: duracao,
        episode: episode,
    });

    // Redirecionar para a URL construída
    window.location.href = url;
}

function gerarMidia(filename, catId, mediaName, season, duracao, episode) {
    // Obter a seleção do #categoriasId
    var selectedCategoryId = document.getElementById('categoriasId').value;

    // Construir a URL dinamicamente
    var url = 'gerar_midia.php?' + new URLSearchParams({
        filename: filename,
        catid: selectedCategoryId,
        media_name: mediaName,
        season: season,
        duracao: duracao,
        episode: episode,
    });

    // Redirecionar para a URL construída
    window.location.href = url;
}