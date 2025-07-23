function atualizarRelogio() {
  const relogioElement = document.getElementById('relogio');
  const agora = new Date();
  
  // Formata a data e hora (ex.: "quarta-feira, 09 de abril de 2025 14:30:00")
  const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
  };
  let textoRelogio = agora.toLocaleString('pt-BR', options);
  
  // Capitaliza a primeira letra do texto
  textoRelogio = textoRelogio.charAt(0).toUpperCase() + textoRelogio.slice(1);
  
  // Atualiza o elemento do relógio
  relogioElement.textContent = textoRelogio;
}

// Atualiza o relógio a cada segundo
setInterval(atualizarRelogio, 1000);

// Executa imediatamente ao carregar
atualizarRelogio();