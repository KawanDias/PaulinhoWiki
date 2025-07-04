<?php
// Certifique-se que NADA (nem espaços, linhas vazias) está antes desta tag <?php
// O header.php já inicia a sessão, então você pode simplesmente incluí-lo.
// Se você quiser ter certeza, pode adicionar a verificação aqui também.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclua seu header.php que contém a navbar e a lógica de sessão
include 'header.php'; // Inclui a navbar e a lógica de sessão (Login/Sair)
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Minecraft Wiki - Respostas para suas dúvidas, comunidade ativa e dicas." />
    <meta name="author" content="Kawan Dias Carneiro" />
    <title>Minecraft Wiki - Início</title>
    <link rel="icon" type="image/x-icon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">

    <style>
        /* Seus estilos CSS personalizados */
        .main-navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        .main-navbar .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .main-navbar .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #218838 !important;
        }
        .main-navbar .nav-link {
            font-size: 18px;
            color: #333333 !important;
            margin-right: 30px;
            transition: color 0.3s ease;
            position: relative;
            overflow: hidden;
            padding-bottom: 5px;
        }
        .main-navbar .nav-link:last-child {
            margin-right: 0;
        }
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
        .main-navbar .nav-link:hover::after {
            transform: translateX(0);
        }
        .main-navbar .nav-link:hover {
            color: #1a6d2c !important;
        }
        .main-navbar .btn-primary {
            background-color: #218838 !important;
            border-color: #218838 !important;
            color: #ffffff !important;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .main-navbar .btn-primary:hover {
            background-color: #1a6d2c !important;
            border-color: #1a6d2c !important;
        }
        body {
            padding-top: 70px;
        }
        /* Estilos adicionais para as mensagens */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>

<body>
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <h1 class="mb-5">As respostas para as suas dúvidas estão aqui!</h1>
                        <form class="form-subscribe" id="searchForm" action="search.php" method="GET">
                            <div class="row">
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi bi-patch-question m-auto text-primary"></i>
                        </div>
                        <h3>Tire suas dúvidas</h3>
                        <p class="lead mb-0">O local ideal para esclarecer todas as suas dúvidas!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi bi-people m-auto text-primary"></i></div>
                        <h3>Comunidade ativa</h3>
                        <p class="lead mb-0">Conheça nossa comunidade que está sempre disposta a ajudar!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi bi-book m-auto text-primary"></i></div>
                        <h3>Dicas</h3>
                        <p class="lead mb-0">Dicas importantes para você aprimorar sua jogatina e mandar ver!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                    style="background-image: url('assets/img/sakura.jpg')"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2 style="color:rgb(67, 161, 67);">Melhores biomas para iniciar</h2>
                    <p class="lead mb-0">Escolher o bioma certo no início de uma jornada no Minecraft pode fazer toda a
                        diferença. Nesta página, você encontrará os biomas mais indicados para começar bem, com recursos
                        acessíveis, abrigo fácil e boas oportunidades de sobrevivência e progresso.</p>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-lg-6 text-white showcase-img" style="background-image: url('assets/img/mods.png')">
                </div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2 style="color:rgb(67, 161, 67);">Mods: O que são e como utilizar?</h2>
                    <p class="lead mb-0">O Minecraft se destaca pela enorme variedade de mods disponíveis, que expandem
                        e transformam o jogo. Nesta página, você encontrará informações sobre versões, plataformas e
                        ferramentas que oferecem suporte completo à instalação e uso de mods.</p>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                    style="background-image: url('assets/img/noite.jpg')"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2 style="color:rgb(67, 161, 67);">Como sobreviver à primeira noite?</h2>
                    <p class="lead mb-0">Não deixe a escuridão te pegar de surpresa. Saiba mais sobre as estratégias
                        essenciais para superar a primeira noite. Prepare-se para enfrentar o desconhecido e transformar
                        a apreensão em confiança.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5">Autor</h2>
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="assets/img/autor.jpg" alt="Foto do autor" />
                        <h5>Kawan Dias Carneiro</h5>
                        <p class="font-weight-light mb-0">Desenvolvedor, Designer Gráfico, Produtor Audiovisual,
                            Tradutor e Intérprete da língua inglesa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action text-white text-center" id="signup">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <h2 class="mb-4">Pronto para começar?</h2>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger text-center mb-3">
                            <?php
                            echo htmlspecialchars($_SESSION['error_message']);
                            unset($_SESSION['error_message']); // Limpa a mensagem após exibir
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success text-center mb-3">
                            <?php
                            echo htmlspecialchars($_SESSION['success_message']);
                            unset($_SESSION['success_message']); // Limpa a mensagem após exibir
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!isset($_SESSION['usuario_id'])): // Mostra o formulário de login SOMENTE se não estiver logado ?>
                        <form action="actionLogin.php" method="POST" class="form-subscribe">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input class="form-control form-control-lg" id="emailLogin" name="email" type="email"
                                        placeholder="E-mail" required />
                                </div>
                                <div class="col-12 mb-3">
                                    <input class="form-control form-control-lg" id="senhaLogin" name="senha" type="password"
                                        placeholder="Senha" required />
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary btn-lg button-center" type="submit"
                                        style="background-color:rgb(67, 161, 67);">Entrar</button>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <p class="text-white texto-cadastro-maior">
                                    Ainda não tem uma conta? <a href="cadastro.php" class="text-decoration-none text-success">Cadastre-se.</a>
                                </p>
                            </div>
                        </form>
                    <?php else: // Mensagem para quem já está logado ?>
                        <p class="lead text-white">Você já está logado como **<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>**!</p>
                        <p class="lead text-white">Explore a Wiki ou <a href="logout.php" class="text-decoration-none text-danger">Sair</a>.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                    <ul class="list-inline mb-2">

                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Meu site 2025 | Todos os direitos reservados.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

</body>

</html>