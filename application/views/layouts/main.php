<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? htmlspecialchars($titulo) : 'Painel'; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: var(--light-bg);
        }

        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 78px;
            --primary-color: <?= isset($primary_color) ? $primary_color : '#4f46e5'; ?>;
            --secondary-color: <?= isset($secondary_color) ? $secondary_color : '#6a63f0'; ?>;
            --accent-color: <?= isset($accent_color) ? $accent_color : '#7f88ff'; ?>;
            --text-color: <?= isset($text_color) ? $text_color : '#1f2937'; ?>;
            --light-bg: <?= isset($light_bg) ? $light_bg : '#f8fafc'; ?>;
            --shadow-color: <?= isset($shadow_color) ? $shadow_color : 'rgba(0,0,0,0.1)'; ?>;
        }

        .layout {
            min-height: 100vh;
            width: 100%;
            background: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .layout .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 1.5rem 1rem;
            box-shadow: 2px 0 10px var(--shadow-color);
            overflow-y: auto;
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .layout .sidebar .logo_container {
            margin-bottom: 2rem;
        }

        .layout .sidebar .sidebar-toggle {
            position: absolute;
            right: 0.85rem;
            top: 0.85rem;
            border: 0;
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .layout .sidebar .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .layout .sidebar .logo {
            max-height: 80px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .layout .sidebar h3 {
            color: #fff;
            margin-bottom: 2rem;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .layout .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            font-size: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .layout .sidebar a:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(5px);
        }

        .layout .sidebar .collapse-menu {
            font-weight: 500;
        }

        .layout .sidebar .menu-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            position: relative;
        }

        .layout .sidebar .menu-link > i:not(.menu-caret) {
            width: 1.25rem;
            text-align: center;
            flex-shrink: 0;
        }

        .layout .sidebar .menu-link .menu-caret {
            margin-left: auto;
        }

        .layout .sidebar .menu-group {
            position: relative;
            margin-bottom: 0.2rem;
        }

        .layout .sidebar .btn-home {
            margin-bottom: 0.2rem;
        }

        .layout .sidebar .collapse-menu .fas {
            transition: transform 0.3s ease;
        }

        .layout .sidebar .collapse-menu[aria-expanded="true"] .fas {
            transform: rotate(180deg);
        }

        .layout .sidebar .collapse a {
            font-size: 0.92rem;
            padding: 0.5rem 1rem 0.5rem 2rem;
        }

        .layout .content_area {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .layout.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
            padding: 3rem 0.5rem 1rem;
            overflow: visible;
        }

        .layout.sidebar-collapsed .content_area {
            margin-left: var(--sidebar-collapsed-width);
        }

        .layout.sidebar-collapsed .sidebar .logo_container,
        .layout.sidebar-collapsed .sidebar h3 {
            display: none;
        }

        .layout.sidebar-collapsed .sidebar .sidebar-toggle {
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            top: 0.5rem;
            z-index: 1300;
        }

        .layout.sidebar-collapsed .sidebar .menu-link {
            justify-content: center;
            padding: 0.5rem 0 !important;
            gap: 0;
        }

        .layout.sidebar-collapsed .sidebar .menu-link .menu-text,
        .layout.sidebar-collapsed .sidebar .menu-link .menu-caret {
            display: none;
        }

        .layout.sidebar-collapsed .sidebar .menu-link i {
            margin: 0 !important;
            font-size: 1.2rem;
        }

        .layout.sidebar-collapsed .sidebar .menu-group > .submenu {
            display: none !important;
            position: absolute;
            left: 100%;
            top: 0;
            min-width: 230px;
            padding: 0.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            z-index: 1200;
        }

        .layout.sidebar-collapsed .sidebar .menu-group:hover > .submenu {
            display: block !important;
        }

        /* Ponte de hover para não perder o submenu ao sair do item pai */
        .layout.sidebar-collapsed .sidebar .menu-group > .submenu::before {
            content: '';
            position: absolute;
            left: -14px;
            top: 0;
            width: 14px;
            height: 100%;
        }

        .layout.sidebar-collapsed .sidebar .menu-group > .submenu a {
            margin: 0 !important;
            padding: 0.55rem 0.7rem;
            border-radius: 8px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        @media (max-width: 768px) {
            .layout .sidebar {
                width: 200px;
            }

            .layout .content_area {
                margin-left: 200px;
                padding: 1.5rem;
            }

            .layout .sidebar .logo {
                max-height: 60px;
            }
        }

        @media (max-width: 576px) {
            .layout .sidebar {
                width: 70px;
                padding: 1rem 0.5rem;
            }

            .layout .sidebar .logo_container,
            .layout .sidebar h3,
            .layout .sidebar .menu-text,
            .layout .sidebar .collapse-menu .fas,
            .layout .sidebar .collapse {
                display: none;
            }

            .layout .sidebar a {
                text-align: center;
                padding: 0.6rem;
            }

            .layout .sidebar a i {
                font-size: 1.2rem;
                margin-right: 0;
            }

            .layout .content_area {
                margin-left: 70px;
                padding: 1rem;
            }

            .layout .sidebar .sidebar-toggle {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="layout">
    <?= isset($montarMenu) ? $montarMenu : ''; ?>
    <main class="content_area">
        <?= isset($conteudo) ? $conteudo : ''; ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        var layout = document.querySelector('.layout');
        var toggle = document.getElementById('sidebarToggle');
        if (!layout || !toggle) return;

        var storageKey = 'gees_sidebar_collapsed';

        function setCollapsed(collapsed) {
            layout.classList.toggle('sidebar-collapsed', collapsed);
            toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
            try {
                localStorage.setItem(storageKey, collapsed ? '1' : '0');
            } catch (e) {}
        }

        var shouldCollapse = false;
        try {
            shouldCollapse = localStorage.getItem(storageKey) === '1';
        } catch (e) {}

        if (window.innerWidth > 576) {
            setCollapsed(shouldCollapse);
        }

        toggle.addEventListener('click', function () {
            setCollapsed(!layout.classList.contains('sidebar-collapsed'));
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth <= 576) {
                layout.classList.remove('sidebar-collapsed');
            }
        });
    })();
</script>
</body>
</html>
