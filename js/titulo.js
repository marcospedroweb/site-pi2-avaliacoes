let buttonSection = document.querySelectorAll('.buttons-section .btn');
let manipularTituloText = document.querySelector('#manipular-titulos-text');

buttonSection.forEach(function (btn, indice) {
  if (btn.classList.contains('active'))
    btn.classList.remove('active');//Remove o active de todos os buttons
  if (btn.classList.contains('disabled'))
    btn.classList.remove('disabled');
  if (variaveisPHP['criar-titulo'] === '1' && indice === 0) {
    if (!(btn.classList.contains('active'))) {
      btn.classList.toggle('disabled');
      btn.classList.toggle('active');//Adiciona o active naquele button especifico
    }
    manipularTituloText.textContent = "Criar titulo";
  } else if (variaveisPHP['editar-titulo'] === '1' && indice === 1) {
    if (!(btn.classList.contains('active'))) {
      btn.classList.toggle('disabled');
      btn.classList.toggle('active');//Adiciona o active naquele button especifico
    }
    manipularTituloText.textContent = "Editar titulo";
  } else if (variaveisPHP['apagar-titulo'] === '1' && indice === 2) {
    if (!(btn.classList.contains('active'))) {
      btn.classList.toggle('disabled');
      btn.classList.toggle('active');//Adiciona o active naquele button especifico
    }
    manipularTituloText.textContent = "Apagar titulo";
  }
});


//Fomatação visual do preview
let temporadaTitulo = document.querySelector('#temporadas-titulo') || '';
let episodiosTitulo = document.querySelector('#episodios-titulo') || '';
let duracaoTitulo = document.querySelector('#duracao-titulo') || '';

function atualizarInformacoes() {
  if (temporadaUnica.value === 'true') {
    //Formatação das temporadas
    if (formTemporadas.value !== '') {
      if (temporadaTitulo.classList.contains('d-none'))
        temporadaTitulo.classList.toggle('d-none');
      temporadaTitulo.textContent = `${formTemporadas.value}° temporada`;
    } else {
      if (!(temporadaTitulo.classList.contains('d-none')))
        temporadaTitulo.classList.toggle('d-none');
    }
    //Formatação dos episodios
    if (formEpisodios.value !== '') {
      let stringEpisodios;
      formEpisodios.value === '1' ? stringEpisodios = 'epísodio' : stringEpisodios = 'epísodios';
      if (episodiosTitulo.classList.contains('d-none'))
        episodiosTitulo.classList.toggle('d-none');
      episodiosTitulo.textContent = `${formEpisodios.value} ${stringEpisodios}`;
    } else {
      if (!(episodiosTitulo.classList.contains('d-none')))
        episodiosTitulo.classList.toggle('d-none');
    }
  } else {
    if (formDuracao.value !== '') {
      if (duracaoTitulo.classList.contains('d-none'))
        duracaoTitulo.classList.toggle('d-none');
      //Formatação da duração
      let tempoEmMinutos = formDuracao.value;
      if (tempoEmMinutos < 60)
        duracaoTitulo.textContent = `${tempoEmMinutos}min`
      else {
        let horasFormatada = parseFloat(tempoEmMinutos) / 60;
        let horasFormataEmString = horasFormatada.toString();
        let horasEmMinutos = horasFormataEmString.slice(horasFormataEmString.indexOf('.'));
        horasEmMinutos = parseFloat(`0${horasEmMinutos}`);
        horasEmMinutos = Number.isInteger((horasEmMinutos * 60) / 60) ? 0 : horasEmMinutos * 60;
        duracaoTitulo.textContent = `${parseInt(horasFormatada)}h ${parseInt(horasEmMinutos)}min`;
      }
    } else if (formEpisodios.value !== '' || formTemporadas.value !== '') {
      let stringEpisodios, stringTemporadas;
      formEpisodios.value === '1' ? stringEpisodios = 'epísodio' : stringEpisodios = 'epísodios';
      formTemporadas.value === '1' ? stringTemporadas = 'temporada' : stringTemporadas = 'temporadas';
      if (temporadaTitulo.classList.contains('d-none'))
        temporadaTitulo.classList.toggle('d-none');
      if (episodiosTitulo.classList.contains('d-none'))
        episodiosTitulo.classList.toggle('d-none');
      temporadaTitulo.textContent = `${formTemporadas.value} ${stringTemporadas}`;
      episodiosTitulo.textContent = `${formEpisodios.value} ${stringEpisodios}`;
    }
  }
}

//Input de dados
let formTitulo = document.querySelector('#form-cadastrar-titulo');
let formNome = document.querySelector('#titulo');
let formCapa = document.querySelector('#capa-titulo');
let formPosX = document.querySelector('#posX');
let formPosY = document.querySelector('#posY');
let formCategoria = document.querySelector('#categoria');
let formSinopse = document.querySelector('#sinopse');
let previewPosXY = document.querySelectorAll('.img-titulo input');
let cardNomePreview = document.querySelector('.card-nome');
let temporadaUnica = document.querySelector('#temporadaUnica');
let formTemporadas = document.querySelector('#temporadas');
let formEpisodios = document.querySelector('#episodios');
let formDuracao = document.querySelector('#duracao');

if ([variaveisPHP['editar-titulo'], variaveisPHP['apagar-titulo']].includes('1')) {
  let arrayElementosInput = [
    formTitulo,
    formNome,
    formPosX,
    formPosY,
    formCategoria,
    formSinopse,
    previewPosXY,
    cardNomePreview,
    temporadaUnica,
    formTemporadas,
    formEpisodios,
    formDuracao
  ];
  arrayElementosInput.forEach((el) => {
    alterarDados(el);
  });
}

function alterarDados(elemento) {
  let previewImg = document.getElementById("img-preview");
  let previewImgCard = document.getElementById("preview-img-card");
  switch (elemento) {
    case formNome:
      let previewNome = document.querySelector('#titulo-nome-preview');
      let previewBreadcrumb = document.querySelector('#breadcrumb-nome-preview');
      previewBreadcrumb.textContent = elemento.value;
      previewNome.textContent = elemento.value;
      if ((elemento.value).length > 13)
        cardNomePreview.textContent = `${(elemento.value).slice(0, 13)}...`;
      else
        cardNomePreview.textContent = elemento.value;
      break;
    case formCapa:
      let src;
      if (variaveisPHP['editar-titulo'] === '1' && elemento)
        src = URL.createObjectURL(elemento.files[0]);
      else if (variaveisPHP['editar-titulo'] === '1')
        src = previewImgCard.style.backgroundImage;
      else
        src = URL.createObjectURL(elemento.files[0]);
      previewImgCard.style.background = `url(${src}) 0% 0% / cover no-repeat rgb(204, 204, 204)`;
      previewImg.style.background = `url(${src}) 0% 0% / cover no-repeat rgb(204, 204, 204)`;
      break;
    case posX:
      let inputPosX = document.querySelector('#posX').value;
      let inputPosY = document.querySelector('#posY').value;
      previewImgCard.style.backgroundPosition = `${inputPosX}% ${inputPosY}%`;
      previewImg.style.backgroundPosition = `${inputPosX}% ${inputPosY}%`;

      break;
    case posY:
      let inputPosXValor = document.querySelector('#posX').value;
      let inputPosYValor = document.querySelector('#posY').value;
      previewImgCard.style.backgroundPosition = `${inputPosXValor}% ${inputPosYValor}%`;
      previewImg.style.backgroundPosition = `${inputPosXValor}% ${inputPosYValor}%`;

      break;
    case formCategoria:
      let categoriaLink = document.querySelector('#categoria-preview');
      let categoriaTitulo = document.querySelector('#titulo-categoria-preview');
      let optionCategoria = formCategoria.children[formCategoria.selectedIndex];
      categoriaLink.textContent = optionCategoria.textContent;
      categoriaTitulo.textContent = (optionCategoria.textContent).replace('s', '');
      break;
    case formSinopse:
      let paragrafoSinopse = document.querySelector('#titulo-sinopse-preview');
      paragrafoSinopse.textContent = formSinopse.value;
      break;
    case previewPosXY[0]:
      document.querySelector('#posX').value = previewPosXY[0].value;
      document.querySelector('#posY').value = previewPosXY[1].value;
      previewImgCard.style.backgroundPosition = `${previewPosXY[0].value}% ${previewPosXY[1].value}%`;
      previewImg.style.backgroundPosition = `${previewPosXY[0].value}% ${previewPosXY[1].value}%`;
      break;
    case previewPosXY[1]:
      document.querySelector('#posX').value = previewPosXY[0].value;
      document.querySelector('#posY').value = previewPosXY[1].value;
      previewImgCard.style.backgroundPosition = `${previewPosXY[0].value}% ${previewPosXY[1].value}%`;
      previewImg.style.backgroundPosition = `${previewPosXY[0].value}% ${previewPosXY[1].value}%`;
      break;
    case temporadaUnica:
      let boxQtdDeTemporadas = document.querySelector('#qtd-temporadas');
      let boxEpisodios = document.querySelector('#box-episodios');
      let boxDuracao = document.querySelector('#box-duracao');
      if (temporadaUnica.value === 'true') {
        formEpisodios.required = true;
        formTemporadas.required = true;
        if (boxQtdDeTemporadas.classList.contains('d-none'))
          boxQtdDeTemporadas.classList.toggle('d-none');
        if (boxEpisodios.classList.contains('d-none'))
          boxEpisodios.classList.toggle('d-none');
        if (!(boxDuracao.classList.contains('d-none')))
          boxDuracao.classList.toggle('d-none');
      }
      else {
        formEpisodios.required = false;
        formTemporadas.required = false;
        if (boxQtdDeTemporadas.classList.contains('d-none'))
          boxQtdDeTemporadas.classList.toggle('d-none');
        if (boxEpisodios.classList.contains('d-none'))
          boxEpisodios.classList.toggle('d-none');
        if (boxDuracao.classList.contains('d-none'))
          boxDuracao.classList.toggle('d-none');
      }
      atualizarInformacoes();
      break;
    case formTemporadas:
      atualizarInformacoes();
      break;
    case formEpisodios:
      atualizarInformacoes();
      break;
    case formDuracao:
      atualizarInformacoes();
      break;
  }
}

formTitulo.addEventListener('input', function (e) {
  alterarDados(e.target);
});

previewPosXY[0].addEventListener('input', () => {
  alterarDados(previewPosXY[0]);
});

previewPosXY[1].addEventListener('input', () => {
  alterarDados(previewPosXY[1]);
});


