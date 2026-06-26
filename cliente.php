<?php
include "conecta.php";

// Variáveis para o formulário
$cpf = $nome = $endereco = $telefone = "";

// Se o formulário foi submetido para criação
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['cliente_cpf'])) {
    $cliente_cpf = $_POST['campo_cpf'];
    $nome = $_POST['campo_nome'];
    $endereco = $_POST['campo_endereco'];
    $telefone = $_POST['campo_telefone'];

    $stmt = $conexao->prepare("INSERT INTO cliente (cliente_cpf, nome, endereco, telefone)
                               VALUES (:cpf, :nome, :endereco, :telefone)");
    $stmt->execute([
        ':cpf' => $cliente_cpf,
        ':nome' => $nome,
        ':endereco' => $endereco,
        ':telefone' => $telefone
    ]);

    header("Location: cliente.php");
    exit();
}

// Se o formulário foi submetido para atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['cliente_cpf'])) {
    $cliente_cpf = $_POST['campo_cpf'];
    $nome = $_POST['campo_nome'];
    $endereco = $_POST['campo_endereco'];
    $telefone = $_POST['campo_telefone'];

    $stmt = $conexao->prepare("UPDATE cliente
                               SET nome = :nome, endereco = :endereco, telefone = :telefone
                               WHERE cliente_cpf = :cpf");
    $stmt->execute([
        ':nome' => $nome,
        ':endereco' => $endereco,
        ':telefone' => $telefone,
        ':cpf' => $cliente_cpf
    ]);

    header("Location: cliente.php");
    exit();
}

// Se a solicitação foi para exclusão
if (isset($_GET['delete_cpf'])) {
    $stmt = $conexao->prepare("DELETE FROM cliente WHERE cliente_cpf = :cpf");
    $stmt->execute([':cpf' => $_GET['delete_cpf']]);

    header("Location: cliente.php");
    exit();
}

// Se a solicitação foi para edição
if (isset($_GET['cliente_cpf'])) {
    $stmt = $conexao->prepare("SELECT * FROM cliente WHERE cliente_cpf = :cpf");
    $stmt->execute([':cpf' => $_GET['cliente_cpf']]);
    $dado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dado) {
        $cpf = $dado["cliente_cpf"];
        $nome = $dado["nome"];
        $endereco = $dado["endereco"];
        $telefone = $dado["telefone"];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clientes (SQLite + PDO)</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="m-5">
    <a href="index.php" class="btn btn-outline-primary m-3"">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <h1>Clientes</h1>

    <form method="POST" action="<?= isset($_GET['cliente_cpf']) ? 'cliente.php?cliente_cpf=' . $_GET['cliente_cpf'] : 'cliente.php' ?>">
        <div>
            <label for="campo_cpf">Cliente CPF</label>
            <input class="form-control" name="campo_cpf" <?= isset($_GET['cliente_cpf']) ? 'readonly' : '' ?> required id="campo_cpf" type="text" value="<?= htmlspecialchars($cpf) ?>">
        </div>
        <div>
            <label for="campo_nome">Nome</label>
            <input class="form-control" name="campo_nome" required id="campo_nome" type="text" value="<?= htmlspecialchars($nome) ?>">
        </div>
        <div>
            <label for="campo_endereco">Endereço</label>
            <input class="form-control" name="campo_endereco" required id="campo_endereco" type="text" value="<?= htmlspecialchars($endereco) ?>">
        </div>
        <div>
            <label for="campo_telefone">Telefone</label>
            <input class="form-control" name="campo_telefone" required id="campo_telefone" type="text" value="<?= htmlspecialchars($telefone) ?>">
        </div>
        <div>
            <input class="m-2 btn btn-primary" name="botao_submit" value="Salvar" type="submit">
        </div>
    </form>

    <h2>Lista de Clientes</h2>
    <table class="table" border="1">
        <tr>
            <th>Cliente CPF</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Editar</th>
            <th>Apagar</th>
        </tr>
        <?php
        $stmt = $conexao->query("SELECT * FROM cliente ORDER BY nome");
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($clientes as $linha) {
            echo "<tr>
                <td>" . htmlspecialchars($linha['cliente_cpf']) . "</td>
                <td>" . htmlspecialchars($linha['nome']) . "</td>
                <td>" . htmlspecialchars($linha['endereco']) . "</td>
                <td>" . htmlspecialchars($linha['telefone']) . "</td>
                <td><a href='cliente.php?cliente_cpf=" . htmlspecialchars($linha['cliente_cpf']) . "'>EDITAR</a></td>
                <td><a href='cliente.php?delete_cpf=" . htmlspecialchars($linha['cliente_cpf']) . "'>APAGAR</a></td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>