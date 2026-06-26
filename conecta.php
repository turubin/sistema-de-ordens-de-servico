<?php
try {
    $nome_banco = '';
    $conexao = new PDO('sqlite:'. $nome_banco);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>