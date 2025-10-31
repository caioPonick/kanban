<?php
require_once '../db/db.php';
if (!isset($_GET['id'])) {
    header('Location: visualizar_tarefas.php');
    exit;
}
$id = $_GET['id'];
$stmt = $conn->prepare('SELECT * FROM tarefa WHERE idtarefa=?');
$stmt->execute([$id]);
$tarefa = $stmt->fetch();
if (!$tarefa) {
    header('Location: visualizar_tarefas.php');
    exit;
}
$usuarios = $conn->query('SELECT * FROM usuario')->fetchAll();
if (isset($_POST['edit'])) {
    $usuario = $_POST['usuario_idusuario'];
    $descricao = $_POST['descricaoTarefa'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $data = $_POST['data'];
    $status = $_POST['status'];
    $stmt = $conn->prepare('UPDATE tarefa SET usuario_idusuario=?, descricaoTarefa=?, setor=?, prioridade=?, data=?, status=? WHERE idtarefa=?');
    $stmt->execute([$usuario, $descricao, $setor, $prioridade, $data, $status, $id]);
    header('Location: visualizar_tarefas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="../assets/styleEditar.css">
</head>
<body>
    <div class="form-container">
        <h2>Editar Tarefa</h2>
        <form method="post">
            <label>Usuário Vinculado</label>
            <select name="usuario_idusuario" required>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['idusuario'] ?>" <?= ($tarefa['usuario_idusuario'] == $u['idusuario']) ? 'selected' : '' ?>><?= $u['nomeUsuario'] ?></option>
                <?php endforeach; ?>
            </select>
            <label>Descrição</label>
            <input type="text" name="descricaoTarefa" required value="<?= htmlspecialchars($tarefa['descricaoTarefa']) ?>">
            <label>Setor</label>
            <input type="text" name="setor" required value="<?= htmlspecialchars($tarefa['setor']) ?>">
            <label>Prioridade</label>
            <select name="prioridade" required>
                <?php foreach (["baixa","media","alta"] as $p): ?>
                    <option value="<?= $p ?>" <?= ($tarefa['prioridade'] == $p) ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Data</label>
            <input type="date" name="data" required value="<?= $tarefa['data'] ?>">
            <label>Status</label>
            <select name="status" required>
                <?php foreach (["a fazer","fazendo","feito"] as $s): ?>
                    <option value="<?= $s ?>" <?= ($tarefa['status'] == $s) ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="edit">Salvar</button>
        </form>
        <a href="visualizar_tarefas.php">Voltar</a>
    </div>
</body>
</html>