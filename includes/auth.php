<?php

/*
Funções de autenticação
*/

// Usa password_hash() para criar um hash seguro da senha
function register($pdo, $email, $password) {
    // Verifica se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");      // prepara a query
    $stmt->execute([$email]);                                          // passa o parâmetro para executar

    if ($stmt->fetch()) {
        return false; // Email já registrado
    }

    // Cria hash da senha 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insere usuário
    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    return $stmt->execute([$email, $hashedPassword]);
}

// Usa password_verify() para verificar a senha
function login($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        return $user['id'];
    }
    return false;
}

// Verifica $_SESSION['user_id']
// Não vou usar session_start() aqui, vou iniciar a sessão manualmente no ínício de cada arquivo que precisa de autenticação, para evitar problemas de sessão já iniciada. Assim, a função isLoggedIn() só verifica se a sessão foi iniciada e se o user_id está definido.
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redireciona se não estiver logado
function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        echo "Acesso negado. Redirecionando para login...";
        exit;
    }
}