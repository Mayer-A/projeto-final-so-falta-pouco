<?php
// php/menu.php - Cabeçalho + menu usados por todas as páginas PHP
// (os caminhos são relativos à pasta php/)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
?>
<header class="cabecalho">
    <img src="../img/eevee.png" alt="Eevee" class="logo">

    <nav class="menu">
        <a href="../index.php">Home</a>
        <a href="../html/cadastro_aluno.html">Cadastro</a>
        <a href="lista.php">Lista</a>
        <a href="comprar.php">Compra</a>
        <?php if ($nomeUsuario !== ''): ?>
            <a href="logout.php">Logout (<?php echo htmlspecialchars($nomeUsuario); ?>)</a>
        <?php else: ?>
            <a href="../html/login.html">Login</a>
        <?php endif; ?>
    </nav>
</header>
