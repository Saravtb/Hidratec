<?php include('valida_sessao.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<audio id="background-music" loop autoplay>
        <source src="audio.mp3" type="audio/mpeg">
    </audio>
    
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

<main>
    <div class="container">
        <img src="qa.png" alt="Imagem QA" class="qa-image">
        <p class="welcome-text"></p>
    </div>
</main>
<script>
    const targetText = "Olá, seja bem-vindo(a) <?php echo $_SESSION['usuario'] ?>.";
    const typingDelay = 100;
    let currentIndex = 0;

    const textElement = document.querySelector(".welcome-text");

    function type() {
        if (currentIndex < targetText.length) {
            textElement.textContent += targetText.charAt(currentIndex);
            currentIndex++;
            setTimeout(type, typingDelay);
        }
    }

    type();
</script>
</body>
</html>


