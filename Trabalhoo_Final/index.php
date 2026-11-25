<?php
// php/menu.php - Cabeçalho + menu usados por todas as páginas PHP
// (os caminhos são relativos à pasta php/)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon CO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<?php include "php/rodape.php"; ?>
<body>
    <header class="cabecalho">

        <img src="img/eevee.png" alt="Eevee" class="logo">

        
    <nav class="menu">
        <a href="index.php">Home</a>
        <a href="html/cadastro_aluno.html">Cadastro</a>
        <a href="php/lista.php">Lista</a>
        <a href="php/comprar.php">Compra</a>

        <?php if ($nomeUsuario !== ''): ?>
            <a href="php/login.php">Logout (<?php echo htmlspecialchars($nomeUsuario); ?>)</a>
        <?php else: ?>
            <a href="php/logout.php">Login</a>
        <?php endif; ?>
    </nav>

    </header>

    <main class="conteudo">

        <div class="text">
            <h1>Bem-vindo à Pokémon CO</h1>
            <p>
                <img src="img/abra.png" alt="abra" class="abra">
                Pokémon, abreviação de Pocket Monsters (Monstros de Bolso), é uma das franquias de entretenimento mais
                famosas e duradouras do mundo. Criada no Japão na década de 1990, a marca começou como um jogo de
                videogame e logo se expandiu para cartas colecionáveis, séries de televisão, filmes, brinquedos e
                roupas, conquistando gerações de fãs ao redor do globo.
                O conceito central gira em torno de humanos, conhecidos como Treinadores Pokémon, que viajam pelo mundo
                para capturar essas criaturas fantásticas usando esferas chamadas Pokébolas. Cada Pokémon possui
                habilidades, tipos (como Fogo, Água, Planta e Elétrico) e características únicas.
            </p>

        </div>

    </main>
</body>

</html>