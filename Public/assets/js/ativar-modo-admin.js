if (variaveisPHP['id'] === '3') {
  let inputModoAdmin = document.querySelector('#input-modo-admin');
  if (variaveisPHP['id'] === '3' && variaveisPHP['modo-admin'] === '1')
    inputModoAdmin.checked = true;
  else
    inputModoAdmin.checked = false;

  inputModoAdmin.addEventListener('change', function () {
    window.location.href = "./serv-modo-admin.php";
  });
}
