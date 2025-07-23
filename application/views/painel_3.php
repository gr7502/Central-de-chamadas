<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Chamadas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: <?php echo isset($config->primary_color) ? $config->primary_color : '#4f46e5'; ?>;
            --primary-light: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 20) : '#6366f1'; ?>;
            --primary-dark: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, -20) : '#4338ca'; ?>;
            --secondary: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #e2e8f0;
            --gray-dark: #94a3b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .panel {
            width: 95%;
            height: 95%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            position: relative;
            padding: 2%;
            overflow: hidden;
        }
        
        .current-call {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border-radius: 12px;
            padding: 3%;
            font-size: 4vw;
            font-weight: bold;
            height: 22%;
            margin-bottom: 2%;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            border: 2px solid rgba(255,255,255,0.2);
        }
        
        .call-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        
        .call-label {
            font-size: 1.8vw;
            margin-bottom: 1vh;
            font-weight: 500;
            opacity: 0.9;
        }
        
        .call-value {
            font-size: 5vw;
            font-weight: 700;
        }
        
        .divider {
            width: 2px;
            height: 80%;
            background: rgba(255,255,255,0.3);
            margin: 0 2%;
        }
        
        .recent-calls-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid var(--gray);
        }
        
        .section-header {
            padding: 1.5%;
            background: var(--primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-title {
            font-size: 2.5vw;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1vw;
        }
        
        .clock-header {
            font-size: 1.5vw;
            opacity: 0.8;
            background: rgba(255,255,255,0.1);
            padding: 0.5% 1.5%;
            border-radius: 8px;
        }
        
        .recent-calls {
            flex: 1;
            overflow-y: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: var(--primary);
            color: white;
            padding: 1.5%;
            text-align: center;
            font-weight: 500;
            font-size: 2vw;
            position: sticky;
            top: 0;
        }
        
        td {
            padding: 1.5%;
            text-align: center;
            border-bottom: 1px solid var(--gray);
            font-weight: 500;
            font-size: 2vw;
        }
        
        tr:nth-child(even) {
            background: rgba(241, 245, 249, 0.5);
        }
        
        .logo-container {
            position: absolute;
            bottom: 2%;
            left: 50%;
            transform: translateX(-50%);
            height: 10%;
            display: flex;
            align-items: center;
        }
        
        .logo-container img {
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        .media-container {
            position: absolute;
            top: 2%;
            left: 2%;
            width: 15%;
            height: 12%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .media-container img,
        .media-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        @keyframes pulse {
            0%, 100% { 
                transform: scale(1); 
                box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            }
            50% { 
                transform: scale(1.02); 
                box-shadow: 0 12px 30px rgba(79, 70, 229, 0.4);
            }
        }
        
        .pulse {
            animation: pulse 0.6s ease-in-out 3;
        }
        
        @media (max-width: 768px) {
            .panel {
                width: 100%;
                height: 100%;
                border-radius: 0;
                padding: 3%;
            }
            
            .current-call {
                flex-direction: column;
                height: auto;
                padding: 5%;
                font-size: 6vw;
            }
            
            .divider {
                width: 80%;
                height: 2px;
                margin: 2% 0;
            }
            
            .call-label {
                font-size: 3.5vw;
            }
            
            .call-value {
                font-size: 8vw;
            }
            
            .section-title {
                font-size: 4vw;
            }
            
            .clock-header {
                font-size: 3vw;
                padding: 1% 3%;
            }
            
            th, td {
                font-size: 3.5vw;
                padding: 3%;
            }
        }
    </style>
</head>
<body>
    <div class="panel">
        <!-- Current Call -->
        <div class="current-call" id="chamada">
            <div class="call-info">
                <div class="call-label">Senha</div>
                <div class="call-value" id="senhaAtual">---</div>
            </div>
            <div class="divider"></div>
            <div class="call-info">
                <div class="call-label">Destino</div>
                <div class="call-value" id="guicheAtual">---</div>
            </div>
        </div>

        <!-- Recent Calls -->
        <div class="recent-calls-container">
            <div class="section-header">
                <div class="section-title">Últimos Chamados</div>
                <div id="relogio" class="clock-header"></div>
            </div>
            <div class="recent-calls">
                <table>
                    <thead>
                        <tr><th>Senha</th><th>Destino</th></tr>
                    </thead>
                    <tbody id="listaChamadas">
                        <tr><td colspan="2">Carregando chamadas...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Logo -->
        <div class="logo-container">
            <img src="<?= base_url('assets/imagens/gees.png') ?>" alt="Logo">
        </div>
    </div>

    <script>
        // Clock functionality
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'});
            const dateStr = now.toLocaleDateString('pt-BR', {weekday: 'short', day: 'numeric', month: 'short'});
            document.getElementById('relogio').textContent = `${timeStr} • ${dateStr}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Main application logic
        const CHECK_INTERVAL = 5000;
        let isChecking = false;
        let lastSpokenMessage = '';

        async function checkQueue() {
            if (isChecking) return;
            isChecking = true;
            
            try {
                const res = await fetch('<?= site_url('chamada2/get_proxima_chamada') ?>');
                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                
                const data = await res.json();
                
                if (data.status === 'success' && data.mensagem !== lastSpokenMessage) {
                    await displayAndAnnounceCall(data);
                    lastSpokenMessage = data.mensagem;
                }
            } catch (error) {
                console.error('Queue check failed:', error);
                document.getElementById('senhaAtual').textContent = 'Erro';
                document.getElementById('guicheAtual').textContent = 'Erro';
            } finally {
                isChecking = false;
            }
        }

        async function displayAndAnnounceCall(data) {
            const passwordEl = document.getElementById('senhaAtual');
            const destinationEl = document.getElementById('guicheAtual');
            const callElement = document.getElementById('chamada');

            // Update display
            if (data.tipo === 'senha') {
                passwordEl.textContent = data.senha || '---';
                destinationEl.textContent = data.guiche || '---';
            } else {
                passwordEl.textContent = data.paciente || '---';
                destinationEl.textContent = data.consultorio || '---';
            }

            // Visual feedback
            callElement.classList.remove('pulse');
            void callElement.offsetWidth; // Trigger reflow
            callElement.classList.add('pulse');
            
            try {
                await playAlertSound();
                await speakText(data.mensagem);
                
                if (data.fila_id) {
                    await fetch(`<?= site_url('chamada2/marcar_como_falada/') ?>${data.fila_id}`);
                }
            } catch (error) {
                console.error('Announcement flow failed:', error);
            } finally {
                updateRecentCalls();
            }
        }

        async function updateRecentCalls() {
            try {
                const res = await fetch('<?= site_url('chamada2/get_ultimas_chamadas') ?>');
                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                
                const data = await res.json();
                const tbody = document.getElementById('listaChamadas');
                
                if (data.status === 'success' && data.chamadas.length) {
                    tbody.innerHTML = '';
                    data.chamadas.slice(0, 10).forEach(ch => {
                        const password = ch.tipo === 'senha' ? ch.senha : ch.paciente;
                        const destination = ch.tipo === 'senha' ? ch.guiche : ch.sala;
                        
                        const row = `<tr>
                            <td>${password || '---'}</td>
                            <td>${destination || '---'}</td>
                        </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                } else if (tbody.children.length === 1 && tbody.children[0].colSpan === 2) {
                    tbody.innerHTML = '<tr><td colspan="2">Nenhuma chamada recente</td></tr>';
                }
            } catch (error) {
                console.error('Failed to update recent calls:', error);
                document.getElementById('listaChamadas').innerHTML = 
                    '<tr><td colspan="2">Erro ao carregar</td></tr>';
            }
        }

        function playAlertSound() {
            return new Promise(resolve => {
                const audio = new Audio('<?= base_url('assets/sounds/alert.mp3') ?>');
                audio.volume = 0.7;
                audio.onended = resolve;
                audio.onerror = resolve;
                audio.play().catch(e => console.error('Audio play failed:', e));
            });
        }

        function speakText(message) {
            return new Promise(resolve => {
                if (!window.speechSynthesis) return resolve();
                
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(message);
                utterance.lang = 'pt-BR';
                utterance.rate = 0.9;
                utterance.pitch = 1;
                utterance.onend = resolve;
                utterance.onerror = resolve;
                
                window.speechSynthesis.speak(utterance);
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            checkQueue();
            updateRecentCalls();
            setInterval(checkQueue, CHECK_INTERVAL);
            setInterval(updateRecentCalls, CHECK_INTERVAL * 2);
            
            // Preload alert sound
            new Audio('<?= base_url('assets/sounds/alert.mp3') ?>').load();
        });
    </script>

<?php
function adjustBrightness($hex, $steps) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    return '#' . sprintf("%02x%02x%02x", $r, $g, $b);
}
?>
</body>
</html>