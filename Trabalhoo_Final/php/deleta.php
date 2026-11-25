<?php
session_start();

// Impede o acesso direto pela URL caso não seja administrador
if (!isset($_SESSION['adm']) || $_SESSION['adm'] != 1) {
    echo "<script>
            alert('Acesso negado! Recurso exclusivo para Administradores.');
            window.location.href = '../html/login.html';
          </script>";
    exit;
}

require_once(__DIR__ . "/conexao.php");

$mensagem = "Nenhum aluno informado.";
$ok = false;

$cod = isset($_GET['pk_codigo_aluno']) ? (int) $_GET['pk_codigo_aluno'] : 0;

if ($cod > 0) {
    $stmt = mysqli_prepare($conexao, "DELETE FROM aluno WHERE pk_codigo_aluno = ?");
    mysqli_stmt_bind_param($stmt, "i", $cod);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $ok = true;
        $mensagem = "Registro deletado com sucesso!";
    } else {
        $mensagem = "Registro não foi deletado (aluno não encontrado).";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Aluno - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Volta para a lista automaticamente -->
    <meta http-equiv="refresh" content="2;url=lista.php">
</head>

<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <h1>Aluno Deletado</h1>
            <p class="<?php echo $ok ? 'sucesso' : 'erro'; ?>"><?php echo $mensagem; ?></p>
            <p>Voltando para a lista...</p>
            <div class="botoes"><a class="botao" href="lista.php">Lista de Alunos</a></div>
        </div>
    </main>

</body>

</html>
