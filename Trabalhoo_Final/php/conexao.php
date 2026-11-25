<?php
// php/conexao.php - Arquivo de conexão centralizado
$SERVIDOR   = "localhost";
$USUARIO    = "root";
$SENHA      = "";           // Senha padrão do XAMPP é vazia
$NOME_BANCO = "aluno";

// Faz o MySQLi lançar exceções (permite tratar erros com try/catch)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexao = mysqli_connect($SERVIDOR, $USUARIO, $SENHA, $NOME_BANCO);
    mysqli_set_charset($conexao, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Erro ao conectar com a base de dados: " . htmlspecialchars($e->getMessage()));
}
