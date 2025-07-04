<?php
// Garante que a sessão seja iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexaoBd.php';

// Verifica se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário está logado e se tem permissão (Admin ou Tutor)
    if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] !== 'Admin' && $_SESSION['usuario_tipo'] !== 'Tutor')) {
        $_SESSION['error_message'] = 'Você não tem permissão para realizar esta ação.';
        header('Location: index.php');
        exit();
    }

    // Recebe os dados do formulário
    $id = $_POST['id'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $conteudo = $_POST['conteudo'] ?? '';
    $autor_id_logado = $_SESSION['usuario_id']; // ID do usuário logado

    // Validação básica
    if (empty($id) || empty($titulo) || empty($conteudo)) {
        $_SESSION['error_message'] = 'Por favor, preencha todos os campos obrigatórios do tutorial.';
        header('Location: editarTutorial.php?id=' . $id); // Redireciona de volta para a página de edição
        exit();
    }

    // Primeiro, busca o autor_id original do tutorial para verificar permissão do Tutor
    $sql_check_author = "SELECT autor_id FROM tutoriais WHERE id = ?";
    if ($stmt_check = $conn->prepare($sql_check_author)) {
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $original_autor_id = null;
        if ($result_check->num_rows > 0) {
            $original_autor_id = $result_check->fetch_assoc()['autor_id'];
        }
        $stmt_check->close();

        // Se for Tutor e não for o autor, impede a edição
        if ($_SESSION['usuario_tipo'] === 'Tutor' && $original_autor_id != $autor_id_logado) {
            $_SESSION['error_message'] = 'Você não tem permissão para editar este tutorial, pois não é o autor.';
            header('Location: tutoriais.php'); // Redireciona para a lista de tutoriais
            exit();
        }

        // Prepara a query SQL para atualização
        $sql_update = "UPDATE tutoriais SET titulo = ?, descricao = ?, conteudo = ?, data_publicacao = NOW() WHERE id = ?";

        if ($stmt = $conn->prepare($sql_update)) {
            // 's' (titulo), 's' (descricao), 's' (conteudo), 'i' (id)
            $stmt->bind_param("sssi", $titulo, $descricao, $conteudo, $id);

            // Executa a declaração
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Tutorial atualizado com sucesso!';
                header('Location: tutoriais.php?id=' . $id); // Redireciona para a página de detalhes (se existir) ou lista
                exit();
            } else {
                $_SESSION['error_message'] = 'Erro ao atualizar tutorial: ' . $stmt->error;
                header('Location: editarTutorial.php?id=' . $id);
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = 'Erro na preparação da query de atualização: ' . $conn->error;
            header('Location: editarTutorial.php?id=' . $id);
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Erro ao verificar o autor do tutorial: ' . $conn->error;
        header('Location: tutoriais.php');
        exit();
    }

    $conn->close();

} else {
    // Se a requisição não for POST, redireciona
    header('Location: tutoriais.php');
    exit();
}
?>