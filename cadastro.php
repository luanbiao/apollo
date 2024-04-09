<?php
// Include the necessary class files and start the session
require_once 'classes/usuariosClass.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the name, email, and password from the form
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Create an instance of the Usuarios class
    $usuarios = new Usuarios();

    // Check if the email is already registered
    if ($usuarios->consultarUsuario($email)) {
        $error = 'Email já registrado.';
    } else {
        // Create a new user
        if ($usuarios->criarUsuario($nome, $email, $senha)) {
            // Set a session variable to indicate the user is logged in
            $_SESSION['logged_in'] = true;

            // Redirect to the index.php page
            header('Location: index.php');
            exit;
        } else {
            $error = 'Erro ao cadastrar usuário.';
        }
    }
}
?>

<?php include 'header.php'; ?>

<h2 class="mb-4">Login</h2>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="form-cadastro form">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

<?php include 'footer.php'; ?>


