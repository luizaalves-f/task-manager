<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

$error = null;
$success = null;

if (isset($_GET['registered'])) {
    $success = "Cadastro realizado com sucesso! Faça seu login.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Preencha todos os campos.";
    } else {
        $userId = login($pdo, $email, $password);
        if ($userId) {
            $_SESSION['user_id'] = $userId;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "E-mail ou senha inválidos.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login - Task Manager</title>
    </head>
    <body>
        <h1>Login</h1>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Email: <input type="email" name="email" required></label><br>
            <label>Senha: <input type="password" name="password" required></label><br>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Registre-se</a>.</p>
    </body>
</html>