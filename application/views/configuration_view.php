<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações do Painel - Gees HealthTech</title>
    <style>
        :root {
            --primary-color: <?php echo isset($config->primary_color) ? $config->primary_color : '#6a5acd'; ?>;
            --primary-light: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, 40) : '#9370db'; ?>;
            --primary-dark: <?php echo isset($config->primary_color) ? adjustBrightness($config->primary_color, -40) : '#483d8b'; ?>;
            --background: #f5f6fa;
            --card-bg: #ffffff;
            --text-color: #2d2d2d;
            --accent-color: #e6e6fa;
            --border-radius: 20px;
            --box-shadow: 0 10px 30px rgba(106, 90, 205, 0.15);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            line-height: 1.8;
            padding: 50px 20px;
            font-size: 18px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            display: flex;
            align-items: center;
            margin-bottom: 50px;
            padding: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: var(--border-radius);
            color: white;
            box-shadow: var(--box-shadow);
        }

        .logo {
            margin-right: 25px;
            display: flex;
            align-items: center;
        }

        .logo img {
            max-width: 180px;
            height: auto;
            transition: var(--transition);
        }

        .logo img:hover {
            transform: scale(1.2); 
        }

        h1 {
            font-size: 32px;
            font-weight: 600;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 50px;
            margin-bottom: 50px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(106, 90, 205, 0.2);
        }

        .success-message {
            color: #28a745;
            background-color: #e8f5e9;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
            font-size: 20px;
        }

        .error-message {
            color: #dc3545;
            background-color: #ffe6e6;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 40px;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 22px;
        }

        input[type="text"],
        input[type="color"],
        input[type="file"] {
            width: 100%;
            padding: 18px;
            border: 2px solid var(--accent-color);
            border-radius: 12px;
            font-size: 20px;
            transition: var(--transition);
        }

        input[type="text"]:focus,
        input[type="color"]:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 10px rgba(106, 90, 205, 0.3);
        }

        input[type="color"] {
            height: 70px;
            width: 120px;
            padding: 5px;
            cursor: pointer;
            border: none;
            background: none;
        }

        .tab-container {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
            border-bottom: none;
        }

        .tab {
            padding: 15px 30px;
            cursor: pointer;
            background-color: var(--accent-color);
            color: var(--primary-color);
            border-radius: 12px 12px 0 0;
            font-weight: 500;
            font-size: 20px;
            transition: var(--transition);
        }

        .tab.active {
            background-color: var(--primary-color);
            color: white;
        }

        .tab:hover:not(.active) {
            background-color: var(--primary-light);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .upload-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            font-size: 20px;
        }

        .file-upload-btn:hover {
            background-color: var(--primary-dark);
        }

        .file-name {
            font-size: 18px;
            color: #666;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 12px;
            font-size: 22px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            margin-top: 30px;
        }

        button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .preview-section {
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px solid var(--accent-color);
        }

        .preview-section h2 {
            font-size: 26px;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .preview-img {
            max-width: 100%;
            max-height: 450px;
            border-radius: 16px;
            box-shadow: var(--box-shadow);
            object-fit: cover;
            transition: var(--transition);
            cursor: pointer;
        }

        .preview-img:hover {
            transform: scale(1.02);
        }

        .switch-group {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .view-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 50px;
        }

        .view-option .preview-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        /* Estilos para o switch */
        @supports (-webkit-appearance: none) or (-moz-appearance: none) {
            .checkbox-wrapper-14 input[type=checkbox] {
                --active: #275EFE;
                --active-inner: #fff;
                --focus: 2px rgba(39, 94, 254, .3);
                --border: #BBC1E1;
                --border-hover: #275EFE;
                --background: #fff;
                --disabled: #F6F8FF;
                --disabled-inner: #E1E6F9;
                -webkit-appearance: none;
                -moz-appearance: none;
                height: 21px;
                outline: none;
                display: inline-block;
                vertical-align: top;
                position: relative;
                margin: 0;
                cursor: pointer;
                border: 1px solid var(--bc, var(--border));
                background: var(--b, var(--background));
                transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
            }
            .checkbox-wrapper-14 input[type=checkbox]:after {
                content: "";
                display: block;
                left: 0;
                top: 0;
                position: absolute;
                transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
            }
            .checkbox-wrapper-14 input[type=checkbox]:checked {
                --b: var(--active);
                --bc: var(--active);
                --d-o: .3s;
                --d-t: .6s;
                --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
            }
            .checkbox-wrapper-14 input[type=checkbox]:disabled {
                --b: var(--disabled);
                cursor: not-allowed;
                opacity: 0.9;
            }
            .checkbox-wrapper-14 input[type=checkbox]:disabled:checked {
                --b: var(--disabled-inner);
                --bc: var(--border);
            }
            .checkbox-wrapper-14 input[type=checkbox]:disabled + label {
                cursor: not-allowed;
            }
            .checkbox-wrapper-14 input[type=checkbox]:hover:not(:checked):not(:disabled) {
                --bc: var(--border-hover);
            }
            .checkbox-wrapper-14 input[type=checkbox]:focus {
                box-shadow: 0 0 0 var(--focus);
            }
            .checkbox-wrapper-14 input[type=checkbox]:not(.switch) {
                width: 21px;
            }
            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):after {
                opacity: var(--o, 0);
            }
            .checkbox-wrapper-14 input[type=checkbox]:not(.switch):checked {
                --o: 1;
            }
            .checkbox-wrapper-14 input[type=checkbox] + label {
                display: inline-block;
                vertical-align: middle;
                cursor: pointer;
                margin-left: 4px;
            }
            .checkbox-wrapper-14 input[type=checkbox].switch {
                width: 38px;
                border-radius: 11px;
            }
            .checkbox-wrapper-14 input[type=checkbox].switch:after {
                left: 2px;
                top: 2px;
                border-radius: 50%;
                width: 17px;
                height: 17px;
                background: var(--ab, var(--border));
                transform: translateX(var(--x, 0));
            }
            .checkbox-wrapper-14 input[type=checkbox].switch:checked {
                --ab: var(--active-inner);
                --x: 17px;
            }
            .checkbox-wrapper-14 input[type=checkbox].switch:disabled:not(:checked):after {
                opacity: 0.6;
            }
        }

        /* Estilos para o modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
               <a href="<?php echo base_url('welcome/index'); ?>"> <img src="<?php echo base_url('assets/imagens/Senha.png'); ?>" alt="Logo Gees HealthTech"></a>
            </div>
            <h1>Configurações do Painel</h1>
        </header>
        
        <div class="card">
            <?php if ($this->input->get('success')): ?>
                <div class="success-message">Configurações salvas com sucesso!</div>
            <?php endif; ?>
            <?php if ($this->input->get('error')): ?>
                <div class="error-message">Erro ao salvar configurações: <?php echo urldecode($this->input->get('error')); ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo site_url('configuration/update'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="primary_color">Cor Primária</label>
                    <input type="color" name="primary_color" id="primary_color" 
                           value="<?php echo isset($config->primary_color) ? $config->primary_color : '#6a5acd'; ?>">
                </div>
                
                <div class="form-group">
                    <label>Escolha a Visualização do Painel</label>
                    <div class="switch-group">
                        <div class="view-option">
                            <img src="<?php echo base_url('assets/imagens/previews/view1.png'); ?>" alt="Pré-visualização 1" class="preview-img">
                            <div class="checkbox-wrapper-14">
                                <input id="painel" type="checkbox" class="switch" name="panel_view" value="painel" <?php echo (isset($config->panel_view) && $config->panel_view == 'painel') ? 'checked' : ''; ?>>
                            </div>
                        </div>
                        <div class="view-option">
                            <img src="<?php echo base_url('assets/imagens/previews/view2.png'); ?>" alt="Pré-visualização 2" class="preview-img">
                            <div class="checkbox-wrapper-14">
                                <input id="painel_2" type="checkbox" class="switch" name="panel_view" value="painel_2" <?php echo (isset($config->panel_view) && $config->panel_view == 'painel_2') ? 'checked' : ''; ?>>
                            </div>
                        </div>
                        <div class="view-option">
                            <img src="<?php echo base_url('assets/imagens/previews/view3.png'); ?>" alt="Pré-visualização 3" class="preview-img">
                            <div class="checkbox-wrapper-14">
                                <input id="painel_3" type="checkbox" class="switch" name="panel_view" value="painel_3" <?php echo (isset($config->panel_view) && $config->panel_view == 'painel_3') ? 'checked' : ''; ?>>
                            </div>
                        </div>
                        <div class="view-option">
                            <img src="<?php echo base_url('assets/imagens/previews/view4.png'); ?>" alt="Pré-visualização 4" class="preview-img">
                            <div class="checkbox-wrapper-14">
                                <input id="painel_4" type="checkbox" class="switch" name="panel_view" value="painel_4" <?php echo (isset($config->panel_view) && $config->panel_view == 'painel_4') ? 'checked' : ''; ?>>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-container">
                    <div class="tab active" data-tab="url">Usar URL</div>
                    <div class="tab" data-tab="upload">Upload de Arquivo</div>
                </div>
                
                <div class="tab-content active" id="url-tab">
                    <div class="form-group">
                        <label for="image_url">URL da Imagem</label>
                        <input type="text" name="image_url" id="image_url" 
                               value="<?php echo isset($config->image_url) ? $config->image_url : ''; ?>" 
                               placeholder="https://exemplo.com/imagem.jpg">
                    </div>
                </div>
                
                <div class="tab-content" id="upload-tab">
                    <div class="form-group">
                        <label>Upload de Imagem</label>
                        <div class="upload-container">
                            <div class="file-upload">
                                <span class="file-upload-btn">Selecionar Arquivo</span>
                                <input type="file" name="image_file" id="image_file" accept="image/*">
                            </div>
                            <span class="file-name" id="file-name">Nenhum arquivo selecionado</span>
                        </div>
                    </div>
                </div>
                
                <button type="submit">Salvar Configurações</button>
            </form>
            
            <?php if(isset($config->image_url) && !empty($config->image_url)): ?>
                <div class="preview-section">
                    <h2>Prévia da Imagem</h2>
                    <img src="<?php echo $config->image_url; ?>" alt="Imagem do Painel" class="preview-img" id="image-preview">
                </div>
            <?php endif; ?>
        </div>

        <!-- Modal para visualização da imagem -->
        <div id="imageModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                
                const tabId = tab.getAttribute('data-tab') + '-tab';
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        const fileInput = document.getElementById('image_file');
        const fileName = document.getElementById('file-name');
        
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileName.textContent = e.target.files[0].name;
                const preview = document.getElementById('image-preview');
                if (preview) {
                    const file = e.target.files[0];
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                fileName.textContent = 'Nenhum arquivo selecionado';
            }
        });
        
        const urlInput = document.getElementById('image_url');
        urlInput.addEventListener('input', (e) => {
            const preview = document.getElementById('image-preview');
            if (preview && e.target.value) {
                preview.src = e.target.value;
            }
        });

        // Controle do modal
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");
        var span = document.getElementsByClassName("close")[0];

        document.querySelectorAll('.preview-img').forEach(function(img) {
            img.addEventListener('click', function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            });
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const switches = document.querySelectorAll('.switch-group input[type="checkbox"]');
        
        switches.forEach(switchElem => {
            switchElem.addEventListener('change', function() {
                if (this.checked) {
                    switches.forEach(otherSwitch => {
                        if (otherSwitch !== this) {
                            otherSwitch.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>

<?php
function adjustBrightness($hex, $steps) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    return '#' . sprintf("%02x%02x%02x", $r, $g, $b);
}
?>