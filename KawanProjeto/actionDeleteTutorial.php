<?php
// Garante que a sessão seja iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o arquivo de conexão com o banco de dados
// Certifique-se de que 'conexaoBd.php' está no mesmo diretório ou o caminho está correto.
require_once 'conexaoBd.php';

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Admin') {
    $_SESSION['error_message'] = 'Você não tem permissão para excluir tutoriais.';
    header('Location: index.php'); // Redireciona para a página inicial se não for admin
    exit();
}

// Verifica se o ID do tutorial foi passado via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tutorial_id = $_GET['id'];

    // Prepara a query SQL para excluir o tutorial
    // A coluna 'id' na tabela 'tutoriais' deve ser a chave primária.
    $sql_delete = "DELETE FROM tutoriais WHERE id = ?";

    if ($stmt = $conn->prepare($sql_delete)) {
        // Vincula o ID do tutorial como parâmetro inteiro ('i' para integer)
        $stmt->bind_param("i", $tutorial_id);

        // Executa a declaração
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Tutorial excluído com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao excluir o tutorial: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro na preparação da query de exclusão: ' . $conn->error;
    }

    $conn->close();

    // Redireciona de volta para a página de tutoriais
    header('Location: tutoriais.php');
    exit();

} else {
    // Se o ID não foi fornecido na URL
    $_SESSION['error_message'] = 'ID do tutorial não especificado para exclusão.';
    header('Location: tutoriais.php'); // Redireciona para a página de tutoriais
    exit();
}
?>