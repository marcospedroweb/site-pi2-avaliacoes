let alertWarning = document.querySelector('#alert-erro');
let alertSuccess = document.querySelector('#alert-sucesso');
let spanErro = document.querySelector('#span-erro');
let btnFecharAviso = document.querySelectorAll('.btn-fechar-aviso');

function mostrarAviso(mostrar, alert) {
  if (alert === 'erro') alert = alertWarning;
  else alert = alertSuccess;
  if (mostrar) {
    if (alert.classList.contains('d-none') && alert === alertWarning) {
      alert.classList.toggle('d-none');
      setTimeout(function () {
        alert.classList.toggle('alert-hidden');
      }, 300);
      alert.classList.add('alert-danger');
      alert.classList.remove('alert-warning');
      setTimeout(function () {
        alert.classList.add('alert-warning');
        alert.classList.remove('alert-danger');
      }, 700);
    } else if (alert.classList.contains('d-none') && alert === alertSuccess) {
      alert.classList.toggle('d-none');
      setTimeout(function () {
        alert.classList.toggle('alert-hidden');
      }, 200);
      alert.style.backgroundColor = '#60ddb9';
      setTimeout(function () {
        alert.style.backgroundColor = '#1fab89';
      }, 500);
    }
  } else {
    if (!alert.classList.contains('alert-hidden') && alert === alertWarning) {
      alert.classList.toggle('alert-hidden');
      setTimeout(function () {
        alert.classList.toggle('d-none');
      }, 200);
      alert.classList.remove('alert-danger');
      alert.classList.add('alert-warning');
    } else if (
      !alert.classList.contains('alert-hidden') &&
      alert === alertSuccess
    ) {
      alert.classList.toggle('alert-hidden');
      setTimeout(function () {
        alert.classList.toggle('d-none');
      }, 200);
      alert.style.backgroundColor = '#1fab89';
    }
  }
}

btnFecharAviso.forEach((el) => {
  el.addEventListener('click', () => {
    if (el.getAttribute('id') === 'btn-erro') mostrarAviso(false, 'erro');
    else mostrarAviso(false, 'sucesso');
  });
});

if (variaveisPHP['sucesso'] === '1') mostrarAviso(true, 'sucesso');
if (variaveisPHP['erro'] === '1') mostrarAviso(true, 'erro');
