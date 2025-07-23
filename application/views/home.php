<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        function adjustBrightness($hex, $steps, $opacity = 1) {
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
            --primary-color: <?php echo $primary_color; ?>;
            --secondary-color: <?php echo $secondary_color; ?>;
            --accent-color: <?php echo $accent_color; ?>;
            --text-color: <?php echo $text_color; ?>;
            --light-bg: <?php echo $light_bg; ?>;
            --shadow-color: <?php echo $shadow_color; ?>;
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

        /* Sidebar */
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
            transition: all 0.3s ease;
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
            font-weight: 400;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .collapse-menu {
            font-weight: 500;
            position: relative;
        }

        .sidebar .collapse-menu .fas {
            transition: transform 0.3s ease;
        }

        .sidebar .collapse-menu[aria-expanded="true"] .fas {
            transform: rotate(180deg);
        }

        .sidebar .collapse a {
            font-size: 0.9rem;
            padding: 0.5rem 1rem 0.5rem 2rem;
        }

        .sidebar .collapse a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Content Home */
        .content_home {
            margin-left: 250px;
            width: calc(100% - 250px);
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--light-bg), #e2e8f0);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content_home::before {
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

        .content_home h2, .content_home p {
            position: relative;
            z-index: 1;
        }

        .content_home h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeIn 0.5s ease-in-out;
        }

        .content_home p {
            font-size: 1.2rem;
            color: #6b7280;
            animation: fadeIn 0.7s ease-in-out;
        }

        /* Animações */
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

        /* Responsividade */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content_home {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .sidebar .logo {
                max-height: 60px;
            }

            .sidebar h3 {
                font-size: 1.2rem;
            }

            .sidebar a {
                font-size: 0.9rem;
                padding: 0.5rem 0.75rem;
            }

            .content_home h2 {
                font-size: 2rem;
            }

            .content_home p {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 60px;
                padding: 1rem 0.5rem;
            }

            .sidebar .logo_container, .sidebar h3, .sidebar a span, .sidebar .collapse-menu .fas {
                display: none;
            }

            .sidebar a {
                text-align: center;
                padding: 0.5rem;
            }

            .sidebar a i {
                font-size: 1.2rem;
            }

            .content_home {
                margin-left: 60px;
                width: calc(100% - 60px);
                padding: 1rem;
            }

            .content_home h2 {
                font-size: 1.5rem;
                text-align: center;
            }

            .content_home p {
                font-size: 0.9rem;
                text-align: center;
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
            <i class="bi bi-file-person-fill me-2"></i> <span>Pacientes</span> <i class="fas fa-chevron-down float-end"></i>
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
            <i class="bi bi-file-binary-fill me-2"></i> <span>Senhas</span> <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuSenhas">
            <a href="<?= base_url('tiposSenhas/index'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-binary-fill me-2"></i> <span>Tipos de senhas</span></a>
            <a href="<?= base_url('tiposSenhas/criar'); ?>" class="d-block ms-4"><i
                    class="bi bi-file-earmark-diff-fill me-2"></i> <span>Adicionar senhas</span></a>
            <a href="<?= base_url('senhas/gerar'); ?>" class="d-block ms-4"><i class="bi bi-key-fill me-2"></i> <span>Gerar
                Senhas</span></a>
        </div>

        <!-- Menu Painel -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuPainel"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-card-heading me-2"></i> <span>Painel</span> <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuPainel">
            <a href="<?= base_url('chamada/index'); ?>" class="d-block ms-4"><i class="bi bi-layers-fill me-2"></i> <span>Chamar
                senha</span></a>
            <a href="<?= base_url('configuration/'.$panel_view); ?>" class="d-block ms-4">
                <i class="bi bi-dash-square-fill me-2"></i>
                <span>Painel</span>
            </a>
        </div>

        <!-- Menu Configurações -->
        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuConfiguracoes"
            class="collapse-menu d-block text-start px-3">
            <i class="bi bi-gear-fill me-2"></i> <span>Configurações</span> <i class="fas fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="menuConfiguracoes">
            <a href="<?= base_url('configuration/index'); ?>" class="d-block ms-4"><i class="bi bi-sliders me-2"></i> <span>Config Painel</span></a>
            <a href="<?= base_url('painel/index'); ?>" class="d-block ms-4"><i class="bi bi-sliders2 me-2"></i> <span>Config Senhas</span></a>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content_home">
        <h2>Bem-vindo a Gees!</h2>
        <p>Escolha uma opção no menu lateral.</p>
    </div>
</body>

</html>