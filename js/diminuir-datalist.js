let inputNavbar = document.querySelector('#procurar-categoria');//input de busca do navbar
let datalistNavbar = document.querySelector('#opcoes-datalist');//datalist do navbar
let inputCategorias = document.querySelector('#buscarCategoria');//input de busca de categorias
let datalistCategorias = document.querySelector('#datalist-categorias');//datalist de categorias
let templateContent = document.querySelector('#listtemplate').content;//template

inputNavbar.addEventListener('input', function () {
  mostrarOption(inputNavbar, datalistNavbar);
});

inputNavbar.addEventListener('focus', function () {
  mostrarOption(inputNavbar, datalistNavbar);
});

if (inputCategorias) {
  inputCategorias.addEventListener('input', function () {
    mostrarOption(inputCategorias, datalistCategorias);
  });
  inputCategorias.addEventListener('focus', function () {
    mostrarOption(inputCategorias, datalistCategorias);
  });
}


function mostrarOption(input, datalist) {
  while (datalist.children.length) datalist.removeChild(datalist.firstChild);//Enquanto datalist tiver option, remove
  let inputVal = new RegExp(input.value.trim(), 'i');//Compila aquele texto e remove os espaços em branco
  let set = Array.prototype.reduce.call(templateContent.cloneNode(true).children, function inputFilter(frag, item, i) {
    if (inputVal.test(item.value) && frag.children.length < 6) frag.appendChild(item);
    return frag;
  }, document.createDocumentFragment());//Cria a option
  datalist.appendChild(set);//Adiciona aquela option ao datalist
}
