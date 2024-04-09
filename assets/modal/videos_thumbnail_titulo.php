 <!-- Modal para adição de novo thumbnails -->
 <div class="modal fade novoThumbModal" tabindex="-1" aria-labelledby="novoThumbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="novoThumbModalLabel">Adicionar Thumbnails ao Título</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark text-white">
                    <form action="videos.php" method="post" id="novoThumbForm">
                        <input type="hidden" class="modalFilename" name="modalFilename" value="">

                        <div class="mb-3">
                            <label for="novoTitulo" class="form-label">Thumb:</label>
                            <input type='text' class='form-control' id='duracaoThumb' name='duracaoThumb'
                                pattern='[0-5]?[0-9]:[0-5][0-9]' inputmode='numeric' title='Use o formato mm:ss'
                                value='0:20' required>
                        </div>
                        <div class="mb-3">
                            <label for="novaCategoria" class="form-label">Preview:</label>
                            <input type='text' class='form-control' id='duracaoPreview' name='duracaoPreview'
                                pattern='[0-5]?[0-9]:[0-5][0-9]' inputmode='numeric' title='Use o formato mm:ss'
                                value='0:15' required>
                        </div>
                        <div class="modal-footer bg-dark">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>