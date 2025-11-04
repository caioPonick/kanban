<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANBAN</title>
    <link rel="stylesheet" href="../assets/styleIndex.css">
</head>
<body>
    <div class="header">
        <h2>KANBAN</h2>
        <div style="float:right;">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></div>
        <div class="nav">
            <a href="usuarios.php">Cadastro de Usuários</a>
            <a href="tarefas.php">Cadastro de Tarefas</a>
            <a href="visualizar_tarefas.php">Gerenciar Tarefas</a>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="container">
        <ul>
            <li><a class="menu-btn" href="usuarios.php">Cadastrar Usuário</a></li>
            <li><a class="menu-btn" href="tarefas.php">Cadastrar Tarefa</a></li>
            <li><a class="menu-btn" href="visualizar_tarefas.php">Visualizar Tarefas</a></li>
            <li><form method="post" action="logout.php" style="display:inline;"><button class="menu-btn" type="submit">Logout</button></form></li>
        </ul>
    </div>
</body>
</html>