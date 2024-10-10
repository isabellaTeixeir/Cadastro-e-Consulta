<?php
// cadastro.php

require 'db.php'; // Inclui o arquivo db.php

// Verificando se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletando e sanitizando os dados
    $nome = trim($_POST['nome']);
    $idade = (int)$_POST['idade'];
    $email = trim($_POST['email']);
    $curso = trim($_POST['curso']);

    // Validações básicas
    if (empty($nome) || empty($idade) || empty($email) || empty($curso)) {
        header("Location: index.php?mensagem=Todos os campos são obrigatórios.");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?mensagem=Formato de email inválido.");
        exit;
    }

    try {
        // Preparando a consulta para inserção
        $stmt = $pdo->prepare("INSERT INTO alunos (nome, idade, email, curso) VALUES (:nome, :idade, :email, :curso)");
        $stmt->execute([
            'nome' => $nome,
            'idade' => $idade,
            'email' => $email,
            'curso' => $curso
        ]);

        // Redireciona com mensagem de sucesso
        header("Location: index.php?mensagem=Aluno cadastrado com sucesso!");
    } catch (PDOException $e) {
        // Redireciona com mensagem de erro
        header("Location: index.php?mensagem=Erro ao cadastrar aluno: " . urlencode($e->getMessage()));
    }
} else {
    // Redireciona para a página principal se o acesso não for via POST
    header("Location: index.php");
}
?>
