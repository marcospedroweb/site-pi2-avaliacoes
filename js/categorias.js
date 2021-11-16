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
    if ($_GET['categoria']) {
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

if ($_GET['nome'])
  inputProcurarCards.value = $_GET['nome'];
