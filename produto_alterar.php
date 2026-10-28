<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION["nome_usuario"])) : ?>
<?php
    require_once __DIR__ . '/produto/ProdutoController.php';
    $produto_control = new ProdutoController();
    $cod_prod = isset($_GET["cod_prod"]) ? (int) $_GET["cod_prod"] : 0;
    $produtos = $produto_control->selecionar($cod_prod);
    if (empty($produtos)) {
        header("Location: produto.php");
        exit;
    }
    $produtoAtual = $produtos[0];
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

    <title>Alterar Produto — Sistema Web Restaurante</title>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="produto.php">Sistema Web Restaurante</a>
            <div class="collapse navbar-collapse show">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="produto.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pedido.php">Pedidos</a>
                    </li>
                </ul>
                <span class="navbar-text mr-3 text-light">
                    Olá, <?= htmlspecialchars($_SESSION["nome_usuario"]); ?>!
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="alterar_produto.php" method="POST">
                    <h2 class="mb-4">Alterar Produto</h2>
                    <div class="form-group">
                        <label for="cod_prod">Código do produto:</label>
                        <input type="text" readonly required value="<?= (int) $produtoAtual['codigo']; ?>" class="form-control"
                            id="cod_prod" name="cod_prod">
                    </div>
                    <div class="form-group">
                        <label for="nome_produto">Nome do produto:</label>
                        <input type="text" required value="<?= htmlspecialchars($produtoAtual['nome']); ?>" class="form-control" id="nome_produto"
                            name="nome_produto" placeholder="Digite o produto">
                    </div>
                    <div class="form-group">
                        <label for="categoria_produto">Categoria:</label>
                        <input type="text" required value="<?= htmlspecialchars($produtoAtual['categoria']); ?>" class="form-control"
                            id="categoria_produto" name="categoria_produto" placeholder="Digite a categoria" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="valor_produto">Valor unitário (R$):</label>
                        <input type="number" required value="<?= htmlspecialchars($produtoAtual['valor']); ?>" step=".01" min="0" class="form-control"
                            name="valor_produto" id="valor_produto">
                    </div>
                    <div class="form-group">
                        <label for="foto_produto">Foto (URL ou nome do arquivo):</label>
                        <input type="text" value="<?= htmlspecialchars($produtoAtual['foto'] ?? ''); ?>" class="form-control" name="foto_produto" id="foto_produto">
                    </div>
                    <div class="form-group">
                        <label for="info_produto">Informações adicionais:</label>
                        <textarea rows="4" cols="50" name="info_produto" class="form-control"
                            id="info_produto"><?= htmlspecialchars($produtoAtual["info_adicional"] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    <a href="produto.php" class="btn btn-secondary ml-2">Cancelar</a>
                </form>
                <?php if (isset($resultado)) : ?>
                <div class="alert <?= htmlspecialchars($resultado["style"]) ?> mt-3">
                    <?= htmlspecialchars($resultado["msg"]); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
<?php else : ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acesso Negado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="alert alert-danger">
        Você não está logado no sistema. <a href="index.php" class="alert-link">Clique aqui para fazer login</a>.
    </div>
</body>
</html>
<?php endif; ?>
