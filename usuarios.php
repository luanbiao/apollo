<?php
// Include the necessary class files and start the session if needed
require_once 'classes/usuariosClass.php';
session_start();

// Create an instance of the Usuarios class
$usuariosClass = new Usuarios();

// Get the list of users from the database
$usersList = $usuariosClass->mostrarUsuarios();
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Usuários</h2>

    <!-- Display users in a table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Criação</th>
                <th>Ativo</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersList as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['nome']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['dataCriacao']; ?></td>
                    <td><?php echo $user['ativo']; ?></td>
                    <!-- Add more columns as needed -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
