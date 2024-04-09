<?php 
require_once 'classes/livrosClass.php';
require_once 'classes/usuariosClass.php';

$Usuarios = new Usuarios();

include 'header.php'; 
$usuario_id = $Usuarios->consultarUsuario($_SESSION['login']);
$usuario_id = $usuario_id['id'];
$_SESSION['livro_id'] = $_POST['livro_id'];
$livro_id = $_POST['livro_id'];

$Livros = new Livros();
$pagina_usuario = $Livros->consultarPagina($livro_id, $usuario_id);
$paginas_total = $Livros->paginasLivro($livro_id);
$paginas_total = $paginas_total['paginas'];
$nome_livro = $Livros->nomeLivro($livro_id);
$paginacao = $pagina_usuario['pagina'] . "/" . $paginas_total;

if ($pagina_usuario['success']) {
    $numeracao_pagina = $pagina_usuario['pagina'];
} else {
    $numeracao_pagina = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.min.js"></script>
    
    <script type="text/javascript" src="./script.js"></script>
    <link rel="stylesheet" href="./assets/css/ler.css">
</head>

<body>

    <div class="container-fluid mt-4">
        <div id="overlay" class="row">
            <div id="left" onclick="prevPage()"></div>
            <div id="center" onclick="toggleMenu()"></div>
            <div id="right" onclick="nextPage()"></div>
        </div>
    </div>

    <div id="canvases"></div>
    <input type="hidden" id="livro_id" value="<?php echo isset($_POST['livro_id']) ? $_POST['livro_id'] : ''; ?>">

    <div id="rodape">
        <?php echo "<span>" . $nome_livro['titulo'] . "</span><span>" . $paginacao . "</span>"; ?>
    </div>

    <script>




    async function salvarPagina(pagina) {
        const livro_id = <?php echo $livro_id ?>;
        const usuario_id = <?php echo $usuario_id ?>;

        try {
            const response = await fetch('mudar_pagina.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pagina: pagina,
                    livro_id: livro_id,
                    usuario_id: usuario_id,
                }),
            });

            const data = await response.json();

            if (data.mensagem.success) {
                //   console.log('Página salva com sucesso!');
            } else {
                //   console.error('Erro ao salvar a página:', data.message);
            }
        } catch (error) {
            console.error('Erro ao processar a solicitação:', error);
        }
    }

    const menu = document.getElementById('cabecalho');
    const rodape = document.getElementById('rodape');

    function toggleMenu() {
        menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
        rodape.style.display = rodape.style.display === 'none' ? 'flex' : 'none';
    }

    var livro_id = <?php echo isset($_POST['livro_id']) ? json_encode($_POST['livro_id']) : '1'; ?>;
 
    keyLivroExiste = null;
    if (keyLivroExiste == null) {
        fetch(`./titulos/livros/${livro_id}.pdf`)
            .then(response => response.blob())
            .then(blob => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {
                  //  localStorage.clear();
                    var keyLivro = `cLivro_${livro_id}`;
                  //  cacheLivro(keyLivro, reader.result);
                   // localStorage.setItem(`cLivro_${livro_id}`, reader.result);
                    renderPDF(reader.result);
                };
            })
            .catch(error => console.error('Erro ao carregar o PDF:', error));
    } else {
        renderPDF(pdfData);
    }

    function renderPDF(pdfData) {
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.worker.js';

        pdfjsLib.getDocument(pdfData).promise.then(function(pdfDoc_) {
            var pdfDoc = pdfDoc_;
            var pageNum = <?php echo $numeracao_pagina ?>;
            var pageRendering = false;
            var pageNumPending = null;
            var scale = 1.5;

            var canvas = document.createElement('canvas');
            canvas.id = 'currentCanvas';
            canvas.style.position = 'relative';
            canvas.style.zIndex = 1;
            document.getElementById('canvases').appendChild(canvas);
            var ctx = canvas.getContext('2d');

            function renderPage(num) {
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    var viewport = page.getViewport({
                        scale: scale
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };

                    var renderTask = page.render(renderContext);

                    renderTask.promise.then(function() {
                        pageRendering = false;
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                });
            }

            renderPage(pageNum);

            function nextPage() {
                if (pageNum < pdfDoc.numPages) {
                    pageNum++;
                    renderPage(pageNum);
                    salvarPagina(pageNum);
                    scrollToTop();
                }
            }

            function prevPage() {
                if (pageNum > 1) {
                    pageNum--;
                    renderPage(pageNum);
                    salvarPagina(pageNum);
                    scrollToBottom();
                }
            }

            function scrollToTop() {
                document.documentElement.scrollTop = 0;
            }

            function scrollToBottom() {
                document.documentElement.scrollTop = document.documentElement.scrollHeight;
            }


            window.nextPage = nextPage;
            window.prevPage = prevPage;
            window.scrollToTop = scrollToTop;
            window.scrollToBottom = scrollToBottom;
        });
    }
    </script>
</body>

</html>