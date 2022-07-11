/* Input de buscar categoria animação*/
let inputProcurarCards = document.querySelector('#buscarCategoria');
let iconProcurarCards = document.querySelector('.icon-procurar-categoria');


inputProcurarCards.addEventListener('focus', function () {
  if (!(iconProcurarCards.classList.contains('focus')))
    iconProcurarCards.classList.toggle('focus');
});
inputProcurarCards.addEventListener('blur', function () {
  if (iconProcurarCards.classList.contains('focus'))
    iconProcurarCards.classList.toggle('focus');
});

/* ativar active das categorias */
let ulCategorias = document.querySelectorAll('.ul-categorias');
ulCategorias.forEach(function (ulElemento) {
  let linksCategorias = ulElemento.querySelectorAll('li a');
  linksCategorias.forEach(function (linkElemento) {
    if ($_GET['categoria'] && $_GET['categoria'] !== 'Ver+todas') {
      if (['Filmes', 'Animes', 'Series'].includes($_GET['categoria'])) {
        linkElemento.classList.remove('active');
        if (linkElemento.textContent === $_GET['categoria'])
          linkElemento.classList.add('active');
      }
    } else {
      if (linkElemento.textContent === 'Ver todas')
        linkElemento.classList.add('active');
    }
  })
});

let inputPesquisado = $_GET['procurar-categoria'] || $_GET['buscarCategoria'];

if (inputPesquisado) {
  //Removendo a concatenação do GET
  let contador;
  do {
    contador = inputPesquisado.indexOf('+')
    if (contador)
      inputPesquisado = inputPesquisado.replace('+', ' ');
  } while (contador !== -1)
  inputProcurarCards.value = inputPesquisado;
}

//Adicionar box-shadow ao campo de busca
let breadcrumb = document.querySelector('.breadcrumb');
let campoDeBusca = document.querySelector('#campo-de-busca');

document.addEventListener('scroll', function () {
  if (window.scrollY > breadcrumb.offsetTop)
    campoDeBusca.classList.add('box-shadow-categorias');
  else
    campoDeBusca.classList.remove('box-shadow-categorias');
});

//Impedindo evento no btn apagar 
let btnModoAdminApagarTitulo = document.querySelectorAll('.opcao-admin-apagar');
btnModoAdminApagarTitulo.forEach((elementoBtn) => {
  elementoBtn.addEventListener('click', (event) => {
    event.preventDefault();
  });
});

//Alternando valores do modal
let btnsButtonApagarTitulo = document.querySelectorAll('.opcao-admin-apagar');
let nomesTituloModal = document.querySelectorAll('.span-nome-titulo');
let btnSubmitApagarTitulo = document.querySelector('#btn-apagar-titulo');

btnsButtonApagarTitulo.forEach((el) => {
  el.addEventListener('click', () => {
    let arrayString = el.value;
    let idTitulo = arrayString.slice(1, arrayString.indexOf(','));
    let nomeTitulo = arrayString.slice((arrayString.indexOf(',') + 2), (arrayString.length - 1));


    nomesTituloModal.forEach((span) => {
      span.textContent = nomeTitulo;
    });
    btnSubmitApagarTitulo.value = idTitulo;
  });
});
