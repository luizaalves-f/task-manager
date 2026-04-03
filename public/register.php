<?php

session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Preencha todos os campos.";
    } else {
        if (register($pdo, $email, $password)) {
            // Redireciona para login com mensagem de sucesso
            header('Location: login.php?registered=1');
            exit;
        } else {
            $error = "Email já cadastrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registro - Task Manager</title>
    </head>
    <body>
        <h1>Cadastro de usuário</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Email: <input type="email" name="email" required></label><br>
            <label>Senha: <input type="password" name="password" required></label><br>
            <button type="submit">Registrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça login</a>.</p>
    </body>
</html>