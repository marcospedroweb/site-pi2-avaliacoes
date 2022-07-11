/* SISTEMA DE ESTRELAS*/
let cardAvaliacao = document.querySelectorAll('.card-avaliacao');
let cardEstrelas = document.querySelectorAll('.card-estrelas');
let cardNome = document.querySelectorAll('.card-nome');

let fragEstrelas = {
  cinza: ['#939393', './imgs/Metade - cinza - esquerda.png', './imgs/Metade - cinza - direita.png'],
  vermelho: ['#ff4122', './imgs/Metade - vermelho - esquerda.png', './imgs/Metade - vermelho - direita.png'],
  laranja: [' #ffa500', './imgs/Metade - laranja - esquerda.png', './imgs/Metade - laranja - direita.png'],
  amarelo: ['#f2f761', './imgs/Metade - amarelo - esquerda.png', './imgs/Metade - amarelo - direita.png'],
  verde: ['#62d2a2', './imgs/Metade - verde - esquerda.png', './imgs/Metade - verde - direita.png']
}

cardNome.forEach(function (texto) {
  if ((texto.textContent).length > 13)
    texto.textContent = `${(texto.textContent).slice(0, 13)}...`;
});

cardAvaliacao.forEach(function (avaliacao, indice) {
  let avaliacaoNumero = parseFloat(avaliacao.textContent);
  let estrelasImg = cardEstrelas[indice].querySelectorAll('img');

  if (avaliacaoNumero == 5) {

    avaliacao.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (avaliacaoNumero >= 4.5) {

    avaliacao.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
      else if (i === 9) // Ultimo lado direito
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (avaliacaoNumero >= 4) {

    avaliacao.style.color = fragEstrelas.verde[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 8) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[1]);
      else if (i >= 8 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 8 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.verde[2]);

  } else if (avaliacaoNumero >= 3.5) {

    avaliacao.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 7) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 7 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 7 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (avaliacaoNumero >= 3) {

    avaliacao.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 6) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 6 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 6 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (avaliacaoNumero >= 2.5) {

    avaliacao.style.color = fragEstrelas.amarelo[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 5) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[1]);
      else if (i >= 5 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 5 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.amarelo[2]);

  } else if (avaliacaoNumero >= 2) {

    avaliacao.style.color = fragEstrelas.laranja[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 4) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.laranja[1]);
      else if (i >= 4 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 4 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.laranja[2]);

  } else if (avaliacaoNumero >= 1.5) {

    avaliacao.style.color = fragEstrelas.laranja[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 3) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 3 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 3 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

  } else if (avaliacaoNumero >= 1) {

    avaliacao.style.color = fragEstrelas.vermelho[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 2) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 2 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 2 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

  } else if (avaliacaoNumero > 0) {

    avaliacao.style.color = fragEstrelas.vermelho[0];
    for (let i = 0; i <= 9; i++)
      if ((i % 2 === 0 || i === 0) && i < 1) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[1]);
      else if (i >= 1 && i % 2 === 0) // numero impar cinza (lado esquerdo)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else if (i >= 1 && i % 2 !== 0) // numero par cinza (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.vermelho[2]);

  } else if (avaliacaoNumero === 0) {
    avaliacao.textContent = 'N/A';
    avaliacao.style.color = fragEstrelas.cinza[0];
    for (let i = 0; i <= 9; i++)
      if (i % 2 === 0 || i === 0) //numero impar com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[1]);
      else //numero par com nota (lado direito)
        estrelasImg[i].setAttribute('src', fragEstrelas.cinza[2]);

  }
});