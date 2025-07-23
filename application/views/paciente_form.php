<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($paciente) ? 'Editar Paciente' : 'Novo Paciente'; ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <style>
        :root {
            --primary-color: #4f46e5; /* Indigo */
            --secondary-color: #7c3aed; /* Violet */
            --accent-color: #10b981; /* Emerald */
            --text-color: #1f2937; /* Gray-900 */
            --light-bg: #f8fafc; /* Slate-50 */
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--light-bg), #e2e8f0); /* Gradiente suave */
            overflow: hidden;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            position: relative;
        }

        .container-form {
            width: 100%;
            max-width: 550px;
            padding: 2.5rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px var(--shadow-color);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        /* Efeito de fundo decorativo */
        .container-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0.05;
            z-index: 0;
        }

        .container-form * {
            position: relative;
            z-index: 1;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-label {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: white;
            outline: none;
        }

        textarea.form-control {
            resize: none;
            height: 100px;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 114, 128, 0.3);
        }

        .text-center {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .fas {
            margin-right: 0.5rem;
        }

        /* Animação de entrada */
        .container-form {
            animation: fadeIn 0.5s ease-in-out;
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

        @media (max-width: 576px) {
            .container-form {
                padding: 1.5rem;
                max-width: 90%;
            }

            h2 {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 0.9rem;
                padding: 0.5rem 0.75rem;
            }

            .btn-success, .btn-secondary {
                padding: 0.5rem 1.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="container-form">
        <h2><?php echo isset($paciente) ? 'Editar Paciente' : 'Novo Paciente'; ?></h2>
        <form action="<?php echo isset($paciente) ? base_url('paciente/atualizar/' . $paciente->id) : base_url('paciente/store'); ?>" method="POST">
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($paciente) ? htmlspecialchars($paciente->nome) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nascimento" class="form-label">Data de Nascimento</label>
                <input type="text" class="form-control" id="nascimento" name="nascimento" value="<?php echo isset($paciente) ? date('d/m/Y', strtotime($paciente->nascimento)) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo isset($paciente) ? htmlspecialchars($paciente->cpf) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($paciente) ? htmlspecialchars($paciente->email) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control" id="endereco" name="endereco" rows="3"><?php echo isset($paciente) ? htmlspecialchars($paciente->endereco) : ''; ?></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> <?php echo isset($paciente) ? 'Atualizar' : 'Salvar'; ?></button>
                <a href="<?php echo base_url('paciente/index'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
            </div>
            
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#nascimento').mask('00/00/0000');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>