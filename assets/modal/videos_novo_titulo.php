    <!-- Modal para adição de novo item -->
    <div class="modal fade" id="novoItemModal" tabindex="-1" aria-labelledby="novoItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="novoItemModalLabel">Adicionar Novo Título</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark text-white">
                    <!-- Adicione um formulário para adicionar um novo item -->
                    <form action="videos.php" method="post" id="novoItemForm">
                    <input type="hidden" name="cadastrar_titulo" value="cadastrar_titulo" class="form-control" required>
                        <div class="mb-3">
                            <label for="novoTitulo" class="form-label">Título:</label>
                            <input type="text" class="form-control" id="novoTitulo" name="novoTitulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="novaCategoria" class="form-label">Categoria:</label>
                            <select class="form-control" id="novaCategoria" name="novaCategoria" required>
                                <?php foreach ($categoriesList as $category) {
                                         echo '<option value="' . $category['id'] . '">' . $category['nome'] . '</option>';
            } ?>
                            </select>
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