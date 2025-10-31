<?php
require_once '../db/db.php';
$usuarios = $conn->query('SELECT * FROM usuario')->fetchAll();
if (isset($_POST['add'])) {
    $usuario = $_POST['usuario_idusuario'];
    $descricao = $_POST['descricaoTarefa'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $data = $_POST['data'];
    $status = $_POST['status'];
    $stmt = $conn->prepare('INSERT INTO tarefa (usuario_idusuario, descricaoTarefa, setor, prioridade, data, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$usuario, $descricao, $setor, $prioridade, $data, $status]);
    header('Location: tarefas.php');
    exit;
}
if (isset($_POST['edit'])) {
    $id = $_POST['idtarefa'];
    $usuario = $_POST['usuario_idusuario'];
    $descricao = $_POST['descricaoTarefa'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $data = $_POST['data'];
    $status = $_POST['status'];
    $stmt = $conn->prepare('UPDATE tarefa SET usuario_idusuario=?, descricaoTarefa=?, setor=?, prioridade=?, data=?, status=? WHERE idtarefa=?');
    $stmt->execute([$usuario, $descricao, $setor, $prioridade, $data, $status, $id]);
    header('Location: tarefas.php');
    exit;
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM tarefa WHERE idtarefa=?');
    $stmt->execute([$id]);
    header('Location: tarefas.php');
    exit;
}
$editTarefa = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare('SELECT * FROM tarefa WHERE idtarefa=?');
    $stmt->execute([$id]);
    $editTarefa = $stmt->fetch();
}
$tarefas = $conn->query('SELECT t.*, u.nomeUsuario FROM tarefa t JOIN usuario u ON t.usuario_idusuario = u.idusuario')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="../assets/styleTarefas.css">
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
        <h3>Cadastro de Tarefas</h3>
        <form method="post">
            <label>Descrição:</label>
            <input type="text" name="descricaoTarefa" required placeholder="Descrição" value="<?= $editTarefa['descricaoTarefa'] ?? '' ?>">
            <label>Setor:</label>
            <input type="text" name="setor" required placeholder="Setor" value="<?= $editTarefa['setor'] ?? '' ?>">
            <label>Usuário:</label>
            <select name="usuario_idusuario" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['idusuario'] ?>" <?= ($editTarefa && $editTarefa['usuario_idusuario'] == $u['idusuario']) ? 'selected' : '' ?>><?= $u['nomeUsuario'] ?></option>
                <?php endforeach; ?>
            </select>
            <label>Prioridade:</label>
            <select name="prioridade" required>
                <option value="">Prioridade</option>
                <?php foreach (["baixa","media","alta"] as $p): ?>
                    <option value="<?= $p ?>" <?= ($editTarefa && $editTarefa['prioridade'] == $p) ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Data:</label>
            <input type="date" name="data" required value="<?= $editTarefa['data'] ?? '' ?>">
            <input type="hidden" name="status" value="<?= $editTarefa['status'] ?? 'a fazer' ?>">
            <button type="submit" name="<?= $editTarefa ? 'edit' : 'add' ?>"><?= $editTarefa ? 'Salvar' : 'Cadastrar' ?></button>
            <?php if ($editTarefa): ?><a href="tarefas.php">Cancelar</a><?php endif; ?>
        </form>
    </div>
</body>
</html>