<?php
// deletar.php

require 'db.php'; // Inclui o arquivo db.php

// Verificando se o ID foi passado
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    if ($id <= 0) {
        header("Location: index.php?mensagem=ID inválido.");
        exit;
    }

    try {
        // Preparando a consulta para deleção
        $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount()) {
            // Redireciona com mensagem de sucesso
            header("Location: index.php?mensagem=Aluno excluído com sucesso!");
        } else {
            // Redireciona com mensagem de erro
            header("Location: index.php?mensagem=Aluno não encontrado ou já excluído.");
        }
    } catch (PDOException $e) {
        // Redireciona com mensagem de erro
        header("Location: index.php?mensagem=Erro ao excluir aluno: " . urlencode($e->getMessage()));
    }
} else {
    // Redireciona para a página principal se o ID não for passado
    header("Location: index.php?mensagem=ID não informado.");
}
?>
