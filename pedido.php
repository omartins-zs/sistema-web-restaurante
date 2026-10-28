<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION["nome_usuario"])) : ?>
<?php
    require_once __DIR__ . '/bd/BancoDados.php';
    require_once __DIR__ . '/produto/ProdutoController.php';

    $produto_control = new ProdutoController();
    $produtos_disponiveis = $produto_control->selecionar();

    $itens_pedido = [];
    $total_geral = 0.0;
    try {
        $bd = new BancoDados();
        $conn = $bd->conectar();
        $stmt = $conn->prepare("SELECT * FROM item_pedido ORDER BY codigo DESC");
        $stmt->execute();
        $itens_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($itens_pedido as $it) {
            $total_geral += (float) $it['preco_und'] * (int) $it['quantidade'];
        }
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
            <a class="navbar-brand" href="produto.php">🍕 Sistema Web Restaurante</a>
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

                    <?php if (!empty($produtos_disponiveis)) : ?>
                    <div class="form-group bg-light p-3 border rounded mb-3">
                        <label for="select_cardapio"><strong>Preencher a partir do Cardápio Cadastrado (Opcional):</strong></label>
                        <select class="form-control" id="select_cardapio" onchange="selecionarDoCardapio(this)">
                            <option value="">-- Selecione um produto do cardápio --</option>
                            <?php foreach ($produtos_disponiveis as $prod) : ?>
                            <option value="<?= htmlspecialchars($prod['nome']) ?>" data-preco="<?= htmlspecialchars($prod['valor']) ?>">
                                <?= htmlspecialchars($prod['nome']) ?> (<?= htmlspecialchars($prod['categoria']) ?>) - R$ <?= number_format((float)$prod['valor'], 2, ',', '.') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome_produto">Nome do produto:</label>
                            <input type="text" required class="form-control" id="nome_produto"
                                name="nome_produto" placeholder="Ex: Pizza Calabresa">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="qtd_produto">Quantidade:</label>
                            <input type="number" required min="1" value="1" class="form-control" id="qtd_produto" name="qtd_produto">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="preco_produto">Preço unitário (R$):</label>
                            <input type="number" required step=".01" min="0" class="form-control" name="preco_produto" id="preco_produto" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="obs_produto">Observação:</label>
                        <input type="text" class="form-control" name="obs_produto" id="obs_produto" placeholder="Ex: Sem cebola, borda recheada com catupiry">
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar item ao pedido</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Itens de Pedido Registrados</h4>
                    <?php if (count($itens_pedido) > 0) : ?>
                    <span class="badge badge-success p-2" style="font-size: 1rem;">
                        Total do Pedido: R$ <?= number_format($total_geral, 2, ',', '.'); ?>
                    </span>
                    <?php endif; ?>
                </div>

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
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens_pedido as $item) : ?>
                            <tr id="item<?= (int) ($item['codigo'] ?? 0); ?>">
                                <td><?= (int) ($item['codigo'] ?? 0); ?></td>
                                <td><strong><?= htmlspecialchars($item['nome_produto']); ?></strong></td>
                                <td><?= (int) $item['quantidade']; ?></td>
                                <td>R$ <?= number_format((float) $item['preco_und'], 2, ',', '.'); ?></td>
                                <td class="text-success font-weight-bold">R$ <?= number_format((float) $item['preco_und'] * (int) $item['quantidade'], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($item['observacao'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['data_hora'] ?? ''); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="removerItemPedido('<?= htmlspecialchars(addslashes($item['nome_produto'])) ?>', <?= (int) $item['codigo'] ?>)">
                                        Excluir
                                    </button>
                                </td>
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
    <script>
    function selecionarDoCardapio(select) {
        var opt = select.options[select.selectedIndex];
        if (opt.value) {
            document.getElementById('nome_produto').value = opt.value;
            var preco = opt.getAttribute('data-preco');
            if (preco) {
                document.getElementById('preco_produto').value = parseFloat(preco).toFixed(2);
            }
        }
    }

    function removerItemPedido(nomeItem, codItem) {
        if (confirm('Deseja realmente remover o item "' + nomeItem + '" do pedido?')) {
            var ajax = new XMLHttpRequest();
            ajax.responseType = 'json';
            ajax.open("GET", "pedido_remover.php?cod_item=" + codItem, true);
            ajax.send();
            ajax.addEventListener("readystatechange", function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    var resposta = ajax.response ? ajax.response.msg : "Item removido!";
                    alert(resposta);
                    var linha = document.getElementById("item" + codItem);
                    if (linha && linha.parentNode) {
                        linha.parentNode.removeChild(linha);
                    }
                    window.location.reload();
                }
            });
        }
    }
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
