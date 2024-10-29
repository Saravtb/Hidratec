<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php

$mensagem = "";


if (isset($_GET['concluir_id'])) {
    $concluir_id = intval($_GET['concluir_id']);
    $sql = "UPDATE servicos SET concluido = NOT concluido WHERE id='$concluir_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Status do serviço atualizado com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar status do serviço: " . $conn->error;
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM servicos WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Serviço excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir serviço: " . $conn->error;
    }
}


$servicos = $conn->query("SELECT s.id, s.nome, s.descricao, s.preco, f.nome AS funcionario_nome, s.concluido 
                           FROM servicos s 
                           JOIN funcionarios f ON s.funcionario_id = f.id");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Serviços</title>
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
    
    <div class="container">
        <h2>Listagem de Serviços</h2>
        <?php if ($mensagem) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>
       
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Funcionário</th>
                <th>Concluído</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $servicos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['preco']); ?></td>
                <td><?php echo htmlspecialchars($row['funcionario_nome']); ?></td>
                <td>
                    <a href="?concluir_id=<?php echo $row['id']; ?>" title="Clique para alterar o status">
                        <?php echo $row['concluido'] ? "✅" : "❌"; ?>
                    </a>
                </td>
                <td>
                    <a href="cadastro_servico.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>



