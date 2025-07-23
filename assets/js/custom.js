function atualizarPainel() {
    $.ajax({
        url: "<?= base_url('index.php/painel/get_senha_chamada'); ?>",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.senha) {
                $("#mensagemSenha").html("Última senha chamada: <strong>" + response.senha + "</strong>");
                falarSenha(response.senha);
            }
        }
    });
}
