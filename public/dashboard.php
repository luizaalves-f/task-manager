<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

requireAuth(); // Verifica se o usuário está autenticado, caso contrário redireciona para login

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - Task Manager</title>
    </head>
</html>