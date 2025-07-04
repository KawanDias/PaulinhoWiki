<?php
// Garante que a sessão seja iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexaoBd.php';
require_once 'header.php'; // Inclui o cabeçalho com a navegação

// Verifica se o usuário está logado e se tem permissão (Admin ou Tutor)
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] !== 'Admin' && $_SESSION['usuario_tipo'] !== 'Tutor')) {
    $_SESSION['error_message'] = 'Você não tem permissão para editar tutoriais.';
    header('Location: index.php');
    exit();
}

$tutorial = null;
$tutorial_id = null;

// Verifica se um ID de tutorial foi passado via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $tutorial_id = $_GET['id'];

    // Prepara a query para buscar os dados do tutorial
    $sql = "SELECT id, titulo, descricao, conteudo, autor_id FROM tutoriais WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $tutorial_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tutorial = $result->fetch_assoc();

            // Verifica se o usuário é o autor do tutorial ou um Admin
            if ($_SESSION['usuario_tipo'] === 'Tutor' && $tutorial['autor_id'] != $_SESSION['usuario_id']) {
                $_SESSION['error_message'] = 'Você não tem permissão para editar este tutorial, pois não é o autor.';
                header('Location: tutoriais.php');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Tutorial não encontrado.';
            header('Location: tutoriais.php');
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro na preparação da query: ' . $conn->error;
        header('Location: tutoriais.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = 'ID do tutorial não especificado para edição.';
    header('Location: tutoriais.php');
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tutorial - Minecraft Wiki</title>
    <link rel="icon" type="image/x-xicon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            padding-top: 70px; /* Altura da navbar */
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centraliza o conteúdo dentro do container */
        }
        .form-container h2 {
            color: #218838;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            width: 100%;
        }
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        .btn-submit {
            background-color: #28a745; /* Verde Bootstrap */
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%; /* Ocupa a largura total */
        }
        .btn-submit:hover {
            background-color: #218838; /* Verde mais escuro no hover */
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container form-container">
        <h2>Editar Tutorial</h2>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger text-center">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>

        <?php if ($tutorial): ?>
            <form action="actionEditarTutorial.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tutorial['id']); ?>">

                <div class="mb-3">
                    <input type="text" class="form-control" name="titulo" placeholder="Título do Tutorial"
                           value="<?php echo htmlspecialchars($tutorial['titulo']); ?>" required>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" name="descricao" rows="3" placeholder="Breve Descrição (opcional)"><?php echo htmlspecialchars($tutorial['descricao']); ?></textarea>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" name="conteudo" rows="10" placeholder="Escreva o conteúdo completo do tutorial aqui..." required><?php echo htmlspecialchars($tutorial['conteudo']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-submit">Salvar Alterações</button>
            </form>
        <?php else: ?>
            <p>Não foi possível carregar o tutorial para edição.</p>
            <a href="tutoriais.php" class="btn btn-primary mt-3">Voltar para Tutoriais</a>
        <?php endif; ?>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>