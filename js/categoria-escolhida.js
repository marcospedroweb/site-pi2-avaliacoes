let categoriaTitulo = document.querySelector('#categoria-titulo'); // categoria do titulo
let btnAvaliarTitulo = document.querySelector('#avaliar-categoria'); // Btn avaliar, secão do titulo
let sectionComentarios = document.querySelector('#comentarios');
let formComentar = document.querySelector('.comentar'); // formulario do comentar
let sectionJaAssistiu = document.querySelector('.ja-assistiu'); // alert
let btnCancelarComentario = document.querySelector('#btn-cancelar'); // btn cancelar formulario
let btnComentar = document.querySelector('#comentar'); // btn comentar formulario
let btnSeLogar = document.querySelector('.alert#alert-deixe-nota .btn-primary');

function iniciarComentario(scroll) {
  if (scroll) {
    //Scrola até a sessão comentarios e faz aparecer o text area
    scrollToPosition(sectionComentarios.offsetTop - 80);
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
    if (SESSION['id'] === 'NaN') {
      alertNotaSpan.textContent = `É necessário se logar para avaliar ${SESSION['nomeTitulo']}`;
      if (btnSeLogar.classList.contains('d-none')) {
        btnSeLogar.classList.toggle('d-none');
      }

    } else {
      alertNotaSpan.textContent = `É necessario deixar sua nota para ${SESSION['nomeTitulo']}!`;
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
  if (e.target === sectionJaAssistiu.querySelector('button')) {
    // Começa o comentario, no click do botão ao lado do titulo, com scroll
    iniciarComentario(false);
  }
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
window.onload = function () {
  avalUser.style.color = fragEstrelas.cinza[0];
}

//Verifica se o usuario deixou a nota ou se está em uma conta
formComentar.addEventListener('submit', function (eventForm) {
  if (avalUser.textContent === 'N/A' || SESSION['id'] === 'NaN') {
    avisarParaSeLogar(eventForm);
  }
});

comentarTextarea.addEventListener('input', function () {
  avisarParaSeLogar();
});

// Formatação das estrelas do comentar
let inputComentar = document.querySelector('#avaliacao-usuario-input');
estrelasComentario.addEventListener('mousemove', function (e) {
  console.log('move')
  if (SESSION['id'] === 'NaN') {
    avisarParaSeLogar();
  } else {
    if (e.target === estrelasImg[9]) {

      avalUser.textContent = 5;
      inputComentar.value = 5;
      avalUser.style.color = fragEstrelas.verde[0];
      for (let i = 0; i <= 9; i++)
        if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

    } else if (e.target === estrelasImg[8]) {

      avalUser.textContent = 4.5;
      inputComentar.value = 4.5;
      avalUser.style.color = fragEstrelas.verde[0];
      for (let i = 0; i <= 9; i++)
        if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
        else if (i === 9) // Ultimo lado direito
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

    } else if (e.target === estrelasImg[7]) {

      avalUser.textContent = 4;
      inputComentar.value = 4;
      avalUser.style.color = fragEstrelas.verde[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 8) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
        else if (i >= 8 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 8 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

    } else if (e.target === estrelasImg[6]) {

      avalUser.textContent = 3.5;
      inputComentar.value = 3.5;
      avalUser.style.color = fragEstrelas.amarelo[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 7) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
        else if (i >= 7 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 7 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

    } else if (e.target === estrelasImg[5]) {

      avalUser.textContent = 3;
      inputComentar.value = 3;
      avalUser.style.color = fragEstrelas.amarelo[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 6) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
        else if (i >= 6 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 6 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

    } else if (e.target === estrelasImg[4]) {

      avalUser.textContent = 2.5;
      inputComentar.value = 2.5;
      avalUser.style.color = fragEstrelas.amarelo[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 5) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
        else if (i >= 5 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 5 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

    } else if (e.target === estrelasImg[3]) {

      avalUser.textContent = 2;
      inputComentar.value = 2;
      avalUser.style.color = fragEstrelas.laranja[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 4) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.laranja[1]);
        else if (i >= 4 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 4 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.laranja[2]);

    } else if (e.target === estrelasImg[2]) {

      avalUser.textContent = 1.5;
      inputComentar.value = 1.5;
      avalUser.style.color = fragEstrelas.vermelho[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 3) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
        else if (i >= 3 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 3 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

    } else if (e.target === estrelasImg[1]) {

      avalUser.textContent = 1;
      inputComentar.value = 1;
      avalUser.style.color = fragEstrelas.vermelho[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 2) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
        else if (i >= 2 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 2 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

    } else if (e.target === estrelasImg[0]) {

      avalUser.textContent = 0.5;
      inputComentar.value = 0.5;
      avalUser.style.color = fragEstrelas.vermelho[0];
      for (let i = 0; i <= 9; i++)
        if ((i % 2 === 0 || i === 0) && i < 1) //numero impar com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
        else if (i >= 1 && i % 2 === 0) // numero impar cinza (lado esquerdo)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
        else if (i >= 1 && i % 2 !== 0) // numero par cinza (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
        else //numero par com nota (lado direito)
          estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

    }
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
    return `${seg} segundos atrás`;

  } else if (tempoUsuario < hora) {

    let min = parseInt(tempoUsuario / minuto);
    return `${min} minutos atrás`;

  } else if (tempoUsuario < dia) {

    let horas = parseInt(tempoUsuario / hora);
    return `${horas} horas atrás`;

  } else if (tempoUsuario < semana) {

    let dias = parseInt(tempoUsuario / dia);
    return `${dias} dias atrás`;

  } else if (tempoUsuario < mes) {

    let semanas = parseInt(tempoUsuario / semana);
    return `${semanas} semanas atrás`;

  } else if (tempoUsuario < ano) {

    let meses = parseInt(tempoUsuario / mes);
    return `${meses} meses atrás`;

  } else {
    let anos = parseInt(tempoUsuario / ano);
    return `${anos} anos atrás`;

  }

}