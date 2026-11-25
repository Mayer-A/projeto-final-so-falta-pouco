<?php
session_start();
require_once(__DIR__ . "/conexao.php");

// Verifica se o usuário logado é Administrador (adm = 1)
$isAdmin = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/menu.php"); ?>

    <main class="conteudo">
        <div>
            <h1>Lista de Alunos Cadastrados</h1>

            <?php
            $resultado = mysqli_query($conexao, "SELECT * FROM aluno ORDER BY pk_codigo_aluno");

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                echo "<div class='tabela-rolagem'><table>";
                echo "<tr><th>Código</th><th>Nome</th><th>Sobrenome</th><th>Idade</th><th>E-mail</th>";
                if ($isAdmin) {
                    echo "<th>Alterar</th><th>Excluir</th>";
                }
                echo "</tr>";

                while ($linha = mysqli_fetch_assoc($resultado)) {
                    $id = (int) $linha['pk_codigo_aluno'];
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['sobrenome']) . "</td>";
                    echo "<td>" . (int) $linha['idade'] . "</td>";
                    echo "<td>" . htmlspecialchars($linha['email']) . "</td>";

                    if ($isAdmin) {
                        echo "<td><a href='edita.php?pk_codigo_aluno=$id'>Alterar</a></td>";
                        echo "<td><a href='deleta.php?pk_codigo_aluno=$id' onclick=\"return confirm('Excluir este aluno?');\">Excluir</a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table></div>";
            } else {
                echo "<p>Nenhum aluno encontrado no banco de dados.</p>";
            }

            mysqli_close($conexao);
            ?>
        </div>
    </main>
    <?php include("rodape.php"); ?>
</body>

</html>