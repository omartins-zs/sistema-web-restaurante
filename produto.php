<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION["nome_usuario"])) : ?>
<?php
    require_once __DIR__ . '/produto/ProdutoController.php';
    $produto_control = new ProdutoController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
        $resultado = $produto_control->cadastrar($_POST);
    }
    if (isset($_SESSION["flash_resultado"])) {
        $resultado = $_SESSION["flash_resultado"];
        unset($_SESSION["flash_resultado"]);
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

    <title>Produtos — Sistema Web Restaurante</title>
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="produto.php" method="POST">
                    <h2 class="mb-4">Cadastrar Produto</h2>
                    <?php if (isset($resultado)) : ?>
                    <div class="alert <?= htmlspecialchars($resultado["style"]) ?>">
                        <?= htmlspecialchars($resultado["msg"]); ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome_produto">Nome do produto:</label>
                            <input type="text" required class="form-control" id="nome_produto" aria-describedby="nomeHelp"
                                name="nome_produto" placeholder="Ex: Pizza Calabresa">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="categoria_produto">Categoria:</label>
                            <input type="text" required class="form-control" id="categoria_produto" name="categoria_produto"
                                placeholder="Ex: Pizzas" maxlength="50">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="valor_produto">Valor unitário (R$):</label>
                            <input type="number" required step=".01" min="0" class="form-control" name="valor_produto" id="valor_produto" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto_produto">Foto (URL ou nome do arquivo):</label>
                        <input type="text" class="form-control" name="foto_produto" id="foto_produto" placeholder="Ex: pizza-calabresa.jpg">
                    </div>
                    <div class="form-group">
                        <label for="info_produto">Informações adicionais:</label>
                        <textarea rows="3" name="info_produto" class="form-control" id="info_produto" placeholder="Ingredientes, tamanho ou observações do prato"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar produto</button>
                </form>
            </div>
        </div>

        <?php $produtos = $produto_control->selecionar(); ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Produtos Cadastrados</h4>
                <?php if (is_array($produtos) && count($produtos) > 0) : ?>
                <div class="table-responsive">
                    <table id="tab-produtos" class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cód.</th>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Info Adicional</th>
                                <th>Data/Hora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $p) : ?>
                            <tr id="produto<?= (int) $p['codigo'] ?>">
                                <td><?= (int) $p["codigo"]; ?></td>
                                <td><?= htmlspecialchars($p["foto"] ?? ""); ?></td>
                                <td><?= htmlspecialchars($p["nome"]); ?></td>
                                <td><?= htmlspecialchars($p["categoria"]); ?></td>
                                <td>R$ <?= number_format((float) $p["valor"], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($p["info_adicional"] ?? ""); ?></td>
                                <td><?= htmlspecialchars($p["data_hora"] ?? ""); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-warning"
                                        href="./produto_alterar.php?cod_prod=<?= (int) $p['codigo'] ?>">Alterar</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="removerProduto('<?= htmlspecialchars(addslashes($p['nome'])) ?>', <?= (int) $p['codigo'] ?>)">Remover</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                <div class="alert alert-info mb-0">Nenhum produto cadastrado no momento.</div>
                <?php endif; ?>
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
        <script>
        function removerProduto(nomeProduto, codProduto) {
            if (confirm('Deseja realmente remover o produto "' + nomeProduto + '"?')) {
                var ajax = new XMLHttpRequest();
                ajax.responseType = 'json';
                ajax.open("GET", "produto_remover.php?cod_prod=" + codProduto, true);
                ajax.send();
                ajax.addEventListener("readystatechange", function() {
                    if (ajax.readyState === 4 && ajax.status === 200) {
                        var resposta = ajax.response ? ajax.response.msg : "Item removido!";
                        alert(resposta);
                        var linha = document.getElementById("produto" + codProduto);
                        if (linha && linha.parentNode) {
                            linha.parentNode.removeChild(linha);
                        }
                    }
                });
            }
        }
        </script>
    </div>
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
