<?php
session_start();
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: ponto.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Zart Supermercados</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="login-body">
    <div class="box">
        <div class="border-line"></div>
        <form action="auth.php" method="POST">
            <h2>Relógio Ponto - Supermercado Zart</h2>
            <div class="input-box">
                <input type="text" name="usuario" required="required">
                <span>Número de Matrícula</span>
                <i></i>
            </div>
            <div class="input-box">
                <input type="password" name="senha" required="required">
                <span>Senha de acesso</span>
                <i></i>
            </div>
           
            <input type="submit" value="Login" class="btn">
        </form>
    </div>
</body>
</html>
