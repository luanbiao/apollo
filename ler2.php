
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visualizador de PDF</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./assets/css/ler.css">
</head>
<body>

<?php if (isset($_POST['livro_id'])){

echo '
<div id="menu"><img src="./assets/images/apolologo.png" height="30"><a href="./livros.php"><span id="menu-btn" class="material-icons text-white me-2">arrow_back</span></a></div>

  <div id="canvas-container">
    <canvas id="myCanvas"></canvas>
  </div>

  <div class="container-fluid">
    <div id="overlay" class="row">
      <div id="left" onclick="goToPreviousPage()"></div>
      <div id="center" onclick="toggleMenu()"></div>
      <div id="right" onclick="goToNextPage()"></div>
    </div>
  </div>';
  
} else {
  echo "Nenhum livro foi informado";
}
?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
    // Global variables
    let pdfDoc = null;
    let pageNum = 1;
    const canvas = document.getElementById('myCanvas');
    const context = canvas.getContext('2d');
    const menu = document.getElementById('menu');


    // Function to load PDF
    async function loadPdf() {
      const pdfUrl = './titulos/livros/<?php echo $_POST['livro_id'] ?>.pdf'; // Replace with the URL of your PDF file
      const loadingTask = pdfjsLib.getDocument(pdfUrl);
      pdfDoc = await loadingTask.promise;
      renderPage(pageNum);
    }

    // Function to render PDF page on canvas
    function renderPage(num) {
      const isMobile = window.innerWidth <= 768;
      const isHorizontal = Math.abs(window.orientation) === 90;
      let scale = isMobile ? 0.73 : 1.1;
      scale = isHorizontal ? 2 : scale;
   
      pdfDoc.getPage(num).then((page) => {
        
        const viewport = page.getViewport({ scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        page.render({
          canvasContext: context,
          viewport: viewport,
        });
      });
    }

    // Function to go to the previous page
    function goToPreviousPage() {
      if (pageNum <= 1) return;
      pageNum--;
      renderPage(pageNum);
    }

    // Function to go to the next page
    function goToNextPage() {
      if (pageNum >= pdfDoc.numPages) return;
      pageNum++;
      renderPage(pageNum);
    }

   // Function to toggle the menu
   function toggleMenu() {
      menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
    }

    // Initialize PDF loading on document load
    document.addEventListener('DOMContentLoaded', () => {
      loadPdf();
    });
  </script>

</body>
</html>
