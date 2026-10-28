<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["nome_usuario"]) && !empty($_SESSION["nome_usuario"])) {
    header("Location: produto.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/style.css">
    <title>Registro de Pedidos 1.0 — Login</title>
</head>

<body>
    <video autoplay muted loop class="video">
        <source src="./gif/Pizza.mp4" type="video/mp4">
    </video>
    <div class="container">
        <form action="login.php" class="form-login" id="form_login" method="POST">
            <h2>Faça login</h2>
            <p class="text-light mb-4">Sistema Web Restaurante</p>
            <?php if (isset($resultado) && $resultado["cod"] == 0) : ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($resultado["msg"]); ?>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <input id="email" name="email" type="email" class="form-control text-white bg-transparent" required placeholder="Digite seu email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="form-group">
                <input id="senha" name="senha" type="password" class="form-control text-white bg-transparent" required placeholder="Digite sua senha">
            </div>
            <input type="submit" id="submeter" value="Entrar" class="btn btn-primary btn-block mt-3">
        </form>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
    </div>
</body>

</html>
