<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Chamadas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --cor-primaria: <?php echo isset($config->primary_color) ? $config->primary_color : '#0047AB'; ?>;
      --cor-primaria-hover: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, -20) : '#003580'; ?>;
      --cor-primaria-transparente: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 0, 0.1) : 'rgba(0, 71, 171, 0.1)'; ?>;
      --cor-secundaria: #ffffff;
      --cor-texto: #2d2d2d;
      --cor-texto-secundario: #6c757d;
      --sombra: 0 4px 24px rgba(0, 0, 0, 0.08);
      --borda-radius: 16px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background: #f8f9fa;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      overflow: hidden; /* Bloqueia rolagem vertical e horizontal */
      color: var(--cor-texto);
    }

    /* Header Moderno */
    .info-consulta-header {
      background: linear-gradient(135deg, var(--cor-primaria), var(--cor-primaria-hover));
      color: white;
      padding: 1.5rem 0;
      text-align: center;
      box-shadow: 0 4px 24px rgba(0, 71, 171, 0.2);
      position: relative;
      overflow: hidden;
    }

    .info-consulta-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: rgba(255, 255, 255, 0.15);
    }

    #mensagemSenha {
      font-size: 2.5rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin: 0.5rem 0;
    }

    #senhaChamada {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(4px);
      padding: 1rem 2rem;
      border-radius: var(--borda-radius);
      border: 2px solid rgba(255, 255, 255, 0.3);
      display: inline-block;
      transition: all 0.3s ease;
      font-size: 3rem; /* Aumentado de 2.5rem para 3rem */
    }

    /* Layout Principal */
    .main-container {
      flex: 1;
      padding: 1.5rem 0; /* Reduzido padding lateral para 0 */
    }

    .content-wrapper {
      display: flex;
      flex-direction: row;
      width: 100%; /* Ocupa toda a largura do dispositivo */
      margin: 0; /* Remove margens para ocupar toda a largura */
    }

    /* Seção de Mídia */
    .container-midia {
      width: 65%; /* Ocupa 65% da largura */
      background: var(--cor-secundaria);
      border-radius: var(--borda-radius);
      box-shadow: var(--sombra);
      overflow: hidden;
      min-width: 0; /* Remove min-width fixo para ocupar proporção */
      height: calc(100vh - 220px); /* Igual à altura do aside */
      display: flex; /* Para centralização vertical */
      align-items: center; /* Centraliza verticalmente */
      justify-content: center; /* Centraliza horizontalmente */
      transition: transform 0.3s ease;
    }

    .container-midia:hover {
      transform: translateY(-2px);
    }

    .container-midia img,
    .container-midia video {
      width: 100%; /* Ocupa toda a largura do container */
      min-width: 0; /* Remove min-width fixo */
      max-height: 100%; /* Limita altura à do container */
      height: auto; /* Mantém proporção */
      object-fit: contain; /* Exibe mídia completamente sem cortes */
      border-radius: var(--borda-radius);
    }

    /* Lista de Chamados */
    aside {
      width: 35%; /* Ocupa o restante (35%) */
      background: var(--cor-secundaria);
      border-radius: var(--borda-radius);
      box-shadow: var(--sombra);
      padding: 2rem;
      border-left: 4px solid var(--cor-primaria);
      height: calc(100vh - 220px); /* Altura fixa */
      overflow-y: auto; /* Rolagem interna apenas para o aside */
      display: flex;
      flex-direction: column;
    }

    aside h2 {
      color: var(--cor-primaria);
      font-size: 1.5rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--cor-primaria-transparente);
    }

    .chamado-card {
      background: rgba(245, 245, 245, 0.9);
      padding: 1.25rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      border: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .chamado-card:hover {
      transform: translateX(8px);
      box-shadow: var(--sombra);
      border-color: var(--cor-primaria-transparente);
    }

    .chamado-card:nth-child(odd) {
      background: rgba(0, 71, 171, 0.03);
    }

    .info, .destino {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.5rem;
      font-size: 1.6rem;
    }

    .fw-bold {
      color: var(--cor-primaria);
      font-weight: 600;
      font-size: 1.3rem; /* Aumentado de 1.1rem para 1.3rem */
    }

    .numero {
      font-size: 1.7rem; 
      font-weight: 500;
      color: var(--cor-primaria);
    }

    .sem-chamadas {
      text-align: center;
      padding: 1rem;
      color: var(--cor-texto-secundario);
    }

    /* Estilização do Relógio */
    .relogio-container {
      margin-top: auto; /* Empurra o relógio para o final do aside */
      padding: 1rem;
      background: rgba(245, 245, 245, 0.9);
      border-radius: var(--borda-radius);
      border: 1px solid var(--cor-primaria-transparente);
      box-shadow: var(--sombra);
      text-align: center;
    }

    .relogio {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--cor-primaria);
      letter-spacing: 1px;
      padding: 0.5rem 1rem;
      background: var(--cor-secundaria);
      border-radius: 8px;
      border: 2px solid var(--cor-primaria);
      display: inline-block;
      transition: all 0.3s ease;
    }

    .relogio:hover {
      background: var(--cor-primaria);
      color: var(--cor-secundaria);
      border-color: var(--cor-primaria-hover);
    }

    /* Footer Estilizado */
    .footer {
      background: var(--cor-texto);
      color: rgba(255, 255, 255, 0.9);
      padding: 1rem;
      text-align: center;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(4px);
    }

    .footer strong {
      color: var(--cor-primaria);
      font-weight: 500;
    }

    /* Animações */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.02); }
      100% { transform: scale(1); }
    }

    .info-consulta-header.piscando {
      animation: pulse 0.6s ease-in-out;
    }

    /* Responsividade */
    @media (max-width: 1600px) {
      .content-wrapper {
        flex-direction: column;
      }

      .container-midia {
        width: 100%; 
        min-width: 0; 
        min-height: 400px; 
        height: auto; 
        display: block; 
      }

      .container-midia img,
      .container-midia video {
        min-width: 0;
        max-height: 400px; 
        height: auto;
      }

      aside {
        width: 100%; /* Ocupa largura total */
        height: auto; /* Altura automática */
      }
    }

    @media (max-width: 768px) {
      #mensagemSenha {
        font-size: 1.8rem;
      }

      .container-midia {
        min-height: 300px; 
        min-width: 0;
      }

      .container-midia img,
      .container-midia video {
        min-width: 0;
        max-height: 300px; /* Ajusta altura máxima */
        height: auto;
      }

      .chamado-card {
        padding: 1rem;
      }

      .fw-bold {
        font-size: 1.2rem; /* Ajuste proporcional para telas menores */
      }

      .numero {
        font-size: 1.5rem; /* Ajuste proporcional para telas menores */
        color: var(--cor-primaria );
      }

      #senhaChamada {
        font-size: 2.5rem; /* Ajuste proporcional para telas menores */
      }

      .relogio {
        font-size: 1.1rem;
        padding: 0.4rem 0.8rem;
      }
    }

    @media (max-width: 480px) {
      #mensagemSenha {
        font-size: 1.4rem;
      }

      #senhaChamada {
        padding: 0.75rem 1.5rem;
        font-size: 2rem; /* Ajuste proporcional para telas menores */
      }

      .container-midia {
        min-height: 200px; /* Altura mínima para telas pequenas */
        min-width: 0;
      }

      .container-midia img,
      .container-midia video {
        min-width: 0;
        max-height: 200px; /* Ajusta altura máxima */
        height: auto;
      }

      .fw-bold {
        font-size: 1.1rem; /* Ajuste proporcional para telas menores */
      }

      .numero {
        font-size: 1.5rem;
        color: var(--cor-primaria); 
      }

      .relogio {
        font-size: 1rem;
        padding: 0.3rem 0.6rem;
      }
    }
  </style>
</head>

<body>
  <header class="info-consulta-header">
    <div class="container">
      <div id="mensagemSenha">
        <strong id="senhaChamada">Carregando...</strong>
      </div>
    </div>
  </header>

  <div class="main-container">
    <div class="content-wrapper">
      <div class="container-midia">
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
      </div>

      <aside>
        <h2 class"text-center">ÚLTIMOS CHAMADOS</h2>
        <div id="ultimos-chamados">
          <?php if (!empty($ultimasChamadas)): ?>
            <?php foreach ($ultimasChamadas as $index => $chamada): ?>
              <div class="chamado-card">
                <div class="info">
                  <span class="numero"><?= $chamada[$chamada['tipo'] === 'senha' ? 'senha' : 'paciente'] ?></span>
                </div>
                <div class="destino">
                  <strong><?= $chamada[$chamada['tipo'] === 'senha' ? 'guiche' : 'sala'] ?></strong>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="sem-chamadas">
              <p class="fw-bold">Nenhuma chamada recente.</p>
            </div>
          <?php endif; ?>
        </div>
        <div class="relogio-container">
          <div id="relogio" class="relogio"></div>
        </div>
      </aside>
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
            document.getElementById("senhaChamada").innerText = "Erro ao carregar";
        } finally {
            filaAtiva = false;
        }
    }

    async function exibirEfalarChamada(data) {
        const chamadaElement = document.querySelector('.info-consulta-header');
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
                // Limita aos últimos 5 chamados
                const ultimosCinco = data.chamadas.slice(0, 4);
                  ultimosCinco.forEach(chamada => {
                      const novoChamado = document.createElement('div');
                      novoChamado.className = 'chamado-card';
                      novoChamado.innerHTML = `
                          <div class="info">
                              <span class="numero">${chamada.senha || chamada.paciente}</span>
                          </div>
                          <div class="destino">
                              <strong><span>${chamada.guiche || chamada.sala}</span></strong>
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
            if (!window.speechSynthesis || !window.speechSynthesis.speak) {
                console.warn("Síntese de voz não suportada ou desativada no navegador.");
                return resolve();
            }

            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'pt-BR';
            utterance.rate = 1.0;
            utterance.pitch = 1.0;
            utterance.volume = 1.0; // Ajuste de volume máximo

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