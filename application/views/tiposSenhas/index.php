<div class="page-senhas">
    <h1>Tipos e Subtipos de Senha</h1>

    <?php if ($this->session->flashdata('success')): ?>
        <p class="feedback success"><?= htmlspecialchars($this->session->flashdata('success')); ?></p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p class="feedback error"><?= htmlspecialchars($this->session->flashdata('error')); ?></p>
    <?php endif; ?>

    <section class="section-block">
        <div class="section-header">
            <h2>Tipos de Senha</h2>
            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#modalCriarTipo">
                Criar Novo Tipo
            </button>
        </div>

        <div class="table-wrap">
            <table class="senhas-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Prefixo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tipos_senha)): ?>
                        <?php foreach ($tipos_senha as $tipo): ?>
                            <tr>
                                <td><?= htmlspecialchars($tipo->nome); ?></td>
                                <td><?= htmlspecialchars($tipo->prefixo); ?></td>
                                <td class="actions">
                                    <a href="<?= site_url('tiposSenhas/editar/' . $tipo->id); ?>">Editar</a>
                                    <a href="<?= site_url('tiposSenhas/delete/' . $tipo->id); ?>" onclick="return confirm('Tem certeza que deseja deletar este tipo?');">Deletar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Nenhum tipo de senha cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="section-block">
        <div class="section-header">
            <h2>Subtipos de Senha</h2>
            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#modalCriarSubtipo">
                Criar Novo Subtipo
            </button>
        </div>

        <div class="table-wrap">
            <table class="senhas-table">
                <thead>
                    <tr>
                        <th>Tipo de Senha</th>
                        <th>Nome</th>
                        <th>Prefixo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subtipos_senha)): ?>
                        <?php foreach ($subtipos_senha as $subtipo): ?>
                            <tr>
                                <td><?= htmlspecialchars($subtipo->tipo_nome); ?> (<?= htmlspecialchars($subtipo->tipo_prefixo); ?>)</td>
                                <td><?= htmlspecialchars($subtipo->nome); ?></td>
                                <td><?= htmlspecialchars($subtipo->prefixo); ?></td>
                                <td class="actions">
                                    <a href="<?= site_url('tiposSenhas/editar_subtipo/' . $subtipo->id); ?>">Editar</a>
                                    <a href="<?= site_url('tiposSenhas/delete_subtipo/' . $subtipo->id); ?>" onclick="return confirm('Tem certeza que deseja deletar este subtipo?');">Deletar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nenhum subtipo de senha cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="modal fade" id="modalCriarTipo" tabindex="-1" aria-labelledby="modalCriarTipoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('tiposSenhas/salvar'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriarTipoLabel">Criar Novo Tipo de Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomeTipo" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeTipo" name="nome" required>
                    </div>
                    <div class="mb-0">
                        <label for="prefixoTipo" class="form-label">Prefixo</label>
                        <input type="text" class="form-control" id="prefixoTipo" name="prefixo" maxlength="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCriarSubtipo" tabindex="-1" aria-labelledby="modalCriarSubtipoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('tiposSenhas/salvar_subtipo'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCriarSubtipoLabel">Criar Novo Subtipo de Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipoSenhaIdSubtipo" class="form-label">Tipo de Senha</label>
                        <select class="form-select" id="tipoSenhaIdSubtipo" name="tipo_senha_id" required>
                            <option value="">Selecione um tipo</option>
                            <?php if (!empty($tipos_senha)): ?>
                                <?php foreach ($tipos_senha as $tipo): ?>
                                    <option value="<?= (int) $tipo->id; ?>">
                                        <?= htmlspecialchars($tipo->nome); ?> (<?= htmlspecialchars($tipo->prefixo); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomeSubtipo" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeSubtipo" name="nome" required>
                    </div>
                    <div class="mb-0">
                        <label for="prefixoSubtipo" class="form-label">Prefixo</label>
                        <input type="text" class="form-control" id="prefixoSubtipo" name="prefixo" maxlength="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .page-senhas {
        width: 100%;
        max-width: 1400px;
        color: var(--text-color);
    }

    .page-senhas h1 {
        margin: 0 0 2rem;
        font-size: 2.4rem;
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-senhas .section-block {
        margin-bottom: 2.2rem;
    }

    .page-senhas .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .page-senhas h2 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .page-senhas .btn-action {
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.65rem 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .page-senhas .btn-action:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .page-senhas .table-wrap {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px var(--shadow-color);
        overflow-x: auto;
    }

    .page-senhas .senhas-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 680px;
    }

    .page-senhas .senhas-table th,
    .page-senhas .senhas-table td {
        padding: 0.95rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.98rem;
        vertical-align: middle;
    }

    .page-senhas .senhas-table th {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        font-weight: 600;
    }

    .page-senhas .senhas-table tbody tr:hover {
        background: rgba(79, 70, 229, 0.04);
    }

    .page-senhas .actions {
        white-space: nowrap;
    }

    .page-senhas .actions a {
        text-decoration: none;
        color: var(--primary-color);
        font-weight: 500;
        margin-right: 0.75rem;
    }

    .page-senhas .actions a:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    .page-senhas .feedback {
        margin-bottom: 1rem;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        font-weight: 500;
    }

    .page-senhas .feedback.success {
        background: #e8f7ed;
        color: #1f7a37;
    }

    .page-senhas .feedback.error {
        background: #fdeaea;
        color: #b42318;
    }

    @media (max-width: 768px) {
        .page-senhas h1 {
            font-size: 2rem;
        }

        .page-senhas .section-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
