<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - Pokémon CO</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .loja {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 24px;
        }

        /* Cartões um ao lado do outro */
        .produtos {
            flex: 1;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 16px;
        }

        .produto {
            width: 140px;
            background-color: #fff;
            border: 1px solid #333;
            border-radius: 4px;
            padding: 12px;
            text-align: center;
        }

        .produto:hover {
            background-color: #FFE4C4;
        }

        /* Imagem em cima do nome, pequena */
        .produto img {
            display: block;
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin: 0 auto 8px;
        }

        .produto h4 {
            font-family: "pok", Arial, sans-serif;
            margin-bottom: 4px;
        }

        /* Carrinho ao lado dos cartões */
        .carrinho {
            width: 300px;
            flex-shrink: 0;
            background-color: #fff;
            border: 1px solid #333;
            border-radius: 4px;
            padding: 16px;
        }

        .carrinho h3 {
            font-family: "pok", Arial, sans-serif;
            margin-bottom: 10px;
        }

        .carrinho ul {
            list-style: none;
            margin-bottom: 10px;
        }

        .carrinho li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #ddd;
        }

        .qtd button {
            width: 26px;
            cursor: pointer;
        }

        #total {
            font-weight: bold;
            margin: 10px 0;
        }

        @media (max-width: 800px) {
            .loja { flex-direction: column; }
            .carrinho { width: 100%; }
        }
    </style>
</head>
<?php include "rodape.php"; ?>
<body>
    <header class="cabecalho">
    
    <?php include(__DIR__ . "/menu.php"); ?>

    </header>

    <main class="conteudo">

        <h2>Comprar Pokemons!!!</h2>

        <div class="loja">
            <div class="produtos" id="produtos"></div>

            <aside class="carrinho">
                <h3>Seu carrinho</h3>
                <ul id="lista-carrinho"></ul>
                <p id="total">Total: R$ 0,00</p>
                <div class="botoes">
                    <button class="botao" onclick="finalizar()">Finalizar compra</button>
                    <button class="botao" onclick="limpar()">Limpar</button>
                </div>
                <div id="mensagem"></div>
            </aside>
        </div>

    </main>

    <script>
        const pokemons = [
            { id: 133, nome: "Eevee",      preco: 50 },
            { id: 25,  nome: "Pikachu",    preco: 80 },
            { id: 4,   nome: "Charmander", preco: 60 },
            { id: 7,   nome: "Squirtle",   preco: 60 },
            { id: 1,   nome: "Bulbasaur",  preco: 60 },
            { id: 39,  nome: "Jigglypuff", preco: 45 },
            { id: 143, nome: "Snorlax",    preco: 90 },
            { id: 94,  nome: "Gengar",     preco: 85 }
        ];

        const imagem = id =>
            `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${id}.png`;

        const formatar = valor =>
            valor.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });

        let carrinho = JSON.parse(localStorage.getItem("carrinho")) || {};

        document.getElementById("produtos").innerHTML = pokemons.map(p => `
            <div class="produto">
                <img src="${imagem(p.id)}" alt="${p.nome}"
                     onerror="this.onerror=null; this.src='../img/eevee.png'">
                <h4>${p.nome}</h4>
                <p>${formatar(p.preco)}</p>
                <button class="botao" onclick="mudar(${p.id}, 1)">Adicionar</button>
            </div>`).join("");

        function mudar(id, delta) {
            carrinho[id] = (carrinho[id] || 0) + delta;
            if (carrinho[id] <= 0) delete carrinho[id];
            atualizar();
        }

        function limpar() {
            carrinho = {};
            atualizar();
        }

        function totalCompra() {
            return Object.entries(carrinho).reduce((soma, [id, qtd]) => {
                const p = pokemons.find(x => x.id == id);
                return soma + p.preco * qtd;
            }, 0);
        }

        function atualizar() {
            localStorage.setItem("carrinho", JSON.stringify(carrinho));
            const ids = Object.keys(carrinho);

            document.getElementById("lista-carrinho").innerHTML = ids.length === 0
                ? "<li>Nenhum Pokémon no carrinho.</li>"
                : ids.map(id => {
                    const p = pokemons.find(x => x.id == id);
                    const qtd = carrinho[id];
                    return `
                        <li>
                            <span>${p.nome} - ${formatar(p.preco * qtd)}</span>
                            <span class="qtd">
                                <button onclick="mudar(${p.id}, -1)">-</button>
                                ${qtd}
                                <button onclick="mudar(${p.id}, 1)">+</button>
                            </span>
                        </li>`;
                }).join("");

            document.getElementById("total").textContent = "Total: " + formatar(totalCompra());
        }

        function finalizar() {
            const msg = document.getElementById("mensagem");
            if (Object.keys(carrinho).length === 0) {
                msg.innerHTML = '<p class="erro">Seu carrinho está vazio!</p>';
                return;
            }
            const total = totalCompra();
            limpar();
            msg.innerHTML = `<p class="sucesso">Compra finalizada! Total: ${formatar(total)}</p>`;
        }

        atualizar();
    </script>
</body>

</html>