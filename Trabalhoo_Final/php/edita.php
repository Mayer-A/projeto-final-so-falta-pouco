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

$aluno = null;
$cod = isset($_REQUEST['pk_codigo_aluno']) ? (int) $_REQUEST['pk_codigo_aluno'] : 0;

if ($cod > 0) {
    $stmt = mysqli_prepare($conexao, "SELECT pk_codigo_aluno, nome, sobrenome, idade, email FROM aluno WHERE pk_codigo_aluno = ?");
    mysqli_stmt_bind_param($stmt, "i", $cod);
    mysqli_stmt_execute($stmt);
    $aluno = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <?php if (!$aluno): ?>
                <p class="erro">Aluno não encontrado.</p>
                <div class="botoes"><a class="botao" href="lista.php">Lista de Alunos</a></div>
            <?php else: ?>
                <form name="cadastro" action="edita_ok.php" method="POST">
                    <h2>Formulário de Edição de Aluno</h2>

                    <!-- Campo oculto transportando a chave primária -->
                    <input type="hidden" name="pk_codigo_aluno" value="<?php echo (int) $aluno['pk_codigo_aluno']; ?>">

                    <div class="grupo">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" maxlength="20" autofocus required>
                    </div>

                    <div class="grupo">
                        <label for="sobrenome">Sobrenome:</label>
                        <input type="text" id="sobrenome" name="sobrenome" value="<?php echo htmlspecialchars($aluno['sobrenome']); ?>" maxlength="20" required>
                    </div>

                    <div class="grupo">
                        <label for="idade">Idade:</label>
                        <input type="number" id="idade" name="idade" value="<?php echo (int) $aluno['idade']; ?>" min="1" required>
                    </div>

                    <div class="grupo">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($aluno['email']); ?>" maxlength="50" required>
                    </div>

                    <div class="botoes">
                        <input type="submit" value="Salvar Alterações">
                        <input type="reset" value="Limpar">
                        <a class="botao secundario" href="lista.php">Lista de Alunos</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
