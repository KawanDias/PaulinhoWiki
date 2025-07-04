<?php
// Certifique-se de que NÃO HÁ NENHUM CARACTERE (espaços, linhas vazias) antes desta linha de abertura <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexaoBd.php'; // Configuração do banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $email = trim($_POST['email']);
    $plain_password = $_POST['senha'];
    $dataNascimento = $_POST['dataNascimento'];
    $nome = trim($_POST['nome']); // Nome do usuário
    $usuario_tipo = $_POST['usuario_tipo']; // Certifique-se de que este campo está no seu formulário

    $profilePicturePath = null;
    $error = false;
    $error_message = ''; // Variável para armazenar a mensagem de erro

    // Validações de entrada de dados
    if (empty($email) || empty($plain_password) || empty($dataNascimento) || empty($nome) || empty($usuario_tipo)) {
        $error_message = 'Por favor, preencha todos os campos obrigatórios.';
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Formato de e-mail inválido.';
        $error = true;
    } elseif (strlen($plain_password) < 4) { // Pelo menos 4 caracteres para a senha
        $error_message = 'A senha deve ter pelo menos 4 caracteres.';
        $error = true;
    } elseif (!in_array($usuario_tipo, ['Admin', 'Aluno', 'comum'])) { // 'comum' adicionado se for um tipo padrão
        $error_message = 'Tipo de usuário inválido selecionado.';
        $error = true;
    }

    // Se houve algum erro nas validações iniciais, redireciona
    if ($error) {
        $_SESSION['error_message'] = $error_message;
        header("Location: cadastro.php");
        exit();
    }

    // --- VERIFICAÇÕES DE UNICIDADE NO BANCO DE DADOS ---

    // 1. Verificar se o E-MAIL já existe
    $sql_check_email = "SELECT idUsuario FROM usuarios WHERE emailUsuario = ?";
    if ($stmt_email = $conn->prepare($sql_check_email)) {
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $stmt_email->store_result(); // Armazena o resultado para poder usar num_rows
        if ($stmt_email->num_rows > 0) {
            $error_message = 'Este e-mail já está cadastrado. Por favor, use outro e-mail.';
            $error = true;
        }
        $stmt_email->close();
    } else {
        $error_message = 'Erro interno ao verificar o e-mail.';
        $error = true;
    }

    // 2. Verificar se o NOME DE USUÁRIO já existe (apenas se não houver erro no e-mail)
    if (!$error) { // Só verifica o nome se o e-mail não estiver duplicado
        $sql_check_nome = "SELECT idUsuario FROM usuarios WHERE nomeUsuario = ?";
        if ($stmt_nome = $conn->prepare($sql_check_nome)) {
            $stmt_nome->bind_param("s", $nome);
            $stmt_nome->execute();
            $stmt_nome->store_result(); // Armazena o resultado para poder usar num_rows
            if ($stmt_nome->num_rows > 0) {
                $error_message = 'Este nome de usuário já está em uso. Por favor, escolha outro.';
                $error = true;
            }
            $stmt_nome->close();
        } else {
            $error_message = 'Erro interno ao verificar o nome de usuário.';
            $error = true;
        }
    }

    // Se houve algum erro nas verificações de unicidade, redireciona
    if ($error) {
        $_SESSION['error_message'] = $error_message;
        header("Location: cadastro.php");
        exit();
    }

    // --- FIM DAS VERIFICAÇÕES DE UNICIDADE ---

    // Processamento do upload da foto de perfil
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/profile_pictures/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Cria o diretório se não existir
        }

        $file_extension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '.' . $file_extension; // Gera nome único para o arquivo
        $target_file = $target_dir . $new_file_name;

        // Validação do tipo de arquivo e tamanho
        $check = getimagesize($_FILES['profilePicture']['tmp_name']);
        if ($check === false) {
            $_SESSION['error_message'] = 'O arquivo enviado não é uma imagem.';
            header("Location: cadastro.php");
            exit();
        }

        if ($_FILES['profilePicture']['size'] > 5 * 1024 * 1024) { // 5MB
            $_SESSION['error_message'] = 'O arquivo de imagem é muito grande (máx. 5MB).';
            header("Location: cadastro.php");
            exit();
        }

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            $_SESSION['error_message'] = 'Apenas JPG, JPEG, PNG e GIF são permitidos.';
            header("Location: cadastro.php");
            exit();
        }

        // Tenta mover o arquivo
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $target_file)) {
            $profilePicturePath = $target_file;
        } else {
            $_SESSION['error_message'] = 'Erro ao fazer upload da imagem. Por favor, tente novamente.';
            header("Location: cadastro.php");
            exit();
        }
    } else {
        // Define um caminho padrão para a imagem de perfil se nenhuma for enviada
        // Certifique-se de que este arquivo 'default-profile.png' exista no seu diretório 'assets/img/'
        $profilePicturePath = 'assets/img/default-profile.png';
    }

    // Criptografia da senha (usando password_hash)
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    // Inserir no banco de dados
    $sql_insert = "INSERT INTO usuarios (emailUsuario, senhaUsuario, nomeUsuario, datanascUsuario, tipoUsuario, fotoUsuario) 
                   VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt_insert = $conn->prepare($sql_insert)) {
        $stmt_insert->bind_param("ssssss", $email, $hashed_password, $nome, $dataNascimento, $usuario_tipo, $profilePicturePath);

        if ($stmt_insert->execute()) {
            // LOGIN AUTOMÁTICO APÓS CADASTRO BEM-SUCEDIDO
            $_SESSION['usuario_id'] = $conn->insert_id; // Pega o ID do usuário recém-criado
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_tipo'] = $usuario_tipo;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['usuario_foto'] = $profilePicturePath;

            $_SESSION['success_message'] = 'Cadastro realizado com sucesso! Você já está logado.';
            header("Location: index.php"); // Redireciona para a página inicial
            exit();
        } else {
            // Este else só será acionado se houver um erro no INSERT diferente de unicidade (pois já validamos antes)
            $_SESSION['error_message'] = 'Erro ao cadastrar usuário. Por favor, tente novamente. Detalhes: ' . $stmt_insert->error;
            header("Location: cadastro.php");
            exit();
        }

        $stmt_insert->close();
    } else {
        $_SESSION['error_message'] = 'Erro ao preparar a instrução SQL de inserção: ' . $conn->error;
        header("Location: cadastro.php");
        exit();
    }

    $conn->close();
} else {
    // Se a requisição não for POST, redireciona para a página de cadastro
    header("Location: cadastro.php");
    exit();
}
// Certifique-se de que NÃO HÁ NENHUMA TAG DE FECHAMENTO PHP (?>) AQUI SE ESTE FOR O ÚLTIMO CÓDIGO NO ARQUIVO.