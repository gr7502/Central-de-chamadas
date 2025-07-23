<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chamada de Senhas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <?php
  // Função para ajustar o brilho da cor
  function adjustBrightness($hex, $steps, $opacity = 1)
  {
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

  // Definindo a cor primária a partir do banco de dados
  $primary_color = isset($config->primary_color) ? $config->primary_color : '#6a11cb'; // Cor padrão
  $secondary_color = adjustBrightness($primary_color, 30); // Cor secundária mais clara
  $accent_color = adjustBrightness($primary_color, 50); // Cor de destaque mais clara
  $danger_color = '#ef4444'; // Cor de perigo fixa
  $text_color = '#2d3748'; // Cor de texto fixa
  $light_bg = '#f8fafc'; // Fundo claro fixo
  ?>

  <style>
    :root {
      --primary-color:
        <?php echo $primary_color; ?>
      ;
      --secondary-color:
        <?php echo $secondary_color; ?>
      ;
      --accent-color:
        <?php echo $accent_color; ?>
      ;
      --danger-color:
        <?php echo $danger_color; ?>
      ;
      --text-color:
        <?php echo $text_color; ?>
      ;
      --light-bg:
        <?php echo $light_bg; ?>
      ;
    }

    body {
      background: var(--light-bg);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .brand-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 1.5rem;
      border-radius: 0 0 20px 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      margin-bottom: 2rem;
      position: relative;
    }

    .btn-voltar {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }

    .btn-voltar:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-50%) scale(1.1);
    }

    .logo-container {
      padding: 15px 0;
    }

    .logo {
      transition: all 0.3s ease;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
      max-height: 90px;
      width: auto;
    }

    .panel {
      background: white;
      border-radius: 16px;
      box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
      transform: scale(1);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      border: none;
      overflow: hidden;
    }

    .panel:hover {
      transform: scale(1.02);
      z-index: 10;
    }

    .panel h3 {
      color: var(--primary-color);
      border-bottom: 2px solid
        <?php echo adjustBrightness($primary_color, 0, 0.1); ?>
      ;
      padding-bottom: 1rem;
      margin-bottom: 1.5rem;
      font-size: 1.5rem;
      font-weight: 700;
    }

    .btn-chamar {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 1rem 1.5rem;
      transition: all 0.3s;
      width: 100%;
    }

    .btn-finalizar {
      background: var(--danger-color);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1rem;
      padding: 0.8rem 1.2rem;
      transition: all 0.3s;
      width: 100%;
      margin-top: 1rem;
    }

    .btn-finalizar:hover {
      background: #dc2626;
      transform: scale(1.02);
    }

    .form-select {
      border-radius: 10px;
      padding: 1rem;
      border: 2px solid #e2e8f0;
      font-size: 1.1rem;
    }

    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 4px
        <?php echo adjustBrightness($primary_color, 0, 0.2); ?>
      ;
    }

    .chamada-atual {
      background: #f8f9fa;
      border-radius: 12px;
      border-left: 5px solid var(--primary-color);
      padding: 1.5rem;
      position: relative;
    }

    #filaSenhas {
      display: grid;
      gap: 1rem;
    }

    .senha-item {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      padding: 1.25rem;
      transition: all 0.3s;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-left: 4px solid var(--primary-color);
    }

    .senha-item.chamada-ativa {
      background:
        <?php echo adjustBrightness($primary_color, 0, 0.05); ?>
      ;
      border-left: 4px solid var(--accent-color);
    }

    .status-indicator {
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: #cbd5e0;
    }

    .chamada-ativa .status-indicator {
      background: var(--accent-color);
      box-shadow: 0 0 10px
        <?php echo adjustBrightness($accent_color, 0, 0.4); ?>
      ;
    }

    .text-xlarge {
      font-size: 2rem;
    }

    .feedback-message {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      animation: slideIn 0.5s forwards;
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }

      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @media (max-width: 768px) {
      .logo {
        max-height: 70px !important;
      }

      .panel h3 {
        font-size: 1.3rem;
      }

      .btn-chamar {
        font-size: 1rem;
        padding: 0.8rem;
      }

      .text-xlarge {
        font-size: 1.7rem;
      }

      .btn-voltar {
        width: 35px;
        height: 35px;
        left: 10px;
      }

      .senha-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #fff;
        border-radius: 8px;
        margin-bottom: .5rem;
      }

      .senha-item small {
        display: block;
      }

      .feedback-message {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        animation: slideIn .5s forwards;
      }

      @keyframes slideIn {
        from {
          transform: translateX(100%);
          opacity: 0
        }

        to {
          transform: translateX(0);
          opacity: 1
        }
      }
    }
  </style>
</head>

<body>
  <div class="brand-header">
    <a href="<?= base_url('Welcome') ?>" class="btn-voltar"><i class="bi bi-arrow-left"></i></a>
    <div class="container text-center logo-container">
      <img src="<?= base_url('assets/imagens/logo.png') ?>" class="logo" alt="Logo">
    </div>
  </div>

  <div class="container py-4">
    <h2 class="text-center display-5 mb-5" style="color: var(--primary-color)">CONTROLE DE ATENDIMENTO</h2>
    <div class="row g-4">
      <!-- Chamada de Senhas -->
      <div class="col-lg-6">
        <div class="panel p-4">
          <h3><i class="bi bi-ticket-detailed me-2"></i>CHAMADA DE SENHAS</h3>
          <select id="guiche" class="form-select mb-4">
            <option>Selecione o Guichê...</option>
            <option value="Guichê 01">Guichê 01</option>
            <option value="Guichê 02">Guichê 02</option>
            <option value="Guichê 03">Guichê 03</option>
            <option value="Guichê 04">Guichê 04</option>
            <option value="Guichê 05">Guichê 05</option>
          </select>
          <button onclick="chamar('senha')" class="btn-chamar mb-4">
            <i class="bi bi-arrow-down-circle me-2"></i>CHAMAR PRÓXIMA SENHA
          </button>
          <div class="chamada-atual">
            <p class="text-muted">SENHA ATUAL</p>
            <h4 id="senhaChamada" class="text-xlarge">---</h4>
            <span class="badge bg-primary" id="guicheChamada">--</span>
            <button id="btnFinalizarSenha" class="btn-finalizar mt-3" style="display:none;"
              onclick="finalizarAtendimento()">
              <i class="bi bi-x-circle me-2"></i>FINALIZAR ATENDIMENTO
            </button>
          </div>
        </div>
      </div>
      <!-- Chamada de Pacientes -->
      <div class="col-lg-6">
        <div class="panel p-4">
          <h3><i class="bi bi-person-heart me-2"></i>CHAMADA DE PACIENTES</h3>
          <select id="paciente" class="form-select mb-4">
            <option>Selecione o paciente...</option>
            <?php foreach ($pacientes as $p): ?>
              <option><?= htmlspecialchars($p->nome) ?></option>
            <?php endforeach; ?>
          </select>
          <select id="sala" class="form-select mb-4">
            <option>Selecione a sala...</option>
            <option>Consultório 01</option>
            <option>Consultório 02</option>
            <option>Consultório 03</option>
            <option>Consultório 04</option>
          </select>
          <button onclick="chamar('paciente')" class="btn-chamar">
            <i class="bi bi-megaphone me-2"></i>CHAMAR PACIENTE
          </button>
          <div class="chamada-atual mt-4">
            <p class="text-muted">PACIENTE CHAMADO</p>
            <h4 id="pacienteChamado" class="text-xlarge">---</h4>
            <p id="salaChamado" class="text-muted">---</p>
          </div>
        </div>
      </div>
      <!-- Senhas Retiradas & Últimos Chamados -->
      <div class="col-12">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="panel p-4 h-100">
              <h3><i class="bi bi-ticket-perforated me-2"></i>SENHAS RETIRADAS</h3>
              <div id="senhasRetiradas" class="mt-3">
                <p class="text-muted">Carregando...</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel p-4 h-100">
              <h3><i class="bi bi-clock-history me-2"></i>ÚLTIMOS CHAMADOS</h3>
              <div id="ultimosChamados" class="mt-3">
                <p class="text-muted">Carregando...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
let chamadasAtivas = [];
let senhaAtualId = null;
const BASE_URL = "<?php echo base_url('chamada2/'); ?>";

async function chamar(tipo) {
    const dados = { tipo };

    if (tipo === "senha") {
        const guicheField = document.getElementById('guiche');
        const guiche = guicheField ? guicheField.value.trim() : null;
        if (!guiche || guiche === "Selecione o Guichê...") {
            showFeedback('warning', "Selecione um guichê!");
            return;
        }
        dados.guiche = guiche;
    } else if (tipo === "paciente") {
        const pacienteField = document.getElementById('paciente');
        const salaField = document.getElementById('sala');
        const paciente = pacienteField ? pacienteField.value.trim() : null;
        const sala = salaField ? salaField.value.trim() : null;
        if (!paciente || paciente === "Selecione o paciente..." || !sala || sala === "Selecione a sala...") {
            showFeedback('warning', "Selecione um paciente e uma sala!");
            return;
        }
        dados.paciente = paciente;
        dados.sala = sala;
    }

    try {
        const response = await fetch(`${BASE_URL}processar_chamada`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=UTF-8",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error(`Erro na rede: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();

        if (data.status === "success") {
            showFeedback('success', 'Chamada realizada com sucesso!');
            if (tipo === "senha") {
                senhaAtualId = data.senha_id;
                document.getElementById('senhaChamada').textContent = data.senha || '---';
                document.getElementById('guicheChamada').textContent = data.guiche || '--';
                document.getElementById('btnFinalizarSenha').style.display = 'block';
            }
            await atualizarListas();
            await atualizarSenhasRetiradas();
            await atualizarUltimosChamados();
        } else {
            showFeedback('danger', 'Erro: ' + (data.message || "Falha ao enviar"));
        }
    } catch (error) {
        console.error("Erro:", error);
        showFeedback('danger', 'Erro de comunicação com o servidor');
    }
}

async function finalizarAtendimento() {
    if (!senhaAtualId || isNaN(senhaAtualId)) {
        showFeedback('warning', 'Nenhuma senha válida em atendimento para finalizar!');
        return;
    }

    if (!confirm("Deseja realmente finalizar este atendimento?")) {
        return;
    }

    const dados = {
        id: senhaAtualId,
        status: 'finalizada',
        motivo: 'atendimento_concluido'
    };

    console.log("Enviando dados para finalização:", dados);

    try {
        const response = await fetch(`${BASE_URL}finalizar_atendimento`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=UTF-8",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(dados)
        });

        console.log("Status da resposta HTTP:", response.status, response.statusText);
        if (!response.ok) {
            throw new Error(`Erro na rede: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();

        console.log("Resposta do servidor:", data);
        if (data.status === "success") {
            showFeedback('success', 'Atendimento finalizado com sucesso!');
            senhaAtualId = null;
            document.getElementById('senhaChamada').textContent = '---';
            document.getElementById('guicheChamada').textContent = '--';
            document.getElementById('btnFinalizarSenha').style.display = 'none';
            await atualizarListas();
            await atualizarSenhasRetiradas();
            await atualizarUltimosChamados();
        } else {
            showFeedback('danger', 'Erro ao finalizar: ' + (data.message || 'Falha ao atualizar o status'));
        }
    } catch (error) {
        console.error("Erro ao finalizar atendimento:", error);
        showFeedback('danger', 'Erro de comunicação com o servidor: ' + error.message);
    }
}

function formatarDuracao(ms) {
    const pad = n => String(n).padStart(2, '0');
    const seg = Math.floor(ms / 1000) % 60;
    const min = Math.floor(ms / 60000) % 60;
    const hr = Math.floor(ms / 3600000);
    return `${pad(hr)}:${pad(min)}:${pad(seg)}`;
}

async function atualizarSenhasRetiradas() {
    try {
        const response = await fetch(`${BASE_URL}senhas_pendentes`);
        const data = await response.json();

        if (data.status !== 'success') {
            throw new Error('Erro ao carregar senhas pendentes');
        }

        const arr = data.senhas || [];
        const container = document.getElementById('senhasRetiradas');

        if (!arr.length) {
            container.innerHTML = '<p class="text-muted">Nenhuma senha pendente.</p>';
            return;
        }

        const agora = new Date();
        container.innerHTML = arr.map(s => {
            const [h, m, sec] = (s.hora_entrada || '00:00:00').split(':').map(Number);
            const ent = new Date();
            ent.setHours(h, m, sec, 0);
            if (ent > agora) ent.setDate(ent.getDate() - 1);
            const espera = formatarDuracao(agora - ent);

            return `
                <div class="senha-item">
                    <div class="fw-bold">${s.senha}</div>
                    <small class="text-muted">Espera: ${espera}</small>
                </div>
            `;
        }).join('');
    } catch (error) {
        console.warn('Falha ao atualizar Senhas Retiradas:', error);
        document.getElementById('senhasRetiradas').innerHTML = '<p class="text-muted">Erro ao carregar.</p>';
    }
}

async function atualizarUltimosChamados() {
    try {
        const response = await fetch(`${BASE_URL}ultimas_chamadas`);
        const data = await response.json();

        if (data.status !== 'success') {
            throw new Error('Erro ao carregar últimos chamados');
        }

        const arr = data.ultimas_chamadas || [];
        const container = document.getElementById('ultimosChamados');

        if (!arr.length) {
            container.innerHTML = '<p class="text-muted">Nenhum chamado recente.</p>';
            return;
        }

        container.innerHTML = arr.map(s => {
            const data = new Date(s.data_entrada);
            const hora = data.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            return `
                <div class="senha-item">
                    <div class="fw-bold">${s.senha || s.paciente}</div>
                    <small class="text-muted">${s.guiche || s.sala} - ${hora}</small>
                </div>
            `;
        }).join('');
    } catch (error) {
        console.warn('Falha ao atualizar Últimos Chamados:', error);
        document.getElementById('ultimosChamados').innerHTML = '<p class="text-muted">Erro ao carregar.</p>';
    }
}

async function atualizarListas() {
    try {
        const response = await fetch(`${BASE_URL}ultimas_chamadas`);
        const data = await response.json();

        if (data.status === "success") {
            const ultimaSenha = data.ultimas_chamadas.find(c => c.tipo === 'senha') || null;
            if (ultimaSenha && ultimaSenha.senha_id) {
                senhaAtualId = ultimaSenha.senha_id;
                document.getElementById('senhaChamada').textContent = ultimaSenha.senha || '---';
                document.getElementById('guicheChamada').textContent = ultimaSenha.guiche || '--';
                document.getElementById('btnFinalizarSenha').style.display = 'block';
            } else {
                senhaAtualId = null;
                document.getElementById('senhaChamada').textContent = '---';
                document.getElementById('guicheChamada').textContent = '--';
                document.getElementById('btnFinalizarSenha').style.display = 'none';
            }

            const ultimoPaciente = data.ultimas_chamadas.find(c => c.tipo === 'paciente') || null;
            document.getElementById('pacienteChamado').textContent = ultimoPaciente?.paciente || '---';
            document.getElementById('salaChamado').textContent = ultimoPaciente?.sala || '---';

            const filaSenhas = document.getElementById('filaSenhas');
            if (filaSenhas) {
                filaSenhas.innerHTML = data.ultimas_chamadas
                    .filter(c => c.tipo === 'senha')
                    .map(s => `
                        <div class="senha-item ${s.senha_id === senhaAtualId ? 'chamada-ativa' : ''}">
                            <div class="d-flex align-items-center gap-3">
                                <div class="status-indicator"></div>
                                <div>
                                    <div class="fw-bold fs-5">${s.senha}</div>
                                    <small class="text-muted">Guichê ${s.guiche}</small>
                                </div>
                            </div>
                            <small class="text-muted">${new Date(s.data_entrada).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}</small>
                        </div>
                    `).join('');
            }
        } else {
            console.error("Erro na resposta de ultimas_chamadas:", data.message || "Sem mensagem");
        }
    } catch (error) {
        console.error("Erro ao atualizar listas:", error);
        showFeedback('warning', 'Erro ao atualizar a lista de atendimentos');
    }
}

function showFeedback(type, message) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} feedback-message`;
    alert.innerHTML = `
        <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>
        ${message}
    `;
    document.querySelectorAll('.feedback-message').forEach(el => el.remove());
    document.body.appendChild(alert);
    setTimeout(() => alert.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    atualizarListas();
    atualizarSenhasRetiradas();
    atualizarUltimosChamados();
    setInterval(() => {
        atualizarListas();
        atualizarSenhasRetiradas();
        atualizarUltimosChamados();
    }, 10000);
});
</script>
</body>

</html>