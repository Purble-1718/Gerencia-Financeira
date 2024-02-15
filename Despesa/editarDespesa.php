<?php  

require "./../config.php";

$sql = "SELECT * FROM Despesa";
$sql = $pdo->prepare($sql);
$sql->execute();
$dados = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM CategoriaDespesa";
$sql = $pdo->prepare($sql);
$sql->execute();
$infos = $sql->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'];
$sql = "SELECT * FROM Despesa WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
$item = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GestãoFinanceira</title>
        <link rel="stylesheet" href="./../styles/styleDespesa.css">
    </head>

    <body>
        <header>
            <nav>
                <ul class="lista">
                    <li><a href="./../receitas.php">Receitas</a></li>
                    <li><a href="./despesas.php">Despesas</a></li>
                    <li><a href="./../Categorias/categorias.php">Categorias</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="formulario">
                <form action="./confirmarEditarDespesa.php" method=get>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <label>
                        Descrição
                        <input type="text" name="descricao" value="<?= $item['descricao'] ?>">
                    </label>
                    <label>
                        Valor
                        <input type="number" name="valor" value="<?= $item['valor'] ?>">
                    </label>
                    <label>
                        Data
                        <input type="date" name="data_mvto" value="<?= $item['data_mvto'] ?>">
                    </label>
                    <label>
                        Categoria
                        <select name="categoria">
                            <option value="<?= $item['categoria_id'] ?>">
                                <?php foreach($infos as $info): ?>
                                    <?php if($info['id'] == $item['categoria_id']): ?>
                                        <?= $info['descricao'] ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </option>
                            <?php foreach($infos as $info): ?>
                                <option value="<?= $info['id'] ?>"><?= $info['descricao'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="status">
                            <?php if($item['status_pago'] == "Pendente"): ?>
                                <option value="Pendente">Pendente</option>
                                <option value="Paga">Paga</option>
                            <?php elseif($item['status_pago'] == "Paga"): ?>
                                <option value="Paga">Paga</option>
                                <option value="Pendente">Pendente</option>
                            <?php endif; ?>
                        </select>
                    </label>
                    <button type="submit">Editar</button>
                </form>
            </section>
            <section class="tabela">
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados as $contador => $dado): ?>
                            <tr>
                                <td><?= ++$contador ?></td>
                                <td><?= $dado['descricao'] ?></td>
                                <td><?= $dado['valor'] ?></td>
                                <td><?= $dado['data_mvto'] ?></td>
                                <td>
                                    <?php foreach($infos as $info): ?>
                                        <?php if($dado['categoria_id'] == $info['id']): ?>
                                            <?= $info['descricao']?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= $dado['status_pago'] ?></td>
                                <td>
                                    <a href="./deletarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a> <!--Vai para o ./deletar.php passando o id de uma entrada GET-->
                                    <a href="./editarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
        <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script> <!--Importa biblioteca de fontes. link do script que contém os ícones. crossorigin é para pegar recursos sem verificação -->
    </body>
</html>