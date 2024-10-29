<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
// Inicializa a variável mensagem
$mensagem = "";

// Processa o formulário de cadastro/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $funcionario_id = $_POST['funcionario_id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $concluido = isset($_POST['concluido']) ? 1 : 0;

    // Valida e prepara a consulta SQL
    if ($id) {
        $sql = "UPDATE servicos SET funcionario_id='$funcionario_id', nome='$nome', descricao='$descricao', preco='$preco', concluido='$concluido' WHERE id='$id'";
        $mensagem = "Serviço atualizado com sucesso!";
    } else {
        $sql = "INSERT INTO servicos (funcionario_id, nome, descricao, preco, concluido) VALUES ('$funcionario_id', '$nome', '$descricao', '$preco', '$concluido')";
        $mensagem = "Serviço cadastrado com sucesso!";
    }

    // Executa a consulta
    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

// Processa a exclusão de um serviço
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM servicos WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Serviço excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir serviço: " . $conn->error;
    }
}

// Obtém a listagem de serviços
$servicos = $conn->query("SELECT s.id, s.nome, s.descricao, s.preco, s.concluido, f.nome AS funcionario_nome FROM servicos s JOIN funcionarios f ON s.funcionario_id = f.id");

// Verifica se está editando um serviço
$servico = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $servico = $conn->query("SELECT * FROM servicos WHERE id='$edit_id'")->fetch_assoc();
}

// Obtém a lista de funcionários
$funcionarios = $conn->query("SELECT id, nome FROM funcionarios");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Serviço</title>
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
    <div class="container2">
        <h2>Cadastro de Serviço</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $servico['id'] ?? ''; ?>">
            <label for="funcionario_id">Funcionário</label>
            <select name="funcionario_id" required>
                <?php while ($row = $funcionarios->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($servico && $servico['funcionario_id'] == $row['id']) echo 'selected'; ?>><?php echo $row['nome']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="nome">Nome do cliente:</label>
            <input type="text" name="nome" value="<?php echo $servico['nome'] ?? ''; ?>" required>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao"><?php echo $servico['descricao'] ?? ''; ?></textarea>
            <label for="preco">Preço:</label>
            <input type="text" name="preco" value="<?php echo $servico['preco'] ?? ''; ?>" required>
            <label for="concluido">Concluído:</label>
<div class="checkbox-container">
    <input type="checkbox" name="concluido" id="concluido" <?php if ($servico && $servico['concluido']) echo 'checked'; ?>>
    <label for="concluido" class="checkbox-label">Marcar como concluído</label>
</div>

            <button type="submit"><?php echo $servico ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (!empty($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Listagem de Serviços</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome do cliente</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Funcionário</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $servicos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td><?php echo $row['preco']; ?></td>
                <td><?php echo $row['funcionario_nome']; ?></td>
                <td><?php echo $row['concluido'] ? '✅' : '❌'; ?></td>
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


