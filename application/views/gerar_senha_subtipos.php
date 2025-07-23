<?php
// Definindo a função adjustBrightness
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

// Definindo a cor primária
$primary_color = isset($config->primary_color) ? $config->primary_color : '#4f008f';
$primary_color_hover = adjustBrightness($primary_color, -20);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Senha - Subtipos de <?php echo $tipo->nome; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cor-primaria: <?php echo $primary_color; ?>;
            --cor-primaria-hover: <?php echo $primary_color_hover; ?>;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background-color: var(--cor-primaria);
            padding: 30px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            max-width: 250px;
            height: auto;
            padding: 10px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .header .logo:hover {
            transform: scale(1.05);
        }

        /* Container Principal */
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .container-box {
            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            min-height: 600px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .container-box h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 40px;
            font-weight: 600;
        }

        /* Botões de Subtipos */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .col-md-6 {
            flex: 1 1 calc(50% - 30px);
            max-width: calc(50% - 30px);
        }

        .btn-senha {
            width: 100%;
            padding: 20px;
            background-color: var(--cor-primaria);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.4rem;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
        }

        .btn-senha:hover {
            background-color: var(--cor-primaria-hover);
            transform: translateY(-2px);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container-box {
                padding: 30px;
                min-height: 400px;
            }

            .container-box h2 {
                font-size: 2rem;
                margin-bottom: 30px;
            }

            .col-md-6 {
                flex: 1 1 100%;
                max-width: 100%;
            }

            .btn-senha {
                font-size: 1.2rem;
                padding: 15px;
            }

            .row {
                gap: 20px;
            }

            .header .logo {
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <!-- Header com Logo -->
    <div class="header">
        <a href="<?= base_url('welcome/index'); ?>">
            <img src="<?php echo base_url('assets/imagens/logo.png'); ?>" class="logo" alt="Logo">
        </a>
    </div>

    <!-- Container Principal -->
    <div class="container">
        <div class="container-box">
            <h2>Escolha um Subtipo para <?php echo $tipo->nome; ?></h2>
            <div class="row mt-4">
                <?php foreach ($subtipos as $subtipo): ?>
                    <div class="col-md-6 mb-3">
                        <button class="btn-senha gerar-senha-subtipo" 
                                data-id="<?php echo $subtipo->id; ?>" 
                                data-tipo-nome="<?php echo $tipo->nome; ?>" 
                                data-subtipo-nome="<?php echo $subtipo->nome; ?>">
                            <?php echo $subtipo->nome; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".gerar-senha-subtipo").click(function () {
                var subtipo_id = $(this).data("id");
                var tipo_nome = $(this).data("tipo-nome");
                var subtipo_nome = $(this).data("subtipo-nome");

                $.ajax({
                    url: "<?php echo base_url('senhas/gerar_senha_subtipo'); ?>/" + subtipo_id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        if (response.error) {
                            alert("Erro: " + response.error);
                        } else {
                            var senhaGerada = response.success;
                            // Imprime a senha usando apenas o nome do subtipo
                            imprimirSenha(senhaGerada, subtipo_nome);
                        }
                    },
                    error: function () {
                        alert("Erro ao gerar senha.");
                    }
                });
            });

            function imprimirSenha(senha, descricao) {
                var printWindow = window.open('', '', 'width=400,height=300');
                printWindow.document.write('<html><head><title>Senha</title></head><body>');
                printWindow.document.write('<h2 style="text-align:center;">' + descricao + '</h2>');
                printWindow.document.write('<h1 style="text-align:center; font-size:50px; color:red;">' + senha + '</h1>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();

                // Redireciona para a view senhas/gerar após 5 segundos
                setTimeout(function() {
                    window.location.href = "<?php echo base_url('senhas/gerar'); ?>";
                }, 2000); // 5000 milissegundos = 5 segundos
            }
        });
    </script>
</body>
</html>