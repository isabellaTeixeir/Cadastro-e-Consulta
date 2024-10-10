<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" href="/atividade_senai/css/style.css">
</head>
<body>
    <!-- Container de Cadastro -->
    <div class="container cadastro-container">
        <h1>Cadastro de Alunos</h1>

        <!-- Exibição de Mensagens -->
        <?php
        if (isset($_GET['mensagem'])) {
            $mensagem = htmlspecialchars($_GET['mensagem']); // Sanitiza a mensagem para evitar XSS
            echo "<p class='mensagem'>$mensagem</p>";
        }
        ?>

        <form method="POST" action="cadastro.php" class="form">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="curso">Curso:</label>
            <input type="text" name="curso" required>

            <input type="submit" value="Cadastrar" class="btn cadastrar-btn">
        </form>
    </div>

    <!-- Container de Lista de Alunos -->
    <div class="container lista-container">
        <h2>Lista de Alunos</h2>

        <!-- Campo de Pesquisa -->
        <form method="GET" action="" class="search-form">
            <input type="text" name="pesquisa" placeholder="Pesquisar por Nome ou Curso" value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" required>
            <input type="submit" value="Buscar" class="btn buscar-btn">
        </form>

        <table>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Email</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>

            <?php
            require 'db.php'; // Inclui o arquivo db.php

            // Filtrando pesquisa
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

            if (!empty($pesquisa)) {
                // Usando prepared statements para prevenir SQL Injection
                $stmt = $pdo->prepare("SELECT * FROM alunos WHERE nome LIKE :pesquisa OR curso LIKE :pesquisa");
                $stmt->execute(['pesquisa' => '%' . $pesquisa . '%']);
            } else {
                $stmt = $pdo->query("SELECT * FROM alunos");
            }

            $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($alunos) > 0) {
                foreach ($alunos as $row) {
                    // Sanitização de saída para prevenir XSS
                    $nome = htmlspecialchars($row['nome']);
                    $idade = htmlspecialchars($row['idade']);
                    $email = htmlspecialchars($row['email']);
                    $curso = htmlspecialchars($row['curso']);
                    $id = htmlspecialchars($row['id']);

                    echo "<tr>
                        <td>{$nome}</td>
                        <td>{$idade}</td>
                        <td>{$email}</td>
                        <td>{$curso}</td>
                        <td><a href='deletar.php?id={$id}' class='btn excluir-btn' onclick=\"return confirm('Tem certeza que deseja excluir este aluno?');\">Excluir</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum aluno encontrado.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
