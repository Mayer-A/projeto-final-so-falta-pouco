<?php
session_start();

// Impede o acesso direto pela URL caso o usuário não seja administrador
if (!isset($_SESSION['adm']) || $_SESSION['adm'] != 1) {
    echo "<script>
            alert('Acesso negado! Recurso exclusivo para Administradores.');
            window.location.href = '../html/login.html';
          </script>";
    exit;
}

require_once(__DIR__ . "/conexao.php");

$mensagem  = "";
$ok        = false;
$redirecionar = false;

$cod       = (int) ($_POST['pk_codigo_aluno'] ?? 0);
$nome      = trim($_POST['nome'] ?? '');
$sobrenome = trim($_POST['sobrenome'] ?? '');
$idade     = (int) ($_POST['idade'] ?? 0);
$email     = trim($_POST['email'] ?? '');

if ($cod > 0 && $nome !== '' && $sobrenome !== '' && $idade > 0 && $email !== '') {
    $stmt = mysqli_prepare($conexao, "UPDATE aluno SET nome = ?, sobrenome = ?, idade = ?, email = ? WHERE pk_codigo_aluno = ?");
    mysqli_stmt_bind_param($stmt, "ssisi", $nome, $sobrenome, $idade, $email, $cod);

    try {
        mysqli_stmt_execute($stmt);
        $ok = true;
        $redirecionar = true;
        $mensagem = "Registro atualizado com sucesso!";
    } catch (mysqli_sql_exception $e) {
        $mensagem = $e->getCode() === 1062
            ? "Este e-mail já pertence a outro aluno."
            : "Erro ao atualizar registro: " . htmlspecialchars($e->getMessage());
    }
    mysqli_stmt_close($stmt);
} else {
    $mensagem = "Opss! Tente novamente preenchendo todos os campos!";
}
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno Editado - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php if ($redirecionar): ?>
        <meta http-equiv="refresh" content="3;url=lista.php">
    <?php endif; ?>
</head>

<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <h1>Aluno Editado</h1>
            <p class="<?php echo $ok ? 'sucesso' : 'erro'; ?>"><?php echo $mensagem; ?></p>
            <div class="botoes"><a class="botao" href="lista.php">Lista de Alunos</a></div>
        </div>
    </main>
</body>

</html>
