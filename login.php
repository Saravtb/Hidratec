<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
    } else {
        $error = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
    <style>
        html, body {
    height: 100%; 
    margin: 0; 
}

        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background: linear-gradient(to bottom, #ffffff, #234467bd); 
            background-attachment: fixed; 
            background-size: cover; 
}
            
        
        div {
            background-color: rgba(0,0,0,0.7);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 25px;
            color: aliceblue;
            
        }
        input{
            padding: 25px;
            border: none;
            outline: none;
            font-size: 15px;
        }
        button{
            background-color:#234467;
            border: none;
            padding: 15px;
            width:100%;
            border-radius: 10px;
            color:aliceblue;
            
        }
        button:hover{
            background-color: #43648a;
            cursor: pointer;
        }
        h2{
            text-align: center;
            font-size: 30px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;

        }
    </style>
</head>
<body>
    <div>
        <h2>Login</h2>
        <br>
        <form method="post" action="">
            <label for="usuario"></label>
            <input type="text" name="usuario" placeholder="Admin" required>
            <br>
            <br>
            <label for="senha"></label>
            <input type="password" name="senha" placeholder="Senha" required>
            <br>
            <br>
            <button type="submit">Entrar</button>
            <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>
        </form>
    </div>
</body>
