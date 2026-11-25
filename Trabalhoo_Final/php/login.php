<?php
// Inicia a sessão ANTES de qualquer envio de HTML para o navegador
session_start();
require_once(__DIR__ . "/conexao.php");

$mensagem = "";
$sucesso  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Busca o aluno pelo e-mail (consulta preparada)
    $stmt = mysqli_prepare($conexao, "SELECT pk_codigo_aluno, nome, senha, adm FROM aluno WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $aluno = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$aluno) {
        $mensagem = "Erro: E-mail não encontrado!";
    } else {
        $senhaOk = password_verify($senha, $aluno['senha']);

        // Compatibilidade com senhas antigas salvas em texto puro: se bater,
        // converte a senha para hash automaticamente.
        if (!$senhaOk && hash_equals($aluno['senha'], $senha)) {
            $senhaOk = true;
            $novoHash = ($senha);
            $up = mysqli_prepare($conexao, "UPDATE aluno SET senha = ? WHERE pk_codigo_aluno = ?");
            mysqli_stmt_bind_param($up, "si", $novoHash, $aluno['pk_codigo_aluno']);
            mysqli_stmt_execute($up);
            mysqli_stmt_close($up);
        }

        if ($senhaOk) {
            session_regenerate_id(true);
            $_SESSION['id']   = $aluno['pk_codigo_aluno'];
            $_SESSION['nome'] = $aluno['nome'];
            $_SESSION['adm']  = (int) $aluno['adm']; // 1 = Administrador, 0 = Aluno
            $sucesso  = true;
            $mensagem = "Bem-vindo(a), " . htmlspecialchars($aluno['nome']) . "! Login realizado como <strong>"
                      . ($_SESSION['adm'] == 1 ? "Administrador" : "Aluno") . "</strong>.";
        } else {
            $mensagem = "Erro: Senha incorreta!";
        }
    }
    mysqli_close($conexao);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include "rodape.php"; ?>
<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <?php if ($mensagem !== ""): ?>
                <p class="<?php echo $sucesso ? 'sucesso' : 'erro'; ?>"><?php echo $mensagem; ?></p>
            <?php else: ?>
                <p>Nenhum dado recebido. Use o formulário de login.</p>
            <?php endif; ?>

            <div class="botoes">
                <?php if ($sucesso): ?>
                    <a class="botao" href="lista.php">Ir para a Lista de Alunos</a>
                <?php else: ?>
                    <a class="botao" href="../html/login.html">Tentar novamente</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>
