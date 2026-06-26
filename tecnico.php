<?php
include "conecta.php";

$matricula = $nome = $endereco = $telefone = $nivel = "";

// Criar técnico
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['tecnico_matricula'])) {
    $stmt = $conexao->prepare("
        INSERT INTO tecnico (tecnico_matricula, nome, endereco, telefone, nivel_escolaridade)
        VALUES (:matricula, :nome, :endereco, :telefone, :nivel)
    ");
    $stmt->execute([
        ':matricula' => $_POST['campo_matricula'],
        ':nome' => $_POST['campo_nome'],
        ':endereco' => $_POST['campo_endereco'],
        ':telefone' => $_POST['campo_telefone'],
        ':nivel' => $_POST['campo_nivel']
    ]);
    header("Location: tecnico.php");
    exit;
}

// Atualizar técnico
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['tecnico_matricula'])) {
    $stmt = $conexao->prepare("
        UPDATE tecnico SET nome=:nome, endereco=:endereco, telefone=:telefone, nivel_escolaridade=:nivel
        WHERE tecnico_matricula=:matricula
    ");
    $stmt->execute([
        ':nome' => $_POST['campo_nome'],
        ':endereco' => $_POST['campo_endereco'],
        ':telefone' => $_POST['campo_telefone'],
        ':nivel' => $_POST['campo_nivel'],
        ':matricula' => $_POST['campo_matricula']
    ]);
    header("Location: tecnico.php");
    exit;
}

// Excluir técnico
if (isset($_GET['delete_matricula'])) {
    $stmt = $conexao->prepare("DELETE FROM tecnico WHERE tecnico_matricula = :matricula");
    $stmt->execute([':matricula' => $_GET['delete_matricula']]);
    header("Location: tecnico.php");
    exit;
}

// Editar técnico
if (isset($_GET['tecnico_matricula'])) {
    $stmt = $conexao->prepare("
        SELECT tecnico_matricula AS matricula, nome, endereco, telefone, nivel_escolaridade AS nivel
        FROM tecnico
        WHERE tecnico_matricula = :matricula
    ");
    $stmt->execute([':matricula' => $_GET['tecnico_matricula']]);
    $dado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($dado) extract($dado);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Técnicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="m-5">
    <a href="index.php" class="btn btn-outline-primary m-3"">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
<h1>Técnicos</h1>
<form method="POST" action="<?= isset($_GET['tecnico_matricula']) ? 'tecnico.php?tecnico_matricula=' . $_GET['tecnico_matricula'] : 'tecnico.php' ?>">
    <div><label>Matrícula</label>
        <input class="form-control" name="campo_matricula" <?= isset($_GET['tecnico_matricula']) ? 'readonly' : '' ?> required value="<?= htmlspecialchars($matricula) ?>">
    </div>
    <div><label>Nome</label>
        <input class="form-control" name="campo_nome" required value="<?= htmlspecialchars($nome) ?>">
    </div>
    <div><label>Endereço</label>
        <input class="form-control" name="campo_endereco" required value="<?= htmlspecialchars($endereco) ?>">
    </div>
    <div><label>Telefone</label>
        <input class="form-control" name="campo_telefone" required value="<?= htmlspecialchars($telefone) ?>">
    </div>
    <div><label>Nível de Escolaridade</label>
        <input class="form-control" name="campo_nivel" required value="<?= htmlspecialchars($nivel) ?>">
    </div>
    <div><input class="btn btn-primary m-2" type="submit" value="Salvar"></div>
</form>

<h2>Lista de Técnicos</h2>
<table class="table">
<tr><th>Matrícula</th><th>Nome</th><th>Endereço</th><th>Telefone</th><th>Escolaridade</th><th>Editar</th><th>Apagar</th></tr>
<?php
$stmt = $conexao->query("SELECT * FROM tecnico ORDER BY nome");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $linha) {
    echo "<tr>
        <td>{$linha['tecnico_matricula']}</td>
        <td>{$linha['nome']}</td>
        <td>{$linha['endereco']}</td>
        <td>{$linha['telefone']}</td>
        <td>{$linha['nivel_escolaridade']}</td>
        <td><a href='tecnico.php?tecnico_matricula={$linha['tecnico_matricula']}'>EDITAR</a></td>
        <td><a href='tecnico.php?delete_matricula={$linha['tecnico_matricula']}'>APAGAR</a></td>
    </tr>";
}
?>
</table>
</body>
</html>
