<?php
// Certifique-se de que session_start() seja a PRIMEIRA coisa no arquivo,
// antes de qualquer HTML ou include, a menos que 'header.php' já inicie a sessão corretamente.
// Se header.php já inicia, você pode remover esta linha.
// Caso contrário, esta é a forma correta de evitar o aviso.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="icon" type="image/x-icon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"
        type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Fundo com imagem e desfoque */
        body,
        html {
            height: 100%;
            background: url('assets/img/principalDesfoque.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px;
        }

        .masthead {
            flex-grow: 1;
            padding-top: 4rem;
            padding-bottom: 6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /*
         **********************************************************
         * CSS para a barra de navegação (NavBar)
         **********************************************************
         */
        .main-navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .main-navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-navbar .navbar-brand {
            font-size: 24px;
            font-weight: 600;
            color: #218838 !important;
            text-decoration: none;
        }

        .main-navbar .nav-link {
            font-size: 18px;
            color: #333333 !important;
            margin-right: 30px;
            transition: color 0.3s ease;
            position: relative;
            overflow: hidden;
            padding-bottom: 5px;
            text-decoration: none;
        }

        .main-navbar .nav-link:last-child {
            margin-right: 0;
        }

        /* Linha animada ao passar o mouse */
        .main-navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #218838;
            transform: translateX(-100%);
            transition: transform 0.3s ease-out;
        }

        .main-navbar .nav-link:hover::after,
        .main-navbar .nav-link.active::after {
            transform: translateX(0);
        }

        .main-navbar .nav-link:hover,
        .main-navbar .nav-link.active {
            color: #1a6d2c !important;
        }

        .main-navbar .btn-success {
            background-color: #218838 !important;
            border-color: #218838 !important;
            color: #ffffff !important;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            text-decoration: none;
        }

        .main-navbar .btn-success:hover {
            background-color: #1a6d2c !important;
            border-color: #1a6d2c !important;
        }

        /* Estilos para o rodapé (consistente com as outras páginas) */
        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            color: #6c757d;
            margin-top: auto;
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

        /* Responsividade para a Navbar */
        @media (max-width: 991.98px) {
            .main-navbar .container {
                flex-direction: column;
                text-align: center;
            }

            .main-navbar .nav {
                margin-top: 15px;
                flex-direction: column;
                align-items: center;
            }

            .main-navbar .nav-item {
                margin: 0 0 10px 0;
            }

            .main-navbar .nav-link {
                margin-right: 0;
            }

            .main-navbar .btn-success {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <?php
    // Incluir o cabeçalho (se existir)
    // Se 'header.php' também tiver session_start(), você precisa gerenciar isso para evitar duplicidade.
    // O ideal é que session_start() seja chamado apenas uma vez no topo do arquivo principal.
    include 'header.php';

    // *** CÓDIGO PARA EXIBIR MENSAGENS DE SESSÃO ***
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success text-center mt-3">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Limpa a mensagem para não ser exibida novamente
    }

    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger text-center mt-3">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Limpa a mensagem para não ser exibida novamente
    }
    // ***********************************************
    ?>

    <nav class="navbar navbar-light bg-light fixed-top main-navbar">
        <div class="container">
            <a class="navbar-brand text-success fs-4" href="index.php">Minecraft Wiki</a>

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="noticias.php">Notícias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tutoriais.php">Tutoriais</a>
                </li>
           
            </ul>

            <a class="btn btn-success px-4" href="index.php#signup">Login</a>
        </div>
    </nav>

    <div class="blur-wrapper">
        <header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <h1 class="mb-5">Faça o seu cadastro, junte-se à comunidade agora mesmo!</h1>

                            <form class="form-subscribe" id="contactForm" action="actionUsuario.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 text-start">
                                    <label for="email" class="form-label text-white">E-mail</label>
                                    <input class="form-control form-control-lg" id="email" type="email"
                                        placeholder="Digite seu e-mail" name="email" required>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="senha" class="form-label text-white">Senha</label>
                                    <input class="form-control form-control-lg" id="senha" type="password"
                                        placeholder="Digite sua senha" name="senha" required minlength="4">
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="dataNascimento" class="form-label text-white">Data de
                                        Nascimento</label>
                                    <input class="form-control form-control-lg" id="dataNascimento" type="date"
                                        name="dataNascimento" required>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="nome" class="form-label text-white">Nome</label>
                                    <input class="form-control form-control-lg" id="nome" type="text"
                                        placeholder="Digite seu nome" name="nome" required>
                                </div>

                                <div class="mb-3">
                                    <label for="usuario_tipo" class="form-label text-white">Tipo de Usuário</label>
                                    <select class="form-select bg-white text-dark border-0" id="usuario_tipo" name="usuario_tipo" required>
                                        <option value="" class="text-dark">Selecione</option>
                                        <option value="Admin" class="text-dark">Tutor</option>
                                        <option value="Aluno" class="text-dark">Aluno</option>
                                    </select>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="profilePicture" class="form-label text-white">Foto do Perfil</label>
                                    <input class="form-control form-control-lg" id="profilePicture" type="file"
                                        name="profilePicture" accept="image/*">
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit"
                                        style="background-color: rgb(67, 161, 67);">Cadastrar</button>
                                </div>

                                <div id="submitSuccessMessage">
                                    <div class="text-center mt-3">
                                        <div class="fw-bolder"></div>
                                        <p></p>
                                    </div>
                                </div>

                                <div id="submitErrorMessage">
                                    <div class="text-center text-danger mt-3"></div>
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