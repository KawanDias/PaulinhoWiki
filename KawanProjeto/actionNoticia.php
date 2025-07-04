<?php
session_start();
require_once 'conexaoBd.php'; // Certifique-se de que sua conexão com o BD está incluída e funcional.

// Verifica se a requisição é POST e se o usuário é Admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basicamente, a mesma verificação de permissão para ter certeza
    if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Admin') {
        $_SESSION['error_message'] = 'Você não tem permissão para realizar esta ação.';
        header('Location: index.php');
        exit();
    }

    // Recebe os dados do formulário
    $titulo = $_POST['titulo'] ?? '';
    $conteudo = $_POST['conteudo'] ?? '';
    $autor_id = $_SESSION['usuario_id'] ?? null; // Pega o ID do usuário logado como autor

    // Validação básica (você pode adicionar mais validações)
    if (empty($titulo) || empty($conteudo) || empty($autor_id)) {
        $_SESSION['error_message'] = 'Por favor, preencha todos os campos obrigatórios.';
        header('Location: adicionarNoticia.php'); // Redireciona de volta ao formulário
        exit();
    }

    // Prepara a query SQL para inserção
    // ATENÇÃO: Verifique o nome da sua tabela de notícias. Pela imagem do erro, parece ser 'noticias' ou 'Nova'.
    // Use o nome correto da sua tabela aqui. Vou usar 'noticias' como exemplo.
    $sql = "INSERT INTO noticias (titulo, conteudo, data_publicacao, autor_id) VALUES (?, ?, NOW(), ?)";

    // Prepara a declaração para evitar SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        // 's' para string, 'i' para integer
        $stmt->bind_param("ssi", $titulo, $conteudo, $autor_id);

        // Executa a declaração
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Notícia publicada com sucesso!';
            header('Location: noticias.php'); // Redireciona para a página de notícias
            exit();
        } else {
            $_SESSION['error_message'] = 'Erro ao publicar notícia: ' . $stmt->error;
            header('Location: adicionarNoticia.php'); // Redireciona de volta
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro na preparação da query: ' . $conn->error;
        header('Location: adicionarNoticia.php'); // Redireciona de volta
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    // Se a requisição não for POST, redireciona para a página inicial ou de adição
    header('Location: adicionarNoticia.php');
    exit();
}
?>