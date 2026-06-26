<?php
include "conecta.php";

// Carrega listas de clientes e técnicos
$clientes = $conexao->query("SELECT cliente_cpf, nome FROM cliente ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$tecnicos = $conexao->query("SELECT tecnico_matricula, nome FROM tecnico ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Variáveis
$numero = $problema = $solucao = $data_abertura = $data_fechamento = $cliente_cpf = $tecnico_matricula = "";

// Criar ordem
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['numero'])) {
    $stmt = $conexao->prepare("
        INSERT INTO ordem_servico (problema, solucao_problema, data_abertura, data_fechamento, cliente_cpf, tecnico_matricula)
        VALUES (:problema, :solucao, :abertura, :fechamento, :cliente, :tecnico)
    ");
    $stmt->execute([
        ':problema' => $_POST['campo_problema'],
        ':solucao' => $_POST['campo_solucao'],
        ':abertura' => $_POST['campo_abertura'],
        ':fechamento' => $_POST['campo_fechamento'],
        ':cliente' => $_POST['campo_cliente'],
        ':tecnico' => $_POST['campo_tecnico']
    ]);
    header("Location: ordem_servico.php");
    exit;
}

// Atualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['numero'])) {
    $stmt = $conexao->prepare("
        UPDATE ordem_servico
        SET problema=:problema, solucao_problema=:solucao, data_abertura=:abertura, data_fechamento=:fechamento,
            cliente_cpf=:cliente, tecnico_matricula=:tecnico
        WHERE numero=:numero
    ");
    $stmt->execute([
        ':problema' => $_POST['campo_problema'],
        ':solucao' => $_POST['campo_solucao'],
        ':abertura' => $_POST['campo_abertura'],
        ':fechamento' => $_POST['campo_fechamento'],
        ':cliente' => $_POST['campo_cliente'],
        ':tecnico' => $_POST['campo_tecnico'],
        ':numero' => $_GET['numero']
    ]);
    header("Location: ordem_servico.php");
    exit;
}

// Excluir
if (isset($_GET['delete_numero'])) {
    $stmt = $conexao->prepare("DELETE FROM ordem_servico WHERE numero = :n");
    $stmt->execute([':n' => $_GET['delete_numero']]);
    header("Location: ordem_servico.php");
    exit;
}

// Editar
if (isset($_GET['numero'])) {
    $stmt = $conexao->prepare("SELECT * FROM ordem_servico WHERE numero = :n");
    $stmt->execute([':n' => $_GET['numero']]);
    $dado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($dado) extract($dado);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ordens de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="m-5">
    <a href="index.php" class="btn btn-outline-primary m-3"">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
<h1>Ordens de Serviço</h1>
<form method="POST" action="<?= isset($_GET['numero']) ? 'ordem_servico.php?numero=' . $_GET['numero'] : 'ordem_servico.php' ?>">
    <div><label>Cliente</label>
        <select class="form-select" name="campo_cliente" required>
            <option value="">Selecione</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['cliente_cpf'] ?>" <?= $c['cliente_cpf'] == $cliente_cpf ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div><label>Problema</label>
        <textarea class="form-control" name="campo_problema" required><?= htmlspecialchars($problema) ?></textarea>
    </div>
    <div><label>Data de Abertura</label>
        <input class="form-control" name="campo_abertura" type="date" required value="<?= htmlspecialchars($data_abertura) ?>">
    </div>
    <div><label>Solução</label>
        <textarea class="form-control" name="campo_solucao"><?= htmlspecialchars($solucao) ?></textarea>
    </div>

    <div><label>Data de Fechamento</label>
        <input class="form-control" name="campo_fechamento" type="date" value="<?= htmlspecialchars($data_fechamento) ?>">
    </div>

    <div><label>Técnico</label>
        <select class="form-select" name="campo_tecnico" required>
            <option value="">Selecione</option>
            <?php foreach ($tecnicos as $t): ?>
                <option value="<?= $t['tecnico_matricula'] ?>" <?= $t['tecnico_matricula'] == $tecnico_matricula ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div><input class="btn btn-primary m-2" type="submit" value="Salvar"></div>
</form>

<h2>Lista de Ordens</h2>
<table class="table">
<tr><th>Número</th><th>Cliente</th><th>Abertura</th><th>Problema</th><th>Técnico</th><th>Fechamento</th><th>Editar</th><th>Apagar</th></tr>
<?php
$sql = "SELECT o.numero, o.problema, o.data_abertura, o.data_fechamento,
        c.nome AS cliente, t.nome AS tecnico
        FROM ordem_servico o
        JOIN cliente c ON c.cliente_cpf = o.cliente_cpf
        JOIN tecnico t ON t.tecnico_matricula = o.tecnico_matricula
        ORDER BY o.numero DESC";
foreach ($conexao->query($sql) as $linha) {
    echo "<tr>
        <td>{$linha['numero']}</td>
        <td>{$linha['cliente']}</td>
        <td>{$linha['data_abertura']}</td>
        <td>{$linha['problema']}</td>
        <td>{$linha['tecnico']}</td>
        <td>{$linha['data_fechamento']}</td>
        <td><a href='ordem_servico.php?numero={$linha['numero']}'>EDITAR</a></td>
        <td><a href='ordem_servico.php?delete_numero={$linha['numero']}'>APAGAR</a></td>
    </tr>";
}
?>
</table>
</body>
</html>