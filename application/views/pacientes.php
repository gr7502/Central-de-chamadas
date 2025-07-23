<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
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

    $primary_color = isset($config->primary_color) ? $config->primary_color : '#4f46e5';
    $secondary_color = adjustBrightness($primary_color, 30);
    $accent_color = adjustBrightness($primary_color, 50);
    $text_color = '#1f2937';
    $light_bg = '#f8fafc';
    $shadow_color = 'rgba(0, 0, 0, 0.1)';
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
            --text-color:
                <?php echo $text_color; ?>
            ;
            --light-bg:
                <?php echo $light_bg; ?>
            ;
            --shadow-color:
                <?php echo $shadow_color; ?>
            ;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--light-bg);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1.5rem 1rem;
            box-shadow: 2px 0 10px var(--shadow-color);
            transition: width 0.3s ease;
            z-index: 1000;
        }

        .sidebar .logo_container {
            margin-bottom: 2rem;
        }

        .sidebar .logo {
            max-height: 80px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .sidebar h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            margin-bottom: 2rem;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            font-size: 1rem;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .container {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 2rem;
            max-width: 1400px;
            transition: all 0.3s ease;
        }

        h1 {
            font-size: 3rem;
            font-weight: 600;
            color: var(--text-color);
            text-align: center;
            margin-bottom: 2.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeIn 0.5s ease-in-out;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
        }

        .btn:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3rem;
            background: white;
            box-shadow: 0 5px 20px var(--shadow-color);
            border-radius: 12px;
            overflow: hidden;
            animation: fadeIn 0.5s ease-in-out;
        }

        th,
        td {
            padding: 1.25rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 1.1rem;
        }

        th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 500;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(79, 70, 229, 0.05);
            transform: translateX(5px);
        }

        .actions a {
            margin-right: 1rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .actions a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .btn-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .btn-floating:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .container {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            h1 {
                font-size: 2.2rem;
            }

            th,
            td {
                padding: 1rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 60px;
                padding: 1rem 0.5rem;
            }

            .sidebar .logo_container,
            .sidebar h3,
            .sidebar a span {
                display: none;
            }

            .sidebar a {
                text-align: center;
                padding: 0.5rem;
            }

            .container {
                margin-left: 60px;
                width: calc(100% - 60px);
                padding: 1rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            th,
            td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo_container text-center mb-4">
            <img src="<?php echo base_url('assets/imagens/logo.png'); ?>" class="logo" alt="Logo">
        </div>
        <h3 class="ms-3 text-center">Painel</h3>

        <!-- Botão Home -->
        <a href="<?= base_url('welcome/index'); ?>" class="btn btn-home w-100 text-start px-3">
            <i class="bi bi-house-door-fill me-2"></i> <span>Home</span>
        </a>

        <!-- Menu de Pacientes -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPacientes"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-file-person-fill me-2"></i> <span>Pacientes</span> <i
                class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuPacientes">
            <a href="<?= base_url('paciente/index'); ?>" class="d-block ms-4"><i class="bi bi-person-circle me-2"></i>
                <span>Todos os pacientes</span></a>
            <a href="<?= base_url('paciente/create_paciente'); ?>" class="d-block ms-4"><i
                    class="bi bi-person-fill-add me-2"></i> <span>Adicionar pacientes</span></a>
        </div>

        <!-- Menu Senhas -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuSenhas"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-file-binary-fill me-2"></i> <span>Senhas</span> <i
                class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuSenhas">
            <a href="<?= base_url('tiposSenhas/index'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-binary-fill me-2"></i> <span>Tipos de senhas</span></a>
            <a href="<?= base_url('tiposSenhas/criar'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-diff-fill me-2"></i> <span>Adicionar senhas</span></a>
            <a href="<?= base_url('senhas/gerar'); ?>" class="d-block ms-4"><i class="bi bi-key-fill me-2"></i>
                <span>Gerar
                    Senhas</span></a>
        </div>

        <!-- Menu Painel -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPainel"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-card-heading me-2"></i> <span>Painel</span> <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuPainel">
            <a href="<?= base_url('chamada/index'); ?>" class="d-block ms-4"><i class="bi bi-layers-fill me-2"></i>
                <span>Chamar
                    senha</span></a>
            <a href="<?= base_url('configuration/painel_2'); ?>" class="d-block ms-4"><i
                    class="bi bi-dash-square-fill me-2"></i>
                <span>Painel</span></a>
        </div>

        <!-- Menu Configurações -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuConfiguracoes"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-gear-fill me-2"></i> <span>Configurações</span> <i
                class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuConfiguracoes">
            <a href="<?= base_url('configuration/index'); ?>" class="d-block ms-4"><i class="bi bi-sliders me-2"></i>
                <span>Config Painel</span></a>
            <a href="<?= base_url('painel/index'); ?>" class="d-block ms-4"><i class="bi bi-sliders2 me-2"></i>
                <span>Config Senhas</span></a>
        </div>
    </div>

    <div class="container">
        <h1>Lista de Pacientes</h1>

        <?php if (!empty($pacientes)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>CPF</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paciente->nome); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($paciente->nascimento)); ?></td>
                            <td><?php echo htmlspecialchars($paciente->cpf); ?></td>
                            <td class="actions">
                                <a href="#" class="btn-editar-paciente" data-id="<?= $paciente->id; ?>"
                                    data-nome="<?= htmlspecialchars($paciente->nome); ?>"
                                    data-nascimento="<?= date('d/m/Y', strtotime($paciente->nascimento)); ?>"
                                    data-cpf="<?= htmlspecialchars($paciente->cpf); ?>"
                                    data-email="<?= htmlspecialchars($paciente->email); ?>"
                                    data-endereco="<?= htmlspecialchars($paciente->endereco); ?>">
                                    Editar
                                </a> <a href="<?php echo base_url('paciente/delete_paciente/' . $paciente->id); ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir este paciente?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-center">Nenhum paciente encontrado.</p>
        <?php endif; ?>

        <!-- Botão flutuante para abrir o modal -->
        <button type="button" class="btn-floating" data-bs-toggle="modal" data-bs-target="#pacienteModal">
            <i class="fas fa-plus"></i>
        </button>


        <!-- Modal de Cadastro/Edição de Paciente -->
        <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content p-4" style="border-radius: 20px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="pacienteModalLabel">Novo Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formPaciente" action="<?= base_url('paciente/store'); ?>" method="POST">

                        <div class="modal-body">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                                <label for="nome">Nome</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nascimento" name="nascimento" placeholder="Data de Nascimento" required>
                                <label for="nascimento">Data de Nascimento</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
                                <label for="cpf">CPF</label>
                                <div id="cpf-feedback" class="text-danger mt-1" style="display:none;">Este CPF já está em uso!</div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                                <label for="email">E-mail</label>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Endereço" id="endereco" name="endereco" style="height: 80px"></textarea>
                                <label for="endereco">Endereço</label>
                            </div>

                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                <i class="fas fa-save me-1"></i> Salvar
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                    class="fas fa-times me-1"></i> Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#nascimento').mask('00/00/0000');
                $('#cpf').mask('000.000.000-00');

                // Verificação de CPF duplicado
                $('#cpf').on('blur', function () {
                    var cpf = $(this).val();
                    var id = $('#id').val() || '';
                    if (cpf.length < 14) return; 

                    $.post('<?= base_url('paciente/check_cpf'); ?>', {cpf: cpf, id: id}, function (data) {
                        var res = JSON.parse(data);
                        if (res.exists) {
                            $('#cpf-feedback').show();
                            $('#btnSubmit').prop('disabled', true);
                        } else {
                            $('#cpf-feedback').hide();
                            $('#btnSubmit').prop('disabled', false);
                        }
                    });
                });

                // Botão de Adicionar Paciente
                $('.btn-floating').on('click', function () {
                    $('#pacienteModalLabel').text('Novo Paciente');
                    $('#formPaciente').attr('action', '<?= base_url('paciente/store'); ?>');
                    $('#formPaciente')[0].reset();
                    $('#btnSubmit').html('<i class="fas fa-save me-1"></i> Salvar');
                    $('#btnSubmit').prop('disabled', false);
                    $('#cpf-feedback').hide();
                    $('#id').val('');
                });

                // Botão de Editar
                $('.btn-editar-paciente').on('click', function () {
                    const id = $(this).data('id');
                    $('#pacienteModalLabel').text('Editar Paciente');
                    $('#formPaciente').attr('action', '<?= base_url('paciente/atualizar'); ?>/' + id);
                    $('#nome').val($(this).data('nome'));
                    $('#nascimento').val($(this).data('nascimento'));
                    $('#cpf').val($(this).data('cpf'));
                    $('#email').val($(this).data('email'));
                    $('#endereco').val($(this).data('endereco'));
                    $('#btnSubmit').html('<i class="fas fa-save me-1"></i> Atualizar');
                    $('#btnSubmit').prop('disabled', false);
                    $('#cpf-feedback').hide();
                    $('#id').val(id);
                    $('#pacienteModal').modal('show');
                });

             $('#formPaciente').on('submit', function(e) {
                e.preventDefault();

                if ($('#cpf-feedback').is(':visible')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CPF já cadastrado',
                        text: 'O CPF informado já está em uso!',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Atualiza a lista de pacientes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro inesperado ao salvar. Tente novamente.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            });
        </script>
    </div>
</body>

</html>