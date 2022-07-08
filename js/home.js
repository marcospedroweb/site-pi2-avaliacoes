// Fazer a animação do input acontencer FEITO
// Fazer o "role para baixo" do banner funcionar FEITO
// Fazer a troca de categoria dos mês

/* SCROLL SUAVE AO CLICAR*/
const roleMouse = document.querySelector('#role-para-baixo a[href^="#"]');

roleMouse.addEventListener('click', scrollToIdOnClick);


let categoria = $_GET['categoria'];
//Verificação, se existe no bd a categoria escolhida
if ((categoria !== 'Filmes' && categoria !== 'Animes' && categoria !== 'Series') || (categoria.length === 0))
  categoria = '';

/* TROCA DE BOTÕES DESTAQUES*/
let btnsDestaques = document.querySelector('.buttons-section');
let linksDestaques = btnsDestaques.querySelectorAll('a');
// Troca de active apos recarregar a pagina
linksDestaques.forEach(function (element) {
  if (['Filmes', 'Animes', 'Series'].includes(categoria)) {
    if (element.textContent === categoria)
      element.classList.add('active');
    else if (element.classList.contains('active'))
      element.classList.remove('active');
    scrollToPosition(document.querySelector('.buttons-section').offsetTop - 80);
  }
});

// Troca de active um pouco antes de recarregar a pagina
btnsDestaques.addEventListener('click', function (event) {
  if ((event.target).classList.contains('btn')) {
    let atualActive = btnsDestaques.querySelector('.active');
    atualActive.classList.remove('active');
    (event.target).classList.add('active');
  }
});
