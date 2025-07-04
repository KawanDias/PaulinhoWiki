<?php
session_start();
require_once 'conexaoBd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $plain_password = $_POST['senha'];

    // Validação
    if (empty($email) || empty($plain_password)) {
        $_SESSION['error_message'] = 'Por favor, preencha todos os campos.';
        header("Location: index.php"); // Redireciona para index.php em caso de campos vazios
        exit();
    }

    // Consulta com base no seu banco de dados: usuarios
    $sql = "SELECT idUsuario, emailUsuario, senhaUsuario, nomeUsuario, tipoUsuario, fotoUsuario FROM usuarios WHERE emailUsuario = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($plain_password, $user['senhaUsuario'])) {
                    // Login bem-sucedido, definir sessão
                    $_SESSION['usuario_id'] = $user['idUsuario'];
                    $_SESSION['usuario_nome'] = $user['nomeUsuario'];
                    $_SESSION['usuario_tipo'] = $user['tipoUsuario'];
                    $_SESSION['usuario_email'] = $user['emailUsuario'];
                    $_SESSION['usuario_foto'] = $user['fotoUsuario'];

                    $_SESSION['success_message'] = 'Login realizado com sucesso!'; // Opcional: mensagem de sucesso
                    header("Location: index.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = 'E-mail ou senha incorretos.';
                    header("Location: index.php"); // Redireciona para index.php em caso de senha incorreta
                    exit();
                }
            } else {
                $_SESSION['error_message'] = 'E-mail ou senha incorretos.';
                header("Location: index.php"); // Redireciona para index.php em caso de usuário não encontrado
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Erro ao executar a consulta.';
            header("Location: index.php"); // Redireciona para index.php em caso de erro na execução da consulta
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Erro de preparação da query.';
        header("Location: index.php"); // Redireciona para index.php em caso de erro na preparação da query
        exit();
    }

    $conn->close();
} else {
    // Se não for uma requisição POST, redireciona para a página inicial (ou onde o formulário está)
    header("Location: index.php");
    exit();
}