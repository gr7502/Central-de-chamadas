<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Chamadas</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --cor-primaria: <?php echo isset($config->primary_color) ? $config->primary_color : '#1e90ff'; ?>;
            --cor-primaria-transparente: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 0, 0.8) : 'rgba(30, 144, 255, 0.8)'; ?>;
            --cor-primaria-light: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 50) : '#87cefa'; ?>;
            --cor-borda-aside: rgba(90, 90, 90, 0.6);
            --cor-espaco-divs: rgba(120, 120, 120, 0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', Arial, sans-serif;
            background: #E3E9EB;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
        }

        .container {
            width: 100%; height: 100%; display: flex; position: relative; gap: 20px;
        }

        aside {
            width: 30%;
            background: var(--cor-primaria);
            backdrop-filter: blur(10px);
            border-right: 3px solid var(--cor-borda-aside);
            display: flex; flex-direction: column;
            padding: 50px; gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .logo-interna {
            height: 20%; display: flex; justify-content: center; align-items: center;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            border: 1px solid var(--cor-primaria-transparente);
        }

        .logo-interna img { 
            max-width: 80%;
            max-height: 80%; 
            object-fit: contain; 
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.3)); }

        .logo-interna img:hover { filter: drop-shadow(0 2px 5px rgba(0,0,0,0.5)); }

        .ultimas-chamadas {
            flex:1; display:flex; flex-direction:column;
            background: var(--cor-primaria-transparente);
            border-radius:10px; padding:15px;
            color:#fff !important;
        }
        .ultimas-chamadas h2 { 
            text-align:center; 
            font-size:2.4rem; 
            margin-bottom:1rem; }
        .lista-chamadas li { 
            display:flex; 
            justify-content:space-between; 
            align-items:center;
            padding:1rem 1.5rem; 
            margin:0.5rem 0;
            background: var(--cor-primaria-transparente);
            border-radius:8px; border-left:4px solid var(--cor-primaria);
            transition: all 0.3s ease; box-shadow:0 2px 4px rgba(0,0,0,0.1);
        }
        .lista-chamadas li:hover {
            transform:translateX(5px);
            background: var(--cor-primaria-light);
        }
        .lista-chamadas li span:first-child { 
            font-size:2rem; 
            font-weight:600; }
        .lista-chamadas li span:last-child {
            background:rgba(255,255,255,0.1); 
            padding:0.4rem 1rem; 
            border-radius:20px; 
            font-size:1.6rem;
        }

        .main-content {
            flex:1; display:flex; flex-direction:column;
            padding:10px; gap:0;
        }
        .main-content > div { margin:5px 0; }

        .header-chamada {
            height:40%;
            background: var(--cor-primaria);
            backdrop-filter: blur(10px);
            color:white;
            display:flex; flex-direction:column; justify-content:center; align-items:center;
            border-radius:15px;
            padding:20px;
            border:1px solid var(--cor-primaria-transparente);
            box-shadow:0 4px 15px rgba(0,0,0,0.5);
        }
        .header-chamada h2 { 
            font-size:3.6vw; 
            font-weight:700; 
            text-transform:uppercase; 
            margin-bottom:2%; }
        .chamada { 
            display:flex; 
            justify-content:center; 
            gap:3vw; 
            font-size:3vw; 
            font-weight:bold; }

        .media-container {
            flex:1; display:flex; justify-content:center; align-items:center;
            background: var(--cor-primaria);
            border-radius:15px;
            border:1px solid var(--cor-primaria-transparente);
            box-shadow:0 4px 15px rgba(0,0,0,0.2);
            padding:20px;
        }

        .config-media { max-width:90%; max-height:90%; border-radius:10px; object-fit:contain; }
        .config-media video { max-width:90%; max-height:90%; }

        .relogio { position:absolute; bottom:20px; left:5%; font-size:1vw; font-weight:bold;
            color:white; background: var(--cor-primaria-transparente);
            padding:10px 15px; border-radius:10px;
            box-shadow:0 0 15px var(--cor-primaria);
            border:2px solid var(--cor-primaria);
        }
    </style>
</head>
<body>
    <div class="container">
        <aside>
            <div class="logo-interna">
                <img src="<?php echo base_url('assets/imagens/Senha.png'); ?>" alt="Logo Interna">
            </div>
            <div class="ultimas-chamadas">
                <h2>Últimas Chamadas</h2>
                <ul id="listaChamadas" class="lista-chamadas"></ul>
            </div>
        </aside>

        <div class="main-content">
            <div class="header-chamada">
                <h2>Última Chamada</h2>
                <div class="chamada" id="chamada">
                    <div id="senhaAtual"> - - -</div>
                    <div id="guicheAtual"> - - -</div>
                </div>
            </div>
            <div class="media-container">
                <?php if (isset($config->image_url) && !empty($config->image_url)): ?>
                    <?php
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
                <?php else: ?>
                    <p>Media não configurada</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="relogio-container">
            <div id="relogio" class="relogio"></div>
        </div>
    </div>

    <script src="<?php echo base_url('assets/js/relogio.js'); ?>"></script>
    <script>
        let filaAtiva = false;
        let ultimaMensagemFalada = "";
        const intervaloVerificacao = 5000;

        async function verificarFila() {
            if (filaAtiva) return;
            filaAtiva = true;
            try {
                const response = await fetch("<?php echo site_url('chamada2/get_proxima_chamada'); ?>");
                if (!response.ok) throw new Error(`Erro HTTP! Status: ${response.status}`);
                const data = await response.json();
                console.log("Resposta de get_proxima_chamada:", data);
                if (data.status === "success" && data.mensagem !== ultimaMensagemFalada) {
                    await exibirEfalarChamada(data);
                    ultimaMensagemFalada = data.mensagem;
                }
            } catch (error) {
                console.error("Erro na verificação da fila:", error);
                document.getElementById("senhaAtual").innerText = "Erro";
                document.getElementById("guicheAtual").innerText = "Erro";
            } finally {
                filaAtiva = false;
            }
        }

        async function exibirEfalarChamada(data) {
            const chamadaElement = document.getElementById("chamada");
            const senhaAtualElement = document.getElementById("senhaAtual");
            const guicheAtualElement = document.getElementById("guicheAtual");
            const handleError = (message) => {
                console.error(message, data);
                senhaAtualElement.innerText = "Erro: Dados incompletos";
                guicheAtualElement.innerText = "Erro: Dados incompletos";
            };
            try {
                if (!data?.dados) { handleError("Estrutura de dados inválida:"); return; }
                const { tipo, dados } = data;
                const camposRequeridos = { senha: ['senha','guiche'], paciente: ['paciente','sala'] };
                if (!camposRequeridos[tipo]?.every(c => dados[c])) {
                    handleError(`Faltando campos obrigatórios para ${tipo}:`);
                    return;
                }
                senhaAtualElement.innerText = dados[camposRequeridos[tipo][0]];
                guicheAtualElement.innerText = dados[camposRequeridos[tipo][1]];
                chamadaElement.classList.add('piscando');
                try {
                    await tocarSomAlerta();
                    await falarTexto(data.mensagem);
                    if (data.fila_id) await marcarComoFalada(data.fila_id);
                } catch (err) {
                    console.error("Erro no fluxo de chamada:", err);
                } finally {
                    setTimeout(() => chamadaElement.classList.remove('piscando'), 1500);
                    await atualizarUltimasChamadas();
                }
            } catch (err) {
                console.error("Erro ao exibir chamada:", err);
            }
        }

        async function atualizarUltimasChamadas() {
            try {
                const response = await fetch("<?php echo site_url('chamada2/get_ultimas_chamadas'); ?>");
                if (!response.ok) throw new Error(`Erro HTTP! Status: ${response.status}`);
                const data = await response.json();
                const lista = document.getElementById('listaChamadas');
                lista.innerHTML = '';
                if (data.status === "success" && data.chamadas?.length) {
                    data.chamadas.slice(0,7).forEach(ch => {
                        const codigo = ch.tipo==='senha'?ch.senha:ch.paciente;
                        const destino= ch.tipo==='senha'?ch.guiche:ch.sala;
                        lista.innerHTML += `
                            <li class="chamada-item">
                                <span class="chamada-codigo">${codigo||'Erro'}</span>
                                <span class="chamada-destino">${destino||'Erro'}</span>
                            </li>`;
                    });
                } else {
                    lista.innerHTML = '<li>Nenhuma chamada recente</li>';
                }
            } catch (err) {
                console.error("Erro ao atualizar últimos chamados:", err);
                document.getElementById('listaChamadas').innerHTML = '<li>Erro ao carregar chamadas</li>';
            }
        }

        async function marcarComoFalada(filaId) {
            try {
                await fetch(`<?php echo site_url('chamada2/marcar_como_falada/'); ?>${filaId}`);
            } catch (err) {
                console.error("Erro ao marcar como falada:", err);
            }
        }

        function tocarSomAlerta() {
            return new Promise(resolve => {
                const audio = new Audio("<?php echo base_url('assets/sounds/alert.mp3'); ?>");
                audio.volume = 0.8;
                audio.onended = resolve;
                audio.onerror = () => resolve();
                audio.play();
            });
        }

        function falarTexto(texto) {
            return new Promise(resolve => {
                if (!window.speechSynthesis) return resolve();
                window.speechSynthesis.cancel();
                const u = new SpeechSynthesisUtterance(texto);
                u.lang = 'pt-BR'; u.rate = 1.0; u.pitch = 1.0;
                u.onend = resolve; u.onerror = () => resolve();
                window.speechSynthesis.speak(u);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            verificarFila();
            atualizarUltimasChamadas();
            setInterval(verificarFila, intervaloVerificacao);
            setInterval(atualizarUltimasChamadas, intervaloVerificacao);
        });
    </script>
</body>
</html>

<?php
function adjustBrightness($hex, $steps, $opacity = 1) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $steps));
    $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $steps));
    $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $steps));
    if ($opacity < 1) {
        return "rgba($r, $g, $b, $opacity)";
    }
    return '#' . sprintf("%02x%02x%02x", $r, $g, $b);
}
?>
