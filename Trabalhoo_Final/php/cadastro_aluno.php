<?php
require_once(__DIR__ . "/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include "rodape.php"; ?>

<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = trim($_POST['nome'] ?? '');
                $sobrenome = trim($_POST['sobrenome'] ?? '');
                $idade = (int) ($_POST['idade'] ?? 0);
                $email = trim($_POST['email'] ?? '');
                $senhaPura = $_POST['senha'] ?? '';

                if ($nome === '' || $sobrenome === '' || $idade <= 0 || $email === '' || $senhaPura === '') {
                    echo "<p class='erro'>Preencha todos os campos.</p>";
                } else {
                    // Criptografa a senha antes de salvar
                    $senha = ($senhaPura);

                    // Consulta preparada (protege contra SQL Injection); 'adm' assume o DEFAULT 0
                    $sql = "INSERT INTO aluno (nome, sobrenome, idade, email, senha) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conexao, $sql);
                    mysqli_stmt_bind_param($stmt, "ssiss", $nome, $sobrenome, $idade, $email, $senha);

                    try {
                        mysqli_stmt_execute($stmt);
                        echo "<p class='sucesso'>Aluno cadastrado com sucesso!</p>";
                    } catch (mysqli_sql_exception $e) {
                        if ($e->getCode() === 1062) {
                            echo "<p class='erro'>Este e-mail já está cadastrado.</p>";
                        } else {
                            echo "<p class='erro'>Erro ao cadastrar aluno: " . htmlspecialchars($e->getMessage()) . "</p>";
                        }
                    }
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($conexao);
            } else {
                echo "<p>Nenhum dado recebido. Use o formulário de cadastro.</p>";
            }
            ?>
            <div class="botoes">
                <a class="botao" href="lista.php">Lista de Alunos</a>
                <a class="botao secundario" href="../html/cadastro_aluno.html">Novo cadastro</a>
            </div>
        </div>
    </main>
    <?php include("rodape.php"); ?>
</body>

</html>