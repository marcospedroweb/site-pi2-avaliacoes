let formCriarConta = document.querySelector('#form-conta');
let inputSenha = document.querySelector('#senha');
let inputConfirmarSenha = document.querySelector('#senha-confirmar');
let alertWarning = document.querySelector('.alert-warning');

formCriarConta.addEventListener('submit', function (e) {
  if (inputSenha.value !== inputConfirmarSenha.value) {
    e.preventDefault();
  }
});

if ($_GET['erro']) {
  if (alertWarning.classList.contains('d-none')) {
    alertWarning.classList.toggle('d-none');
    setTimeout(function () {
      alertWarning.classList.toggle('alert-hidden');
    }, 200);
    alertWarning.classList.add('alert-danger');
    alertWarning.classList.remove('alert-warning');
    setTimeout(function () {
      alertWarning.classList.toggle('alert-hidden');
      alertWarning.classList.add('alert-warning');
      alertWarning.classList.remove('alert-danger');
    }, 200);
  }
}

