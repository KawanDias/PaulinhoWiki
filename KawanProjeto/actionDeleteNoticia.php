<?php
session_start();
require_once 'conexaoBd.php'; // Inclua sua conexão com o banco de dados

// Verifica se o usuário está logado e se tem permissão de Admin
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Admin') {
    $_SESSION['error_message'] = 'Você não tem permissão para excluir notícias.';
    header('Location: noticias.php');
    exit();
}

// Verifica se o ID da notícia foi passado via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $noticia_id = $_GET['id'];

    // Prepara a query SQL para deletar a notícia
    $sql = "DELETE FROM noticias WHERE id = ?";

    // Prepara a declaração para evitar SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        // 'i' para integer (ID da notícia)
        $stmt->bind_param("i", $noticia_id);

        // Executa a declaração
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Notícia excluída com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao excluir notícia: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro na preparação da query: ' . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    $_SESSION['error_message'] = 'ID da notícia não fornecido.';
}

// Redireciona de volta para a página de notícias
header('Location: noticias.php');
exit();
?>