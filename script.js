// Mostrar ou esconder o texto dos botoes "Leia mais"
const botoes = document.querySelectorAll(".botao-leia");

botoes.forEach(function(botao) {
    botao.addEventListener("click", function() {
        const texto = botao.previousElementSibling;

        if (texto.style.display === "block") {
            texto.style.display = "none";
            botao.textContent = "Leia mais";
        } else {
            texto.style.display = "block";
            botao.textContent = "Mostrar menos";
        }
    });
});

// Pesquisar noticias pelo titulo
const campo = document.querySelector("#campoPesquisa");
const pesquisar = document.querySelector("#btnPesquisar");

if (campo && pesquisar) {
    pesquisar.addEventListener("click", function() {
        const palavra = campo.value.toLowerCase();
        const cards = document.querySelectorAll("#listaNoticias .card");
        let quantidade = 0;

        cards.forEach(function(card) {
            const titulo = card.querySelector("h3").textContent.toLowerCase();

            if (titulo.includes(palavra)) {
                card.style.display = "block";
                quantidade++;
            } else {
                card.style.display = "none";
            }
        });

        const aviso = document.querySelector("#semResultado");
        if (quantidade === 0) {
            aviso.textContent = "Nenhum resultado encontrado.";
        } else {
            aviso.textContent = "";
        }
    });
}

// Verificar os campos do formulario
const formulario = document.querySelector("#formContato");

if (formulario) {
    formulario.addEventListener("submit", function(event) {
        event.preventDefault();
        alert("Mensagem enviada com sucesso!");
        formulario.reset();
    });
}
