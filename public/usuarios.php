<?php
session_start();

require_once '../db/db.php';

if (isset($_POST['add'])) {
    $nome = $_POST['nomeUsuario'];
    $email = $_POST['emailUsuario'];
    $stmt = $conn->prepare('INSERT INTO usuario (nomeUsuario, emailUsuario) VALUES (?, ?)');
    $stmt->execute([$nome, $email]);
    header('Location: usuarios.php');
    exit;
}
if (isset($_POST['edit'])) {
    $id = $_POST['idusuario'];
    $nome = $_POST['nomeUsuario'];
    $email = $_POST['emailUsuario'];
    $stmt = $conn->prepare('UPDATE usuario SET nomeUsuario=?, emailUsuario=? WHERE idusuario=?');
    $stmt->execute([$nome, $email, $id]);
    header('Location: usuarios.php');
    exit;
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM usuario WHERE idusuario=?');
    $stmt->execute([$id]);
    header('Location: usuarios.php');
    exit;
}
$editUser = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare('SELECT * FROM usuario WHERE idusuario=?');
    $stmt->execute([$id]);
    $editUser = $stmt->fetch();
}
$usuarios = $conn->query('SELECT * FROM usuario')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="../assets/styleUsuarios.css">
</head>
<body>
    <div class="header">
        <h2>Gerenciamento de Tarefas</h2>
        <div class="nav">
            <a href="usuarios.php">Cadastro de Usuários</a>
            <a href="tarefas.php">Cadastro de Tarefas</a>
            <a href="visualizar_tarefas.php">Gerenciar Tarefas</a>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="container">
        <h3>Cadastro de Usuários</h3>
        <form method="post">
            <?php if ($editUser): ?>
                <input type="hidden" name="idusuario" value="<?= $editUser['idusuario'] ?>">
                <label>Nome:</label>
                <input type="text" name="nomeUsuario" value="<?= $editUser['nomeUsuario'] ?>" required placeholder="Nome">
                <label>Email:</label>
                <input type="email" name="emailUsuario" value="<?= $editUser['emailUsuario'] ?>" required placeholder="Email">
                <button type="submit" name="edit">Salvar</button>
                <a href="usuarios.php">Cancelar</a>
            <?php else: ?>
                <label>Nome:</label>
                <input type="text" name="nomeUsuario" required placeholder="Nome">
                <label>Email:</label>
                <input type="email" name="emailUsuario" required placeholder="Email">
                <button type="submit" name="add">Cadastrar</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>