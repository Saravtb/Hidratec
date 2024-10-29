<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($id) {
        $sql = "UPDATE funcionarios SET nome='$nome', email='$email', telefone='$telefone' WHERE id='$id'";
        $mensagem = "Funcionário atualizado com sucesso!";
    } else {
        $sql = "INSERT INTO funcionarios (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";
        $mensagem = "Funcionário cadastrado com sucesso!";
    }

    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Primeiro, exclua os serviços relacionados a este funcionário
    $sql_delete_servicos = "DELETE FROM servicos WHERE funcionario_id='$delete_id'";
    $conn->query($sql_delete_servicos); // Executa a exclusão dos serviços relacionados
    
    // Depois, exclua o funcionário
    $sql_delete_funcionario = "DELETE FROM funcionarios WHERE id='$delete_id'";
    if ($conn->query($sql_delete_funcionario) === TRUE) {
        $mensagem = "Funcionário e serviços associados excluídos com sucesso!";
    } else {
        $mensagem = "Erro ao excluir funcionário: " . $conn->error;
    }
}

$funcionarios = $conn->query("SELECT * FROM funcionarios");

$funcionario = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $funcionario = $conn->query("SELECT * FROM funcionarios WHERE id='$edit_id'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <div class="container1">
        <h2>Cadastro de Funcionário</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $funcionario['id'] ?? ''; ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $funcionario['nome'] ?? ''; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $funcionario['email'] ?? ''; ?>">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" value="<?php echo $funcionario['telefone'] ?? ''; ?>">
            <button type="submit"><?php echo $funcionario ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Listagem de Funcionários</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $funcionarios->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['telefone']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
      
    </div>
</body>
</html>

