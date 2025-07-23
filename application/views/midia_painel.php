<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mídia Painel</title>
    <!-- Adicione seu CSS ou framework aqui -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
 <!--Sidebar-->
 <div class="sidebar">
        <div class="logo_container text-center mb-4">
            <img src="<?php echo base_url('assets/imagens/logo.png'); ?>" class="logo" alt="Logo">
        </div>
        <h3 class="ms-3 text-center">Painel</h3>

        <!-- Botão Home -->
        <a href="<?= base_url('welcome/index'); ?>" class="btn btn-home w-100 text-start px-3">
            <i class="bi bi-house-door-fill me-2"></i> Home
        </a>

        <!-- Menu de Pacientes -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPacientes"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-file-person-fill me-2"></i> Pacientes <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuPacientes">
            <a href="<?= base_url('paciente/index'); ?>" class="d-block ms-4"><i class="bi bi-person-circle me-2"></i>
                Todos os pacientes</a>
            <a href="<?= base_url('paciente/create_paciente'); ?>" class="d-block ms-4"><i
                    class="bi bi-person-fill-add me-2"></i> Adicionar pacientes</a>
        </div>

        <!-- Menu Senhas -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuSenhas"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-file-binary-fill me-2"></i> Senhas <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuSenhas">
            <a href="<?= base_url('tiposSenhas/index'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-binary-fill me-2"></i> Tipos de senhas</a>
            <a href="<?= base_url('tiposSenhas/criar'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-diff-fill me-2"></i> Adicionar senhas</a>
            <a href="<?= base_url('senhas/gerar'); ?>" class="d-block ms-4"><i class="bi bi-key-fill me-2"></i> Gerar
                Senhas</a>
        </div>

        <!-- Menu Painel -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPainel"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-card-heading"> </i> Painel <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuPainel">
            <a href="<?= base_url('chamada/index'); ?>" class="d-block ms-4"><i class="bi bi-layers-fill"></i> Chamar
                senha</a>
            <a href="<?= base_url('painel/index'); ?>" class="d-block ms-4"><i class="bi bi-dash-square-fill"></i>
                Painel</a>
        </div>

        <!-- Menu Configurações -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuConfiguracoes"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-card-heading"> </i> Configurações <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuConfiguracoes">
            <a href="<?= base_url('configuracoes/midiaPainel'); ?>" class="d-block ms-4"><i class="bi bi-layers-fill"></i> Chamar
                senha</a>
            <a href="<?= base_url('painel/index'); ?>" class="d-block ms-4"><i class="bi bi-dash-square-fill"></i>
                Painel</a>
        </div>
    </div>

<<div class="container">
    <h1 class="mt-4">Midia do painel</h1>
    <?php if (!empty($midias)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($midias as $mid): ?>
                    <tr>
                        <td><?php echo $mid->nome; ?></td>
                        <td>
                            <a href="<?php echo base_url('configuracoes/editarmidia/' . $tps->id); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
                            <a href="<?php echo base_url('configuracoes/delete_paciente/' . $tps->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum Tipo encontrado.</p>
    <?php endif; ?>
</div>

<!-- Botão flutuante para adicionar paciente -->
<a href="<?php echo base_url('configuracoes/criarmidia'); ?>" class="btn btn-floating">
    <i class="fas fa-plus"></i>
</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
