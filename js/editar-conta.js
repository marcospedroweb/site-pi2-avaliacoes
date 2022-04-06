let imgPreview = document.querySelector('#nova-img-div');
let inputFile = document.querySelector('#novo-avatar');
let avatarAtualUsuario = document.querySelector('#usuario-avatar');

imgPreview.addEventListener('click', () => {
  inputFile.click();
});

inputFile.addEventListener('input', () => {
  let src = URL.createObjectURL(inputFile.files[0]);
  imgPreview.style.background = `url(${src}) 0% 0% / cover no-repeat rgb(204, 204, 204)`;
  avatarAtualUsuario.style.background = `url(${src}) 0% 0% / cover no-repeat rgb(204, 204, 204)`;
});

//Atualizando background position
let inputRange = document.querySelectorAll("input[type='range']");
let inputPosX = document.querySelector('#avatar-posX');
let inputPosY = document.querySelector('#avatar-posY');

function atualizarPosition() {
  imgPreview.style.backgroundPosition = `${inputPosX.value}% ${inputPosY.value}%`;
  avatarAtualUsuario.style.backgroundPosition = `${inputPosX.value}% ${inputPosY.value}%`;
}

inputRange.forEach((el) => {
  el.addEventListener('input', function () {
    if (el === inputPosX) {
      atualizarPosition();
    } else {
      atualizarPosition();
    }
  });
});

//Zoom da imagem
let btnsZoom = document.querySelectorAll('.btn-zoom');
let maisZoom = document.querySelector('#mais-zoom');
let menosZoom = document.querySelector('#menos-zoom');
let inputZoom = document.querySelector('#input-zoom');
let imgSize = imgPreview.style.backgroundSize !== 'cover' ? parseInt((imgPreview.style.backgroundSize).replace('%', '')) : 0;

function zoomImagem(zoom) {
  imgSize = imgPreview.style.backgroundSize !== 'cover' ? parseInt((imgPreview.style.backgroundSize).replace('%', '')) : 0;
  if (zoom) {
    imgSize += 10;
    imgPreview.style.backgroundSize = `${imgSize}%`;
    avatarAtualUsuario.style.backgroundSize = `${imgSize}%`;
    inputZoom.value = imgSize;
  } else {
    imgSize -= imgSize === 0 ? 0 : 10;
    imgPreview.style.backgroundSize = `${imgSize}%`;
    avatarAtualUsuario.style.backgroundSize = `${imgSize}%`;
    inputZoom.value = imgSize;
  }
}

btnsZoom.forEach((el) => {
  el.addEventListener('click', () => {
    if (el === maisZoom)
      zoomImagem(true);
    else
      zoomImagem(false);
  });
});

