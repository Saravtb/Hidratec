<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Página de Imagens</title>
<link href="https://fonts.googleapis.com/css2?family=Bakbak+One:wght@400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
html, body {
  height: 100%;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Bakbak One', sans-serif;
  padding: 0 144px;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content {
  flex: 1;
  padding: 20px 0;
}

.image-upload-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.arrow {
  font-size: 200px;
  cursor: pointer;
  user-select: none;
  padding: 0 20px;
  color: rgba(0, 0, 0, 0.5);
  transition: color 0.3s;
  margin: -700px 200px 30px; /* Unificar margens */
}

.arrow:hover {
  color: #000000;
}

.imagem-container {
  width: 300px;
  height: 300px;
  border: 2px dashed #ccc;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background-color: #ffffff;
  border-radius: 10px;
  margin-bottom: 1px;
  margin-top: 200px;
}

.imagem-container img {
  max-width: 100%;
  max-height: 100%;
  border-radius: 10px; 
}

.upload-button {
  margin-top: 10px;
  padding: 10px 20px;
  font-size: 18px;
  color: #000000;
  background-color: #a6b2c2;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: background-color 0.3s;
}

.upload-button:hover {
  background-color: #89929d;
}

.imagem-titulo {
  font-family: 'Baloo Bhai', cursive;
  margin-top: 10px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
}

.titulo-input {
  margin-top: 10px;
  padding: 5px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.arrow-container {
  display: flex;
  align-items: center;
  margin-top: 30px; 
}
</style>
</head>
<body>
<header class="header">
    <div class="logo">
        <h1>Hidratec</h1>
    </div>
    <nav class="navigation">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="cadastro_funcionario.php">Cadastro de Funcionários</a></li>
            <li><a href="cadastro_servico.php">Cadastro de Serviços</a></li>
            <li><a href="listagem_servicos.php">Lista de Serviços</a></li>
            <li><a href="mes.php">Destaques do Mês</a></li>
            <li><a href="login.php"><i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    </nav>
</header>
<div class="content">
  <div class="image-upload-container">
    <div class="imagem-container" id="imagemContainer">
      <p>Nenhum destaque adicionado</p>
    </div>
    <input type="text" id="tituloImagem" class="titulo-input" placeholder="Digite o título da imagem" oninput="atualizarTitulo()" />
    <div class="imagem-titulo" id="imagemTitulo">Carregue uma foto aqui</div>
    <input type="file" id="uploadImagem" accept="image/*" style="display: none;">
    <button class="upload-button" onclick="document.getElementById('uploadImagem').click()">Adicionar destaque</button>
    <div class="arrow-container">
      <div class="arrow" onclick="previousImage()">&#8249;</div>
      <div class="arrow" onclick="nextImage()">&#8250;</div>
    </div>
  </div>
</div>

<script>
let imagensCarregadas = [];
let imagemAtual = 0;

const uploadImagem = document.getElementById('uploadImagem');
const imagemContainer = document.getElementById('imagemContainer');
const imagemTitulo = document.getElementById('imagemTitulo');

uploadImagem.addEventListener('change', (event) => {
    const arquivos = Array.from(event.target.files);
    arquivos.forEach(arquivo => {
        if (arquivo.type.startsWith('image/')) { 
            const leitor = new FileReader();
            leitor.onload = function(e) {
                imagensCarregadas.push({ src: e.target.result, nome: arquivo.name });
                if (imagensCarregadas.length === 1) {
                    mostrarImagem();
                }
            };
            leitor.readAsDataURL(arquivo);
        } else {
            alert('Por favor, carregue apenas arquivos de imagem.'); 
        }
    });
});

function mostrarImagem() {
    if (imagensCarregadas.length > 0) {
        imagemContainer.innerHTML = `<img src="${imagensCarregadas[imagemAtual].src}" alt="Imagem carregada">`;
        imagemTitulo.textContent = imagensCarregadas[imagemAtual].nome;
        document.getElementById('tituloImagem').value = imagensCarregadas[imagemAtual].nome; 
    } else {
        imagemContainer.innerHTML = `<p>Nenhuma imagem adicionada</p>`;
        imagemTitulo.textContent = 'Carregue uma imagem para começar';
        document.getElementById('tituloImagem').value = ''; 
    }
}

function nextImage() {
    if (imagensCarregadas.length > 0) {
        imagemAtual = (imagemAtual + 1) % imagensCarregadas.length;
        mostrarImagem();
    }
}

function previousImage() {
    if (imagensCarregadas.length > 0) {
        imagemAtual = (imagemAtual - 1 + imagensCarregadas.length) % imagensCarregadas.length;
        mostrarImagem();
    }
}

function atualizarTitulo() {
    if (imagensCarregadas.length > 0) {
        imagensCarregadas[imagemAtual].nome = document.getElementById('tituloImagem').value; 
        imagemTitulo.textContent = imagensCarregadas[imagemAtual].nome; 
    }
}
</script>

</body>
</html>
