<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Diálogo Deltarune</title>
  <style>
    @font-face {
      font-family: 'deltarune'; 
      src: url('../fonts/undertale-deltarune-text-font-extended.otf') format('truetype');
    }

    body {
      background-color: black;
      color: white;
      font-family: 'deltarune', monospace;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .dialog-box {
      width: 700px;
      padding: 30px;
      border: 4px solid white;
      background-color: rgba(0, 0, 0, 0.85);
      box-shadow: 0 0 20px white;
      font-size: 22px;
      line-height: 1.5;
      white-space: pre-wrap;
      position: relative;
    }

    .next-button {
      display: none;
      margin-top: 20px;
      padding: 10px 20px;
      border: 2px solid white;
      background: black;
      color: white;
      font-family: 'deltarune';
      font-size: 18px;
      cursor: pointer;
    }

    .next-button:hover {
      background: white;
      color: black;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="dialog-box" id="dialog"></div>
  <button class="next-button" id="nextBtn">Volver al inicio</button>
</div>
<script>
  const dialog = document.getElementById('dialog');
  const nextBtn = document.getElementById('nextBtn');

  const texto = "Hola, soy Sore! Soy una chica trans súper fan de los videojuegos, mis favoritos siendo los indies y shooters, siendo mis favoritos celeste, borderlands y deltarune! \n\nAmo a los animales en general, son mi cosa favorita en el mundo! Aunque tengo cierta debilidad a los gatos, no es mi culpa que sean tan cool\n\nMe encanta aprender y discutir sobre cualquier tema relacionado con la ciencia, especialmente medicina veterinaria\n\n¿Estás listo para continuar?";
  let i = 0;

  function escribirTexto() {
    if (i < texto.length) {
      dialog.textContent += texto.charAt(i);
      i++;
      setTimeout(escribirTexto, 30); // velocidad de letras
    } else {
      nextBtn.style.display = 'inline-block';
    }
  }

  escribirTexto();

  nextBtn.onclick = () => {
    window.location.href = 'website.php';
  };
</script>

</body>
</html>
