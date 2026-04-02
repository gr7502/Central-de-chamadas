<div class="page-pacientes">
    <h1>Lista de Pacientes</h1>

    <?php if (!empty($pacientes)): ?>
        <div class="table-wrap">
            <table class="pacientes-table">
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
                            <td><?= htmlspecialchars($paciente->nome); ?></td>
                            <td><?= date('d/m/Y', strtotime($paciente->nascimento)); ?></td>
                            <td><?= htmlspecialchars($paciente->cpf); ?></td>
                            <td class="actions">
                                <a href="#" class="btn-editar-paciente"
                                   data-id="<?= $paciente->id; ?>"
                                   data-nome="<?= htmlspecialchars($paciente->nome); ?>"
                                   data-nascimento="<?= date('d/m/Y', strtotime($paciente->nascimento)); ?>"
                                   data-cpf="<?= htmlspecialchars($paciente->cpf); ?>"
                                   data-email="<?= htmlspecialchars($paciente->email); ?>"
                                   data-endereco="<?= htmlspecialchars($paciente->endereco); ?>">
                                    Editar
                                </a>
                                <a href="<?= base_url('paciente/delete_paciente/' . $paciente->id); ?>"
                                   onclick="return confirm('Tem certeza que deseja excluir este paciente?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="empty">Nenhum paciente encontrado.</p>
    <?php endif; ?>

    <button type="button" class="btn-floating" data-bs-toggle="modal" data-bs-target="#pacienteModal">
        <i class="fas fa-plus"></i>
    </button>

    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4 modal-card">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="pacienteModalLabel">Novo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="formPaciente" action="<?= base_url('paciente/store'); ?>" method="POST">
                    <input type="hidden" id="id" name="id" value="">

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
                            <div id="cpf-feedback" class="text-danger mt-1 d-none">Este CPF já está em uso!</div>
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
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="fas fa-save me-1"></i> Salvar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .page-pacientes {
        width: 100%;
        max-width: 100%;
    }

    .page-pacientes h1 {
        font-size: 2.4rem;
        font-weight: 600;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-pacientes .table-wrap {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px var(--shadow-color);
        overflow-x: auto;
    }

    .page-pacientes .pacientes-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .page-pacientes .pacientes-table th,
    .page-pacientes .pacientes-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-pacientes .pacientes-table th {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        font-weight: 500;
    }

    .page-pacientes .pacientes-table tbody tr:hover {
        background: rgba(79, 70, 229, 0.05);
    }

    .page-pacientes .actions a {
        margin-right: 0.8rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .page-pacientes .actions a:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    .page-pacientes .empty {
        color: #6b7280;
    }

    .page-pacientes .btn-floating {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .page-pacientes .modal-card {
        border-radius: 20px;
    }

    @media (max-width: 768px) {
        .page-pacientes h1 {
            font-size: 2rem;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        $('#nascimento').mask('00/00/0000');
        $('#cpf').mask('000.000.000-00');

        $('#cpf').on('blur', function () {
            const cpf = $(this).val();
            const id = $('#id').val() || '';
            if (cpf.length < 14) return;

            $.post('<?= base_url('paciente/check_cpf'); ?>', { cpf: cpf, id: id }, function (data) {
                const res = JSON.parse(data);
                if (res.exists) {
                    $('#cpf-feedback').removeClass('d-none');
                    $('#btnSubmit').prop('disabled', true);
                } else {
                    $('#cpf-feedback').addClass('d-none');
                    $('#btnSubmit').prop('disabled', false);
                }
            });
        });

        $('.btn-floating').on('click', function () {
            $('#pacienteModalLabel').text('Novo Paciente');
            $('#formPaciente').attr('action', '<?= base_url('paciente/store'); ?>');
            $('#formPaciente')[0].reset();
            $('#btnSubmit').html('<i class="fas fa-save me-1"></i> Salvar').prop('disabled', false);
            $('#cpf-feedback').addClass('d-none');
            $('#id').val('');
        });

        $('.btn-editar-paciente').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            $('#pacienteModalLabel').text('Editar Paciente');
            $('#formPaciente').attr('action', '<?= base_url('paciente/atualizar'); ?>/' + id);
            $('#nome').val($(this).data('nome'));
            $('#nascimento').val($(this).data('nascimento'));
            $('#cpf').val($(this).data('cpf'));
            $('#email').val($(this).data('email'));
            $('#endereco').val($(this).data('endereco'));
            $('#btnSubmit').html('<i class="fas fa-save me-1"></i> Atualizar').prop('disabled', false);
            $('#cpf-feedback').addClass('d-none');
            $('#id').val(id);

            const modalEl = document.getElementById('pacienteModal');
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        });

        $('#formPaciente').on('submit', function (e) {
            e.preventDefault();

            if (!$('#cpf-feedback').hasClass('d-none')) {
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
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
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
