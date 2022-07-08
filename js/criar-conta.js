let formCriarConta = document.querySelector('#form-conta');
let inputSenha = document.querySelector('#senha');
let inputConfirmarSenha = document.querySelector('#senha-confirmar');

formCriarConta.addEventListener('submit', function (e) {
  if (inputSenha.value !== inputConfirmarSenha.value) {
    e.preventDefault();
    mostrarAviso(true, 'erro');
  }
});
