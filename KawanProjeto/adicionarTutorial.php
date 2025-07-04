<?php
session_start();
// Certifique-se de que 'conexaoBd.php' existe e configura a variável $conn (mysqli)
require_once 'conexaoBd.php';

// --- Função de Verificação de Permissão ---
// Esta função verifica se o usuário está logado E se o tipo de usuário é 'Admin'
function verificarPermissaoTutor() {
    // Verifica se o ID do usuário está definido na sessão e não está vazio
    // E se o tipo de usuário na sessão é exatamente 'Admin'
    if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id']) || !isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'Admin') {
        // Se alguma das condições acima for falsa, o usuário não é um tutor logado.
        // Define uma mensagem de erro na sessão.
        $_SESSION['error_message'] = 'Você não tem permissão para acessar esta página.';
        // Redireciona para a página inicial (ou para uma página de acesso negado dedicada)
        header('Location: index.php');
        exit(); // Encerra a execução do script para evitar que o conteúdo da página seja exibido
    }
}
verificarPermissaoTutor(); // Chama a função para proteger esta página

// Se o script chegou até aqui, significa que o usuário é um tutor e pode ver o formulário.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" type="image/x-icon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <title>Adicionar Novo Tutorial - Minecraft Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            background: url('assets/img/principalDesfoque.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* REMOVIDO: padding-top: 70px; Isso já é definido no header.php. */
        }
        .masthead {
            flex-grow: 1;
            padding-top: 4rem; /* Pode ser necessário ajustar para não colidir com a navbar */
            padding-bottom: 6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Estilos para o formulário no centro */
        .form-subscribe {
            background-color: rgba(0, 0, 0, 0.7); /* Fundo semi-transparente para o formulário */
            padding: 30px;
            border-radius: 8px;
        }
        .form-control-lg {
            min-height: calc(1.5em + 1rem + 2px); /* Altura padrão para Bootstrap 5 */
        }
        textarea.form-control-lg {
            height: auto; /* Reset para textarea */
        }
        /* Estilos do seu Footer - mantenha-os aqui ou mova para um footer.php */
        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            color: #6c757d;
            margin-top: auto; /* Empurra o footer para o final da página */
        }
        .footer .list-inline-item a {
            color: #218838 !important;
            text-decoration: none;
        }
        .footer .list-inline-item a:hover {
            color: #1a6d2c !important;
        }
        .footer .bi-facebook,
        .footer .bi-twitter,
        .footer .bi-instagram {
            color: #6c757d !important;
            transition: color 0.3s ease;
        }
        .footer .bi-facebook:hover,
        .footer .bi-twitter:hover,
        .footer .bi-instagram:hover {
            color: #007bff !important;
        }
        /* Os estilos da navbar e responsividade da navbar NÃO devem estar aqui,
           eles já estão no header.php. Removi-os deste bloco <style>. */
    </style>
</head>
<body>
    <?php include 'header.php'; // <--- ONDE A MÁGICA ACONTECE! Inclui a navbar e seus estilos. ?>

    <div class="blur-wrapper">
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <h1 class="mb-5">Adicionar Novo Tutorial</h1>

                            <form class="form-subscribe" action="actionTutorial.php" method="POST">
                                <div class="mb-3 text-start">
                                    <label for="titulo" class="form-label text-white">Título do Tutorial:</label>
                                    <input class="form-control form-control-lg" id="titulo" type="text"
                                        placeholder="Digite o título do tutorial" name="titulo" required>
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="descricao" class="form-label text-white">Breve Descrição:</label>
                                    <textarea class="form-control form-control-lg" id="descricao" name="descricao"
                                        placeholder="Uma breve descrição para o tutorial (opcional)" style="height: 100px;"></textarea>
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="conteudo" class="form-label text-white">Conteúdo do Tutorial:</label>
                                    <textarea class="form-control form-control-lg" id="conteudo" name="conteudo"
                                        placeholder="Escreva o conteúdo completo do tutorial aqui, passo a passo..." style="height: 200px;" required></textarea>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit"
                                        style="background-color: rgb(67, 161, 67);">Publicar Tutorial</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <footer class="footer bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                        <p class="text-muted small mb-4 mb-lg-0">&copy; Meu site 2025 | Todos os direitos reservados.
                        </p>
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="https://www.facebook.com/kawan.dias.71/"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            <li class="list-inline-item me-4">
                                <a href="https://x.com/"><i class="bi-twitter fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://www.instagram.com/"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>