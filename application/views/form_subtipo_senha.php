<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($subtipo_senha) ? 'Editar Subtipo de Senha' : 'Criar Subtipo de Senha'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 600px; /* Aumentado de 500px para 600px */
            width: 100%;
            background-color: white;
            padding: 40px; /* Aumentado de 30px para 40px */
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            max-width: 180px; /* Aumentado de 150px para 180px */
            height: auto;
        }

        h1 {
            font-size: 2.2rem; /* Aumentado de 1.8rem para 2.2rem */
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px; /* Aumentado de 20px para 25px */
        }

        label {
            display: block;
            margin-bottom: 8px; /* Aumentado de 5px para 8px */
            font-weight: 500;
            color: #34495e;
            font-size: 1.2rem; /* Aumentado de 1rem (implicito) para 1.2rem */
        }

        input, select {
            width: 100%;
            padding: 12px; /* Aumentado de 10px para 12px */
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1.2rem; /* Aumentado de 1rem para 1.2rem */
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #6a5acd;
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px; /* Aumentado de 10px 20px para 12px 25px */
            background-color: #6a5acd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-weight: 500;
            text-align: center;
            font-size: 1.2rem; /* Aumentado de 1rem (implicito) para 1.2rem */
        }

        .btn:hover {
            background-color: #5a4ab5;
        }

        .btn-cancel {
            background-color: #dc3545;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }

        .button-group {
            display: flex;
            gap: 15px; /* Aumentado de 10px para 15px */
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="<?php echo base_url('assets/imagens/Senha.png'); ?>" alt="Logo Senha">
        </div>

        <h1><?php echo isset($subtipo_senha) ? 'Editar Subtipo de Senha' : 'Criar Subtipo de Senha'; ?></h1>
        <form action="<?php echo isset($subtipo_senha) ? site_url('tiposSenhas/atualizar_subtipo/' . $subtipo_senha->id) : site_url('tiposSenhas/salvar_subtipo'); ?>" method="post">
            <div class="form-group">
                <label for="tipo_senha_id">Tipo de Senha</label>
                <select name="tipo_senha_id" id="tipo_senha_id" required>
                    <option value="">Selecione um tipo</option>
                    <?php foreach ($tipos_senha as $tipo): ?>
                        <option value="<?php echo $tipo->id; ?>" <?php echo isset($subtipo_senha) && $subtipo_senha->tipo_senha_id == $tipo->id ? 'selected' : ''; ?>>
                            <?php echo $tipo->nome; ?> (<?php echo $tipo->prefixo; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nome">Nome do Subtipo</label>
                <input type="text" name="nome" id="nome" value="<?php echo isset($subtipo_senha) ? $subtipo_senha->nome : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="prefixo">Prefixo do Subtipo</label>
                <input type="text" name="prefixo" id="prefixo" value="<?php echo isset($subtipo_senha) ? $subtipo_senha->prefixo : ''; ?>" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn">Salvar</button>
                <a href="<?php echo site_url('tiposSenhas/index'); ?>" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>