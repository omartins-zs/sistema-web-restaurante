<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Registro de Pedidos 1.0</title>
</head>

<body>
    <h2>Efetue login</h2>
    <form action="login.php" id="form_login" method="POST">
        <?php if (isset($resultado) && $resultado["cod"] == 0) : ?>
            <div class="alert alert-danger">
                <?php echo $resultado["msg"]; ?>
            </div>
        <?php endif; ?>
        <input id="email" name="email" type="email" placeholder="Digite seu email">
        <br><br>
        <input id="senha" name="senha" type="password" placeholder="Digite sua senha">
        <br><br>
        <input type="submit" id="submeter" value="Entrar">
    </form>
</body>

</html>