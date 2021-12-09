<?php session_start(); ?>
<?php if (isset($_SESSION["nome_usuario"])) :  ?>
<?php require_once('produto/Produto.php');
    $produtoObj = new Produto();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Produto</title>
</head>

<body>
    <div class="container">
        <form action="produto_cadastrar.php" method="POST">
            <h2>Produtos</h2><br>
            <div class="form-group">
                <label for="nome_produto">Nome do produto:</label>
                <input type="text" required class="form-control" id="nome_produto" aria-describedby="nomeHelp"
                    name="nome_produto" placeholder="Digite o produto">
            </div>
            <div class="form-group">
                <label for="categoria_produto">Categoria:</label>
                <input type="text" required class="form-control" id="categoria_produto" name="categoria_produto"
                    placeholder="Digite a quantidade" maxlength="10">
            </div>
            <div class="form-group">
                <label for="valor_produto">Valor unitário(R$):</label>
                <input type="number" required step=".01" class="form-control" name="valor_produto" id="valor_produto">
            </div>
            <div class="form-group">
                <label for="preco_produto">Foto:</label>
                <input type="file" class="form-control" name="foto_produto" id="foto_produto">
            </div>
            <div class="form-group">
                <label for="info_produto">Informaçoes adicionais:</label>
                <textarea rows="4" cols="50" name="info_produto" class="form-control" id="info_produto"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar produto</button>
            <?php if (isset($resultado)) : ?>
            <div class="alert <?= $resultado["style"] ?>">
                <?php echo $resultado["msg"]; ?>
            </div>
            <?php endif; ?>
        </form>
        <br><br>

        <?php $produtos = $produtoObj->selecionar(); ?>

        <?php if (count($produtos) > 0) : ?>
        <h4>Produtos Cadastrados</h4>

        <table class="table">
            <tr>
                <th>Cod.</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Valor</th>
                <th>Info Adicional</th>
                <th>Data hora</th>
                <th></th>
            </tr>
            <?php foreach ($produtos as $p) : ?>
            <tr>
                <td><?= $p["codigo"]; ?></td>
                <td><?= $p["foto"]; ?></td>
                <td><?= $p["nome"]; ?></td>
                <td><?= $p["categoria"]; ?></td>
                <td><?= $p["valor"]; ?></td>
                <td><?= $p["info_adicional"]; ?></td>
                <td><?= $p["data_hora"]; ?></td>
                <td>
                    <a class="btn btn-sm btn-outline-warning"
                        href="./produto_form_alterar.php?cod_prod=<?= $p['codigo']  ?>">Alterar</a>
                    <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover <?= $p['nome'];  ?>?');"
                        href="./produto_remover.php?cod_prod=<?= $p['codigo']  ?>">Remover</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
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
<?php else : ?>
<div class="alert alert-danger">
    Voce não está logado no sistema
</div>
<?php endif; ?>