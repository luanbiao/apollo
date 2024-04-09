function movimentarArquivos(filename, nome) {
    var form = document.createElement('form');
      form.action = 'movimentar.php'; 
      form.method = 'POST';

      var filenameInput = document.createElement('input');
      filenameInput.type = 'hidden';
      filenameInput.name = 'filename';
      filenameInput.value = filename;

      var nomeInput = document.createElement('input');
      nomeInput.type = 'hidden';
      nomeInput.name = 'nome';
      nomeInput.value = nome;

      form.appendChild(filenameInput);
      form.appendChild(nomeInput);

      
      document.body.appendChild(form);

      form.submit();
  }

  function thumbnailsMidia(filename) {
    var form = document.createElement('form');
    form.action = 'videos.php'; 
    form.method = 'POST';

    var filenameInput = document.createElement('input');
    filenameInput.type = 'hidden';
    filenameInput.name = 'modalFilenameMedia';
    filenameInput.value = filename;

    form.appendChild(filenameInput);

    
    document.body.appendChild(form);

    form.submit();
}