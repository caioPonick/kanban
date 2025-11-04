<?php
session_start();
require_once 'db/db.php';
$error = '';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $stmt = $conn->prepare('SELECT * FROM usuario WHERE emailUsuario=? AND senhaUsuario=?');
    $stmt->execute([$email, $senha]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['usuario_id'] = $user['idusuario'];
        $_SESSION['usuario_nome'] = $user['nomeUsuario'];
        header('Location: public/menu.php');
        exit;
    } else {
        $error = 'E-mail ou senha incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Kanban</title>
    <link rel="stylesheet" href="assets/styleUsuarios.css">
</head>
<body>
    <div class="container">
        <h2>Login de Usuário</h2>
        <?php if ($error): ?>
            <div style="color:red;"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="Email">
            <label>Senha:</label>
            <input type="password" name="senha" required placeholder="Senha">
            <button type="submit" name="login">Entrar</button>
        </form>
    </div>
</body>
</html>
