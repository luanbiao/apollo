function toggleMenu() {
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
    rodape.style.display = rodape.style.display === 'none' ? 'flex' : 'none';
}

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