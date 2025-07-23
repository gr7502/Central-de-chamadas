let filaAtiva = false;
const intervaloVerificacao = 10000;

/**
 * Verifica a fila de chamadas e busca a próxima chamada
 */

/**
 * Atualiza a exibição no painel com a mensagem recebida e a reproduz via síntese de voz
 * @param {object} data - Dados retornados pelo endpoint, contendo "mensagem" e "fila_id"
 */
function exibirEfalarChamada(data) {
    // Atualiza o texto da chamada na tela do painel
    document.getElementById("senhaChamada").innerText = data.mensagem;

    // Reproduz a mensagem usando síntese de voz
    falarTexto(data.mensagem)
        .then(() => {
            // Após a reprodução, marca a chamada como finalizada
            return fetch(`<?php echo site_url('chamada2/marcar_como_falada/'); ?>${data.fila_id}`);
        })
        .then(response => response.json())
        .then(result => {
            // Aguarda um breve intervalo e verifica a próxima chamada
            setTimeout(() => {
                filaAtiva = false;
                verificarFila();
            }, 1000);
        })
        .catch(error => {
            console.error("Erro na finalização da chamada:", error);
            filaAtiva = false;
            verificarFila();
        });
}

/**
 * Função que utiliza a síntese de voz para falar um texto
 * @param {string} texto - Texto a ser reproduzido
 * @returns {Promise}
 */
function falarTexto(texto) {
    return new Promise((resolve) => {
        if (!('speechSynthesis' in window)) {
            console.warn("Síntese de voz não suportada");
            resolve();
            return;
        }
        const utterance = new SpeechSynthesisUtterance(texto);
        utterance.lang = 'pt-BR';
        utterance.rate = 1.0;
        utterance.onend = utterance.onerror = () => {
            resolve();
        };
        window.speechSynthesis.speak(utterance);
    });
}

// Inicia a verificação da fila assim que a página do painel carregar
document.addEventListener('DOMContentLoaded', () => {
    verificarFila();
    setInterval(verificarFila, intervaloVerificacao);
});