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
    // Alterado de $breve_descricao para $descricao para consistência com o banco de dados e formulário
    $descricao = $_POST['descricao'] ?? ''; 
    $conteudo = $_POST['conteudo'] ?? '';
    $autor_id = $_SESSION['usuario_id'] ?? null; // Pega o ID do usuário logado como autor

    // Validação básica
    if (empty($titulo) || empty($conteudo) || empty($autor_id)) {
        $_SESSION['error_message'] = 'Por favor, preencha os campos de título e conteúdo do tutorial.';
        header('Location: adicionarTutorial.php');
        exit();
    }

    // Prepara a query SQL para inserção na tabela 'tutoriais'
    // ATENÇÃO: Coluna 'descricao' para a breve descrição
    $sql = "INSERT INTO tutoriais (titulo, descricao, conteudo, data_publicacao, autor_id) VALUES (?, ?, ?, NOW(), ?)";

    // Prepara a declaração para evitar SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        // 's' para string (titulo), 's' para string (descricao), 's' para string (conteudo), 'i' para integer (autor_id)
        $stmt->bind_param("sssi", $titulo, $descricao, $conteudo, $autor_id);

        // Executa a declaração
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Tutorial publicado com sucesso!';
            header('Location: tutoriais.php'); // Redireciona para a página de tutoriais
            exit();
        } else {
            $_SESSION['error_message'] = 'Erro ao publicar tutorial: ' . $stmt->error;
            header('Location: adicionarTutorial.php');
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro na preparação da query: ' . $conn->error;
        header('Location: adicionarTutorial.php');
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    // Se a requisição não for POST, redireciona
    header('Location: adicionarTutorial.php');
    exit();
}
?>