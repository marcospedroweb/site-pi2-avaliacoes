let categoriaTitulo = document.querySelector('#categoria-titulo'); // categoria do titulo
let btnAvaliarTitulo = document.querySelector('#avaliar-categoria'); // Btn avaliar, secão do titulo
let sectionComentarios = document.querySelector('#comentarios');
let formComentar = document.querySelector('.comentar'); // formulario do comentar
let sectionJaAssistiu = document.querySelector('.ja-assistiu'); // alert
let btnCancelarComentario = document.querySelector('#comentar-buttons .btn-cancelar'); // btn cancelar formulario
let btnComentar = document.querySelector('#comentar'); // btn comentar formulario
let btnSeLogar = document.querySelector('.alert#alert-deixe-nota .btn-primary');

function iniciarComentario(scroll) {
  if (scroll) {
    //Scrola até a sessão comentarios e faz aparecer o text area
    scrollToPosition(sectionComentarios.offsetTop - 80);
    if (variaveisPHP['usuarioJaComentou'] === '1' || variaveisPHP['id'] === 'NaN')
      avisarParaSeLogar();
    else
      setTimeout(function () {
        if (formComentar.classList.contains('d-none')) {
          setTimeout(function () {
            sectionJaAssistiu.classList.toggle('d-none');
          }, 100)
          setTimeout(function () {
            formComentar.classList.remove('show-cima');
            formComentar.classList.add('show');
          }, 200)
          formComentar.classList.toggle('d-none')
        }
      }, 200);
  } else {
    //faz aparecer o text area
    if (formComentar.classList.contains('d-none')) {
      setTimeout(function () {
        sectionJaAssistiu.classList.toggle('d-none');
      }, 100)
      setTimeout(function () {
        formComentar.classList.remove('show-cima');
        formComentar.classList.add('show');
      }, 200)
      formComentar.classList.toggle('d-none')
    }
  }
}

//Scrola para comentarios
if ($_GET['pagina'] !== undefined)
  scrollToPosition(sectionComentarios.offsetTop - 80);

//Função para ativar o alert de Se logar, ou deixa nota
function avisarParaSeLogar(eventForm) {
  if (eventForm)
    //Se o usuario não deu a nota para o titulo ou não está logado, impede o envio do comentario
    eventForm.preventDefault();
  let alertNota = document.querySelector('.alert#alert-deixe-nota');
  let alertNotaSpan = alertNota.querySelector('span');
  if (alertNota.classList.contains('d-none')) {
    //Verificando se o alert está invisivel
    //Se sim, faz aparecer o alert avisando o usuario para se logar ou deixar a nota
    if (variaveisPHP['usuarioJaComentou'] === '1')
      alertNotaSpan.textContent = `Você já deixou sua avaliação para ${variaveisPHP['tituloEscolhido']}!`;
    else if (variaveisPHP['id'] === 'NaN') {
      alertNotaSpan.textContent = `É necessário se logar para avaliar ${variaveisPHP['tituloEscolhido']}!`;
      if (btnSeLogar.classList.contains('d-none')) {
        btnSeLogar.classList.toggle('d-none');
      }
    }
    alertNota.classList.toggle('d-none')
    setTimeout(function () {
      alertNota.classList.add('alert-warning');
      alertNota.classList.remove('alert-danger');
    }, 200);
  } else {
    //Verificando se o alert está invisivel
    //Se não, faz aparecer o alert avisando o usuario para se logar ou deixar a nota
    alertNota.classList.add('alert-danger');
    alertNota.classList.remove('alert-warning');
    setTimeout(function () {
      alertNota.classList.add('alert-warning');
      alertNota.classList.remove('alert-danger');
    }, 200);
  }
}

//Função para formatar o timestamp
function formatarTimeStamp(tempoUsuario) {
  const segundo = 1000; // 1000
  const minuto = segundo * 60; // 60.000
  const hora = minuto * 60; // 3.600.000
  const dia = hora * 24; // 86.400.000
  const semana = dia * 7; // 604.800.000
  const mes = semana * 4; // 2.419.200.000
  const ano = mes * 12; // 29.030.400.000

  /*
    o que essa função tem que retornar?
    ms = 1000 -> 1 segundos atrás 
    ms = 60.000 -> 1 minuto atrás  
    ms = 3.600.000 -> 1 hora atrás 
    ms = 86.400.000 -> 1 dia atrás 
    ms = 604.800.000 -> 1 semana atrás 
    ms = 2.419.200.000 -> 1 mês atrás 
  */

  if (tempoUsuario < segundo) {

    return `${tempoUsuario} milesimos atrás`;

  } else if (tempoUsuario < minuto) {

    let seg = parseInt(tempoUsuario / segundo);
    if (seg === 1)
      return `${seg} segundo atrás`;
    else
      return `${seg} segundos atrás`;

  } else if (tempoUsuario < hora) {

    let min = parseInt(tempoUsuario / minuto);
    if (min === 1)
      return `${min} minuto atrás`
    else
      return `${min} minutos atrás`;

  } else if (tempoUsuario < dia) {

    let horas = parseInt(tempoUsuario / hora);
    if (horas === 1)
      return `${horas} hora atrás`;
    else
      return `${horas} horas atrás`;

  } else if (tempoUsuario < semana) {

    let dias = parseInt(tempoUsuario / dia);
    if (dias === 1)
      return `${dias} dia atrás`;
    else
      return `${dias} dias atrás`;

  } else if (tempoUsuario < mes) {

    let semanas = parseInt(tempoUsuario / semana);
    if (semanas === 1)
      return `${semanas} semana atrás`;
    else
      return `${semanas} semanas atrás`;

  } else if (tempoUsuario < ano) {

    let meses = parseInt(tempoUsuario / mes);
    if (meses === 1)
      return `${meses} mes atrás`;
    else
      return `${meses} meses atrás`;

  } else {
    let anos = parseInt(tempoUsuario / ano);
    if (anos === 1)
      return `${anos} ano atrás`;
    else
      return `${anos} anos atrás`;

  }
}

if ($_GET['comentar']) {
  //Se a pessoa se logar, scrolla para seção comentarios
  iniciarComentario(true);
}

categoriaTitulo.textContent = (categoriaTitulo.textContent).replace('s', ''); // Remove o 's' de categoria do titulo

btnAvaliarTitulo.addEventListener('click', function (e) {
  // Começa o comentario, no click do botão ao lado do titulo, com scroll
  e.preventDefault();
  iniciarComentario(true);
});

//btn da sessão Ja assistiu
sectionJaAssistiu.addEventListener('click', function (e) {
  if (variaveisPHP['usuarioJaComentou'] === '1')
    avisarParaSeLogar();
  else if ((e.target === sectionJaAssistiu.querySelector('button')) && variaveisPHP['id'] !== 'NaN')
    // Começa o comentario, no click do botão ao lado do titulo, com scroll
    iniciarComentario(false);
  else
    avisarParaSeLogar();

});

//alert que aparece depois de clicar em cancelar o comentario
btnCancelarComentario.addEventListener('click', function () {
  let alert = document.querySelector('.alert#alert-cancelar');
  let alertNota = document.querySelector('.alert#alert-deixe-nota');
  let btnAlertSim = document.querySelector('#btn-cancelar-alert');
  let btnAlertNao = document.querySelector('#btn-voltar-alert');

  if (alert.classList.contains('d-none')) {
    alert.classList.toggle('d-none')
    setTimeout(function () {
      alert.classList.add('alert-warning');
      alert.classList.remove('alert-danger');
    }, 200);
    alert.addEventListener('click', function (e) {
      if (e.target === btnAlertSim) {
        //Btn do confirmar o "cancelar comentario"
        //Se sim, esconde o textarea e volta a sessão Ja assistiu
        if (!(formComentar.classList.contains('d-none'))) {
          if (!(alert.classList.contains('d-none'))) {
            alert.classList.toggle('d-none');
            alert.classList.add('alert-danger');
            alert.classList.remove('alert-warning');
          }

          setTimeout(function () {
            if (sectionJaAssistiu.classList.contains('d-none')) {
              sectionJaAssistiu.classList.toggle('d-none');
            }
          }, 350);

          formComentar.classList.remove('show');
          formComentar.classList.add('show-cima');
          setTimeout(function () {
            if (!(formComentar.classList.contains('d-none'))) {
              formComentar.classList.toggle('d-none');
              formComentar.classList.remove('show-cima');
            }
          }, 300);

          if (!(alertNota.classList.contains('d-none'))) {
            alertNota.classList.toggle('d-none')
            setTimeout(function () {
              alertNota.classList.add('alert-danger');
              alertNota.classList.remove('alert-warning');
            }, 200);
          }
          avalUser.textContent = 'N/A';
          avalUser.style.color = fragEstrelas.cinza[0];
          for (let i = 0; i <= 9; i++)
            if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
              estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
            else //numero par com nota (lado direito)
              estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        }
      } else if (e.target === btnAlertNao) {
        //Btn do confirmar o "cancelar comentario"
        //Se não, apenas esconde novamente o alert
        if (!(alert.classList.contains('d-none'))) {
          alert.classList.toggle('d-none');
          alert.classList.add('alert-danger');
          alert.classList.remove('alert-warning');
        }
      }
    });
  }

});


//Formatão das estrelas da sessão Comentar
let estrelasComentario = document.querySelector('.comentar-estrelas');
let estrelasImg = estrelasComentario.querySelectorAll('span img');
let avalUser = document.querySelector('.avaliacao-usuario');
let comentarTextarea = document.querySelector('#comentar-textarea');
let spanComentar = document.querySelector('#span-comentario');

window.onload = function () {
  avalUser.style.color = fragEstrelas.cinza[0];
}

//Verifica se o usuario deixou a nota ou se está em uma conta
formComentar.addEventListener('submit', function (eventForm) {
  if (avalUser.textContent === 'N/A' || variaveisPHP['id'] === 'NaN')
    avisarParaSeLogar(eventForm);
});

comentarTextarea.addEventListener('input', function () {
  if (variaveisPHP['id'] === 'NaN')
    avisarParaSeLogar();
  else {
    if ((comentarTextarea.value).length < 1200) {
      spanComentar.textContent = `${(comentarTextarea.value).length} / 1200`;
      spanComentar.style.color = "#212529";
    } else {
      spanComentar.textContent = `${(comentarTextarea.value).length} / 1200`;
      spanComentar.style.color = fragEstrelas.vermelho[0];
    }
  }
});


// Formatação das estrelas do comentar
function atualizarEstrelas(eventTarget, estrelas, avalSpan, inputComentario, atualizarEditarComentario, avaliacaoTexto) {
  if (eventTarget === estrelas[9] || (atualizarEditarComentario && avaliacaoTexto.textContent === '5')) {
    avalSpan.textContent = 5;
    inputComentario.value = 5;
    avalSpan.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[1]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (eventTarget === estrelas[8] || (atualizarEditarComentario && avaliacaoTexto.textContent === '4.5')) {

    avalSpan.textContent = 4.5;
    inputComentario.value = 4.5;
    avalSpan.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[1]);
      else if (i === 9) // Ultimo lado direito
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (eventTarget === estrelas[7] || (atualizarEditarComentario && avaliacaoTexto.textContent === '4')) {

    avalSpan.textContent = 4;
    inputComentario.value = 4;
    avalSpan.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 8) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[1]);
      else if (i >= 8 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 8 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (eventTarget === estrelas[6] || (atualizarEditarComentario && avaliacaoTexto.textContent === '3.5')) {

    avalSpan.textContent = 3.5;
    inputComentario.value = 3.5;
    avalSpan.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 7) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 7 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 7 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (eventTarget === estrelas[5] || (atualizarEditarComentario && avaliacaoTexto.textContent === '3')) {

    avalSpan.textContent = 3;
    inputComentario.value = 3;
    avalSpan.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 6) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 6 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 6 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (eventTarget === estrelas[4] || (atualizarEditarComentario && avaliacaoTexto.textContent === '2.5')) {

    avalSpan.textContent = 2.5;
    inputComentario.value = 2.5;
    avalSpan.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 5) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 5 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 5 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (eventTarget === estrelas[3] || (atualizarEditarComentario && avaliacaoTexto.textContent === '2')) {

    avalSpan.textContent = 2;
    inputComentario.value = 2;
    avalSpan.style.color = fragEstrelas.laranja[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 4) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.laranja[1]);
      else if (i >= 4 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 4 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.laranja[2]);

  } else if (eventTarget === estrelas[2] || (atualizarEditarComentario && avaliacaoTexto.textContent === '1.5')) {

    avalSpan.textContent = 1.5;
    inputComentario.value = 1.5;
    avalSpan.style.color = fragEstrelas.vermelho[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 3) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 3 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 3 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[2]);

  } else if (eventTarget === estrelas[1] || (atualizarEditarComentario && avaliacaoTexto.textContent === '1')) {

    avalSpan.textContent = 1;
    inputComentario.value = 1;
    avalSpan.style.color = fragEstrelas.vermelho[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 2) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 2 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 2 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[2]);

  } else if (eventTarget === estrelas[0] || (atualizarEditarComentario && avaliacaoTexto.textContent === '0.5')) {

    avalSpan.textContent = 0.5;
    inputComentario.value = 0.5;
    avalSpan.style.color = fragEstrelas.vermelho[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 1) //numero impar com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 1 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 1 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelas[i].setAttribute('src', fragEstrelas.vermelho[2]);

  }
}

let inputComentar = document.querySelector('#avaliacao-usuario-input');
estrelasComentario.addEventListener('mousemove', function (e) {
  if (variaveisPHP['id'] === 'NaN') {
    avisarParaSeLogar();
  } else {
    atualizarEstrelas(e.target, estrelasImg, avalUser, inputComentar, false, '');
  }
})

// Formatação do time stamp
let dataComentario = document.querySelectorAll('.data-comentario');
dataComentario.forEach(function (elemento) {
  let dataAtual = new Date().getTime();
  let timeStampComentario = new Date(parseInt(elemento.textContent) * 1000);

  let timeStampDiferenca = dataAtual - timeStampComentario;
  let tempoAtualizado = formatarTimeStamp(timeStampDiferenca);

  elemento.textContent = tempoAtualizado;
});

// pegado o id de comentario para ser apagado
let btnValueApagar = document.querySelectorAll('.dropend');
let btnApagar = document.querySelector('#btn-apagar-comentario');
btnValueApagar.forEach(function (elemento, indice) {
  elemento.addEventListener('click', function () {
    let idComentario = elemento.getAttribute('id');
    btnApagar.value = idComentario;
  });
});

//Verificando se o usuario pode editar aquele comentario existente
let btnEditarComentario = document.querySelector('.btn-editar-comentario');
if (btnEditarComentario !== null) {
  let btnCancelarEditarComentario = document.querySelector('#btn-editar-cancelar');
  let formEditarComentario = document.querySelector('.editar-comentario');
  let inputEditarIdUsuario = document.querySelector('#editar-id-usuario');
  let editarComentarioDiv = document.querySelector('#comentar-estrelas-editar');
  let editarComentarioEstrelas = editarComentarioDiv.querySelectorAll('span img');
  let avaliacaoUsuarioEditar = document.querySelector('#avaliacao-usuario');
  let inputEditarComentario = document.querySelector('#editar-avaliacao-usuario-input');
  let textareaEditarComentario = document.querySelector('#editar-comentario-textarea');
  let spanEditarComentario = document.querySelector('#span-comentario-editar');

  atualizarEstrelas('', editarComentarioEstrelas, avaliacaoUsuarioEditar, inputEditarComentario, true, avaliacaoUsuarioEditar);

  btnEditarComentario.addEventListener('click', () => {
    if (inputEditarIdUsuario.value === variaveisPHP['id'])
      if (formEditarComentario.classList.contains('d-none'))
        formEditarComentario.classList.toggle('d-none');
  });

  btnCancelarEditarComentario.addEventListener('click', () => {
    if (inputEditarIdUsuario.value === variaveisPHP['id'])
      if (!(formEditarComentario.classList.contains('d-none')))
        formEditarComentario.classList.toggle('d-none');
  });

  editarComentarioDiv.addEventListener('mousemove', function (e) {
    if (variaveisPHP['id'] === 'NaN') {
      avisarParaSeLogar();
    } else {
      atualizarEstrelas(e.target, editarComentarioEstrelas, avaliacaoUsuarioEditar, inputEditarComentario, false, '');
    }
  });

  //Atualizando textarea
  spanEditarComentario.textContent = `${(textareaEditarComentario.value).length} / 1200`;
  if ((textareaEditarComentario.value).length < 1200)
    spanEditarComentario.style.color = "#212529";
  else
    spanEditarComentario.style.color = '#ff4122';
  textareaEditarComentario.addEventListener('input', function () {
    if (variaveisPHP['id'] === 'NaN') {
      iniciarComentario(true);
    } else {
      if ((textareaEditarComentario.value).length < 1200) {
        spanEditarComentario.textContent = `${(textareaEditarComentario.value).length} / 1200`;
        spanEditarComentario.style.color = "#212529";
      } else {
        spanEditarComentario.textContent = `${(textareaEditarComentario.value).length} / 1200`;
        spanEditarComentario.style.color = fragEstrelas.vermelho[0];
      }
    }
  });
}

//Fomatação visual
let temporadaTitulo = document.querySelector('#temporadas-titulo') || '';
let episodiosTitulo = document.querySelector('#episodios-titulo') || '';
let duracaoTitulo = document.querySelector('#duracao-titulo') || '';

if (variaveisPHP['temporadaUnica'] === 'true') {
  //Formatação das temporadas
  if (temporadaTitulo.textContent) {
    temporadaTitulo.classList.toggle('d-none');
    temporadaTitulo.textContent = `${temporadaTitulo.textContent}° temporada`;
  }
  //Formatação dos episodios
  if (episodiosTitulo.textContent) {
    let stringEpisodios;
    episodiosTitulo.textContent === '1' ? stringEpisodios = 'epísodio' : stringEpisodios = 'epísodios';
    episodiosTitulo.classList.toggle('d-none');
    episodiosTitulo.textContent = `${episodiosTitulo.textContent} ${stringEpisodios}`;
  }
} else {
  if (duracaoTitulo.textContent) {
    duracaoTitulo.classList.toggle('d-none');
    //Formatação da duração
    let tempoEmMinutos = duracaoTitulo.textContent;
    if (tempoEmMinutos < 60)
      duracaoTitulo.textContent = `${tempoEmMinutos}min`
    else {
      let horasFormatada = parseFloat(tempoEmMinutos) / 60;
      let horasFormataEmString = horasFormatada.toString();
      let horasEmMinutos = horasFormataEmString.slice(horasFormataEmString.indexOf('.'));
      horasEmMinutos = parseFloat(`0${horasEmMinutos}`);
      horasEmMinutos = horasEmMinutos * 60;
      duracaoTitulo.textContent = `${parseInt(horasFormatada)}h ${parseInt(horasEmMinutos)}min`;
    }
  } else {
    let stringEpisodios, stringTemporadas;
    episodiosTitulo.textContent === '1' ? stringEpisodios = 'epísodio' : stringEpisodios = 'epísodios';
    temporadaTitulo.textContent === '1' ? stringTemporadas = 'temporada' : stringTemporadas = 'temporadas';
    temporadaTitulo.classList.toggle('d-none');
    episodiosTitulo.classList.toggle('d-none');
    temporadaTitulo.textContent = `${temporadaTitulo.textContent} ${stringTemporadas}`;
    episodiosTitulo.textContent = `${episodiosTitulo.textContent} ${stringEpisodios}`;
  }
}

