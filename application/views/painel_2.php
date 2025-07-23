<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Chamadas</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --cor-primaria: <?php echo isset($config->primary_color) ? $config->primary_color : '#6a5acd'; ?>;
      --cor-primaria-transparente: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 0, 0.9) : 'rgba(106, 90, 205, 0.9)'; ?>;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f4f4f4;
      display: flex;
      height: 100vh;
      width: 100vw;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      display: flex;
      width: 100%;
      height: 100%;
      background: white;
      position: relative;
    }

    .chamada {
        flex: 2;
        background: var(--cor-primaria);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        font-weight: bold;
        text-align: center;
        padding: 20px;
        max-width: 72%;
    }

    .chamada span {
      font-size: 4vw;
    }

    @keyframes piscar {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .chamada.piscando {
        animation: piscar 0.5s ease-in-out 3;
        transform: translateZ(0); /* Força renderização por hardware */
    }

    .logo-container {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      width: 100%;
    }

    .logo-container img {
      max-width: 250px;
      height: auto;
    }

    .config-media {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 250px;
      height: auto;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      object-fit: contain; /* Garante que o conteúdo se ajuste sem distorção */
    }

    .config-media video {
      width: 250px;
      height: auto;
    }

    .relogio {
      position: absolute;
      bottom: 10px;
      right: 8px;
      font-size: 1.2vw;
      font-weight: bold;
      color: white;
      background: var(--cor-primaria-transparente);
      padding: 15px;
      border-radius: 10px;
      text-align: center;
    }

    .ultimos-chamados {
        flex: 1;
        background: white;
        padding: 20px;
        overflow-y: auto;
        min-width: 200px;
    }

    .titulo {
      text-align: center;
      font-size: 2vw;
      font-weight: bold;
      margin-bottom: 15px;
      color: var(--cor-primaria);
    }

    .chamado-card {
      border-left: 5px solid var(--cor-primaria);
      padding: 20px;
      margin-bottom: 15px;
      background: #fff;
      border-radius: 5px;
      font-size: 1.5vw;
    }

    .sem-chamadas {
      text-align: center;
      padding: 20px;
      color: #666;
    }

    .sem-chamadas img {
      opacity: 0.5;
      margin-bottom: 10px;
    }

    .sem-chamadas p {
      font-style: italic;
      font-size: 1.5vw;
      justify-items: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if (isset($config->image_url) && !empty($config->image_url)): ?>
      <?php
        // Determina o tipo de arquivo com base na extensão
        $ext = strtolower(pathinfo($config->image_url, PATHINFO_EXTENSION));
        $isVideo = in_array($ext, ['mp4', 'webm']);
      ?>
      <?php if ($isVideo): ?>
        <video src="<?php echo htmlspecialchars($config->image_url); ?>" class="config-media" autoplay loop muted playsinline>
          <source src="<?php echo htmlspecialchars($config->image_url); ?>" type="video/<?php echo $ext; ?>">
          Seu navegador não suporta vídeos.
        </video>
      <?php else: ?>
        <img src="<?php echo htmlspecialchars($config->image_url); ?>" alt="Imagem Configurada" class="config-media">
      <?php endif; ?>
    <?php endif; ?>

    <div class="logo-container">
      <img src="<?php echo base_url('assets/imagens/Senha.png'); ?>" alt="Logo RedHat logo">
    </div>

    <div class="chamada">
      <div id="mensagemSenha">
        <span>Última chamada:</span> <br>
        <strong id="senhaChamada">Carregando...</strong>
      </div>
    </div>

    <div id="ultimos-chamados" class="ultimos-chamados">
      <?php if (!empty($ultimasChamadas)): ?>
        <?php foreach ($ultimasChamadas as $chamada): ?>
          <div class="chamado-card">
            <div class="info">
              <span class="fw-bold">
                <?= $chamada['tipo'] === 'senha' ? 'SENHA' : 'PACIENTE' ?>
              </span>
              <span class="numero"><?= $chamada['tipo'] === 'senha' ? $chamada['senha'] : $chamada['paciente'] ?></span>
            </div>
            <div class="destino">
              <span><?= $chamada['tipo'] === 'senha' ? $chamada['guiche'] : $chamada['sala'] ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div id="sem-chamadas" class="sem-chamadas">
          <p class="fw-bold">Nenhuma chamada recente.</p>
        </div>
      <?php endif;?>
    </div>

    <div class="relogio-container">
      <div id="relogio" class="relogio"></div>
    </div>
  </div>

  <script src="<?php echo base_url('assets/js/relogio.js'); ?>"></script>
  <script>
    let filaAtiva = false;
    const intervaloVerificacao = 8000;

    async function verificarFila() {
        if (filaAtiva) return;
        filaAtiva = true;

        try {
            const response = await fetch("<?= site_url('chamada2/get_proxima_chamada') ?>");
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            if (data.status === "success") {
                await exibirEfalarChamada(data);
            }
        } catch (error) {
            console.error("Erro na verificação da fila:", error); 
        } finally {
            filaAtiva = false;
        }
    }

    async function exibirEfalarChamada(data) {
        const chamadaElement = document.querySelector('.chamada');
        const senhaChamadaElement = document.getElementById("senhaChamada");

        // Atualiza o texto da última chamada na interface
        senhaChamadaElement.innerText = data.mensagem;
        
        // Adiciona a classe para piscar
        console.log('Adicionando classe piscando');
        chamadaElement.classList.add('piscando');

        try {
            // Toca o som de alerta antes de falar a mensagem
            await tocarSomAlerta();
            // Fala a mensagem após o som
            await falarTexto(data.mensagem);
            // Aguarda um tempo adicional para garantir que a animação complete
            await new Promise(resolve => setTimeout(resolve, 1500));
            // Marca a chamada como falada
            if (data.fila_id) {
                await marcarComoFalada(data.fila_id);
            }
        } catch (error) {
            console.error("Erro no fluxo de chamada:", error);
        } finally {
            // Remove a classe após o término
            console.log('Removendo classe piscando');
            chamadaElement.classList.remove('piscando');
            // Atualiza a lista de últimos chamados ao final do processo
            await atualizarUltimosChamados();
        }
    }

    async function atualizarUltimosChamados() {
        try {
            const response = await fetch("<?= site_url('chamada2/get_ultimas_chamadas') ?>");
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            const container = document.getElementById('ultimos-chamados');
            container.innerHTML = ''; // Limpa a lista atual

            if (data.status === "success" && data.chamadas && data.chamadas.length > 0) {
                // Limita aos últimos 7 chamados
                const ultimosSete = data.chamadas.slice(0, 7);
                ultimosSete.forEach(chamada => {
                    const novoChamado = document.createElement('div');
                    novoChamado.className = 'chamado-card';
                    novoChamado.innerHTML = `
                        <div class="info">
                            <span class="fw-bold">${chamada.tipo.toUpperCase()}</span>
                            <span class="numero">${chamada.senha || chamada.paciente}</span>
                        </div>
                        <div class="destino">
                            <span>${chamada.guiche || chamada.sala}</span>
                        </div>
                    `;
                    container.appendChild(novoChamado);
                });
            } else {
                container.innerHTML = `
                    <div id="sem-chamadas" class="sem-chamadas">
                        <p class="fw-bold">Nenhuma chamada recente.</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error("Erro ao atualizar últimos chamados:", error);
        }
    }

    async function marcarComoFalada(filaId) {
        try {
            await fetch(`<?= site_url('chamada2/marcar_como_falada/') ?>${filaId}`);
        } catch (error) {
            console.error("Erro ao marcar como falada:", error);
        }
    }

    function tocarSomAlerta() {
        return new Promise((resolve) => {
            const audio = new Audio("<?= base_url('assets/sounds/alert.mp3') ?>");
            audio.volume = 0.8;

            audio.onended = resolve;
            audio.onerror = (err) => {
                console.error("Erro ao tocar o som de alerta:", err);
                resolve();
            };
            audio.play();
        });
    }

    function falarTexto(texto) {
        return new Promise((resolve) => {
            if (!window.speechSynthesis) {
                console.warn("Síntese de voz não suportada");
                return resolve();
            }

            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'pt-BR';
            utterance.rate = 1.0;
            utterance.pitch = 1.0;

            utterance.onend = resolve;
            utterance.onerror = (err) => {
                console.error("Erro na fala:", err);
                resolve();
            };

            window.speechSynthesis.speak(utterance);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setInterval(verificarFila, intervaloVerificacao);
        verificarFila();
    });
  </script>
</body>
</html>

<?php
function adjustBrightness($hex, $steps, $opacity = 1) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    if ($opacity < 1) {
        return "rgba($r, $g, $b, $opacity)";
    }
    return '#' . sprintf("%02x%02x%02x", $r, $g, $b);
}
?>