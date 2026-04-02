<div class="sidebar">
    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Recolher menu">
        <i class="bi bi-layout-sidebar-inset-reverse"></i>
    </button>

    <div class="logo_container text-center mb-4">
        <img src="<?= base_url('assets/imagens/logo.png'); ?>" class="logo" alt="Logo">
    </div>

    <h3 class="text-center">Painel</h3>

    <a href="<?= base_url('welcome/index'); ?>" class="btn-home menu-link">
        <i class="bi bi-house-door-fill me-2"></i><span class="menu-text">Home</span>
    </a>

    <div class="menu-group">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPacientes" aria-expanded="false" class="collapse-menu menu-link">
            <i class="bi bi-file-person-fill me-2"></i><span class="menu-text">Pacientes</span>
            <i class="fas fa-chevron-down float-end menu-caret"></i>
        </a>
        <div class="collapse submenu" id="menuPacientes">
            <a href="<?= base_url('paciente/index'); ?>" class="d-block ms-4">
                <i class="bi bi-person-circle me-2"></i><span>Todos os pacientes</span>
            </a>
            <!-- <a href="<?= base_url('paciente/create_paciente'); ?>" class="d-block ms-4">
                <i class="bi bi-person-fill-add me-2"></i><span>Adicionar pacientes</span>
            </a> -->
        </div>
    </div>

    <div class="menu-group">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuSenhas" aria-expanded="false" class="collapse-menu menu-link">
            <i class="bi bi-file-binary-fill me-2"></i><span class="menu-text">Senhas</span>
            <i class="fas fa-chevron-down float-end menu-caret"></i>
        </a>
        <div class="collapse submenu" id="menuSenhas">
            <a href="<?= base_url('tiposSenhas/index'); ?>" class="d-block ms-4">
                <i class="bi bi-file-earmark-binary-fill me-2"></i><span>Tipos de senhas</span>
            </a>
            <!-- <a href="<?= base_url('tiposSenhas/criar'); ?>" class="d-block ms-4">
                <i class="bi bi-file-earmark-diff-fill me-2"></i><span>Adicionar senhas</span>
            </a> -->
            <a href="<?= base_url('senhas/gerar'); ?>" class="d-block ms-4">
                <i class="bi bi-key-fill me-2"></i><span>Gerar Senhas</span>
            </a>
        </div>
    </div>

    <div class="menu-group">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPainel" aria-expanded="false" class="collapse-menu menu-link">
            <i class="bi bi-card-heading me-2"></i><span class="menu-text">Painel</span>
            <i class="fas fa-chevron-down float-end menu-caret"></i>
        </a>
        <div class="collapse submenu" id="menuPainel">
            <a href="<?= base_url('chamada/index'); ?>" class="d-block ms-4">
                <i class="bi bi-layers-fill me-2"></i><span>Chamar senha</span>
            </a>
            <a href="<?= base_url('configuration/' . (isset($panel_view) ? $panel_view : 'painel')); ?>" class="d-block ms-4">
                <i class="bi bi-dash-square-fill me-2"></i><span>Painel</span>
            </a>
        </div>
    </div>

    <div class="menu-group">
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuConfiguracoes" aria-expanded="false" class="collapse-menu menu-link">
            <i class="bi bi-gear-fill me-2"></i><span class="menu-text">Configurações</span>
            <i class="fas fa-chevron-down float-end menu-caret"></i>
        </a>
        <div class="collapse submenu" id="menuConfiguracoes">
            <a href="<?= base_url('configuration/index'); ?>" class="d-block ms-4">
                <i class="bi bi-sliders me-2"></i><span>Config Painel</span>
            </a>
            <!-- <a href="<?= base_url('painel/index'); ?>" class="d-block ms-4">
                <i class="bi bi-sliders2 me-2"></i><span>Config Senhas</span>
            </a> -->
        </div>
    </div>
</div>
