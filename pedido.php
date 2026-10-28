<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION["nome_usuario"])) : ?>
<?php
    require_once __DIR__ . '/bd/BancoDados.php';
    $itens_pedido = [];
    try {
        $bd = new BancoDados();
        $conn = $bd->conectar();
        $stmt = $conn->prepare("SELECT * FROM item_pedido ORDER BY codigo DESC");
        $stmt->execute();
        $itens_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $itens_pedido = [];
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

    <title>Pedidos — Sistema Web Restaurante</title>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="produto.php">Sistema Web Restaurante</a>
            <div class="collapse navbar-collapse show">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="produto.php">Produtos</a>
                    </li>
                    <li class="nav-item active">
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="cadastrar_pedido.php" method="POST">
                    <h2 class="mb-4">Escolha de Item do Pedido</h2>
                    <?php if (isset($resultado)) : ?>
                    <div class="alert <?= htmlspecialchars($resultado["style"]) ?>">
                        <?= htmlspecialchars($resultado["msg"]); ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome_produto">Nome do produto:</label>
                            <input type="text" required class="form-control" id="nome_produto" aria-describedby="nomeHelp"
                                name="nome_produto" placeholder="Digite o produto">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="qtd_produto">Quantidade:</label>
                            <input type="number" required min="1" class="form-control" id="qtd_produto" name="qtd_produto"
                                placeholder="Ex: 2">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="preco_produto">Preço unitário (R$):</label>
                            <input type="number" required step=".01" min="0" class="form-control" name="preco_produto" id="preco_produto" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="obs_produto">Observação:</label>
                        <input type="text" class="form-control" name="obs_produto" id="obs_produto" placeholder="Ex: Sem cebola, borda recheada">
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar item</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Itens de Pedido Registrados</h4>
                <?php if (count($itens_pedido) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cód.</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                                <th>Observação</th>
                                <th>Data/Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens_pedido as $item) : ?>
                            <tr>
                                <td><?= (int) ($item['codigo'] ?? 0); ?></td>
                                <td><?= htmlspecialchars($item['nome_produto']); ?></td>
                                <td><?= (int) $item['quantidade']; ?></td>
                                <td>R$ <?= number_format((float) $item['preco_und'], 2, ',', '.'); ?></td>
                                <td>R$ <?= number_format((float) $item['preco_und'] * (int) $item['quantidade'], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($item['observacao'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['data_hora'] ?? ''); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                <div class="alert alert-info mb-0">Nenhum item de pedido registrado no momento.</div>
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
