<?php
session_start();
require_once '../db/db.php';
if (isset($_POST['alterar_status'])) {
    $id = $_POST['idtarefa'];
    $novo_status = $_POST['novo_status'];
    $stmt = $conn->prepare('UPDATE tarefa SET status=? WHERE idtarefa=? AND usuario_idtarefa=?');
    $stmt->execute([$novo_status, $id, $_SESSION['usuario_id']]);
    header('Location: visualizar_tarefas.php');
    exit;
}
$tarefas = $conn->query('SELECT t.*, u.nomeUsuario FROM tarefa t JOIN usuario u ON t.usuario_idtarefa = u.idtarefa ORDER BY t.idtarefa DESC')->fetchAll();
$grupos = ['a fazer' => [], 'fazendo' => [], 'feito' => []];
foreach ($tarefas as $t) {
    $grupos[$t['status']][] = $t;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="../assets/styleVisualizar.css">
</head>
<body>
    <div class="header">
        <h2>Gerenciamento de Tarefas</h2>
        <div class="nav">
            <a href="usuarios.php">Cadastro de Usuários</a>
            <a href="tarefas.php">Cadastro de Tarefas</a>
            <a href="visualizar_tarefas.php">Gerenciar Tarefas</a>
        </div>
        <div style="margin:10px 0;">
            <form method="post" action="logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="tarefas-container">
        <?php foreach (["a fazer" => "A Fazer", "fazendo" => "Fazendo", "feito" => "Pronto"] as $status => $titulo): ?>
        <div class="grupo">
            <h3><?= $titulo ?></h3>
            <?php foreach ($grupos[$status] as $t): ?>
            <div class="card">
                <b>Descrição:</b> <?= htmlspecialchars($t['descricaoTarefa']) ?><br>
                <b>Setor:</b> <?= htmlspecialchars($t['setor']) ?><br>
                <b>Prioridade:</b> <?= ucfirst($t['prioridade']) ?><br>
                <b>Vinculada a:</b> <?= htmlspecialchars($t['nomeUsuario']) ?><br>
                <div class="card-actions">
                    <form method="post" style="display:inline">
                        <input type="hidden" name="idtarefa" value="<?= $t['idtarefa'] ?>">
                        <select name="novo_status">
                            <?php foreach (["a fazer","fazendo","feito"] as $s): ?>
                                <option value="<?= $s ?>" <?= $t['status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="alterar_status">Alterar Status</button>
                    </form>
                    <a href="editar_tarefa.php?id=<?= $t['idtarefa'] ?>">Editar</a>
                    <a href="visualizar_tarefas.php?delete=<?= $t['idtarefa'] ?>" onclick="return confirm('Excluir esta tarefa?')">Excluir</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM tarefa WHERE idtarefa=? AND usuario_idtarefa=?');
    $stmt->execute([$id, $_SESSION['usuario_id']]);
    header('Location: visualizar_tarefas.php');
    exit;
}
?>