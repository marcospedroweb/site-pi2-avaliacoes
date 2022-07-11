let formProcurar = document.querySelector('#form-procurar');
let inputProcurar = document.querySelector('#procurar-categoria');
let fakeIcon = document.querySelector('#fake-icon-procurar');
let trueIcon = document.querySelector('.icon-procurar');
let formDatalist = document.querySelector('#opcoes-datalist');

/* ANIMAÇÃO SIMPLES DE SUMIR/APARECER INPUT */
formProcurar.addEventListener('mouseover', function () {
  let elementoFocado = document.activeElement;
  inputProcurar.focus();
  if (elementoFocado === inputProcurar || inputProcurar.length > 0) {
    if (!fakeIcon.classList.contains('d-none')) {
      fakeIcon.classList.toggle('d-none');
      trueIcon.classList.toggle('elemento-visivel')
      inputProcurar.classList.toggle('elemento-visivel')
    }
  }
});

document.body.addEventListener('click', function (e) {
  if (e.target !== formProcurar && e.target !== inputProcurar && e.target !== formDatalist && e.target !== fakeIcon) {
    if (!(inputProcurar.value.length)) {
      if (fakeIcon.classList.contains('d-none')) {
        fakeIcon.classList.toggle('d-none');
        trueIcon.classList.toggle('elemento-visivel')
        inputProcurar.classList.toggle('elemento-visivel')
      }
    }
  }
});