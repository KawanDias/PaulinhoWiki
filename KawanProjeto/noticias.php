<?php
// Garante que a sessão seja iniciada apenas uma vez, sem warnings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'conexaoBd.php'; // Inclua sua conexão com o banco de dados
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
    <title>Notícias - Minecraft Wiki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Estilos base para HTML e Body */
        body,
        html {
            height: 100%;
            background: url('assets/img/principalDesfoque.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            /* Adicionado para flexbox */
            flex-direction: column;
            /* Adicionado para flexbox */
            min-height: 100vh;
            /* Garante que o body ocupe a altura total da viewport */
        }

        /* Conteúdo principal para "empurrar" o rodapé */
        .content-wrapper {
            flex-grow: 1;
            /* Faz com que .content-wrapper ocupe todo o espaço restante no body */
            padding-top: 80px;
            padding-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            width: 100%;
            max-width: 960px;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Estilos específicos para os cards de notícia */
        .news-card {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 0.5rem;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            /* Adicionado para posicionar o botão de exclusão */
        }

        .news-card .card-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .news-card .card-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .news-card .text-muted {
            font-size: 0.85rem;
        }

        .news-card .btn {
            margin-top: 10px;
        }

        /* Estilo para o botão de exclusão e edição */
        .action-btns {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px; /* Espaço entre os botões */
        }

        .action-btns .btn-icon {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .delete-btn {
            color: #dc3545; /* Cor vermelha para indicar exclusão */
        }

        .delete-btn:hover {
            background-color: rgba(220, 53, 69, 0.2);
            /* Fundo levemente vermelho ao passar o mouse */
            color: #dc3545;
        }

        .edit-btn {
            color: #007bff; /* Cor azul para indicar edição */
        }

        .edit-btn:hover {
            background-color: rgba(0, 123, 255, 0.2); /* Fundo levemente azul ao passar o mouse */
            color: #007bff;
        }


        /* Estilos para a barra de navegação (NavBar) */
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
            font-weight: 600;
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

        .main-navbar .btn-success {
            background-color: #218838 !important;
            border-color: #218838 !important;
            color: #ffffff !important;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .main-navbar .btn-success:hover {
            background-color: #1a6d2c !important;
            border-color: #1a6d2c !important;
        }

        /* Para garantir que o fixed-top não sobreponha o conteúdo */
        body {
            padding-top: 70px;
        }

        /* Estilos para o rodapé */
        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            color: #6c757d;
            margin-top: auto;
            /* Empurra o footer para a parte inferior */
        }

        .footer .nav-link {
            color: green !important;
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
    </style>
</head>

<body>
    <?php include 'header.php'; // Inclui o header, que já contém a navbar e a lógica de sessão ?>

    <div class="content-wrapper">
        <div class="container">
            <h1 class="text-center mb-4 text-white">Últimas Notícias do Minecraft!</h1>

            <?php
            // Exibe mensagens de sucesso ou erro, se houver
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger text-center">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }

            // Consulta as notícias do banco de dados
            $sql_noticias = "SELECT n.id, n.titulo, n.conteudo, n.data_publicacao, u.nomeUsuario AS autor_nome
                             FROM noticias n
                             JOIN usuarios u ON n.autor_id = u.idUsuario
                             ORDER BY n.data_publicacao DESC";
            $result_noticias = $conn->query($sql_noticias);

            if ($result_noticias && $result_noticias->num_rows > 0) {
                // Exibe cada notícia
                while ($noticia = $result_noticias->fetch_assoc()) {
                    ?>
                    <div class="news-card">
                        <?php
                        // Exibe os botões de exclusão e edição APENAS se o usuário logado for 'Admin'
                        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Admin') {
                            ?>
                            <div class="action-btns">
                                <a href="actionDeleteNoticia.php?id=<?php echo $noticia['id']; ?>"
                                   class="btn-icon delete-btn"
                                   onclick="return confirm('Tem certeza que deseja excluir esta notícia?');"
                                   title="Excluir Notícia">
                                    &times;
                                </a>
                                <a href="editarNoticia.php?id=<?php echo $noticia['id']; ?>"
                                   class="btn-icon edit-btn"
                                   title="Editar Notícia">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                        <h5 class="card-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h5>
                        <p class="card-text">
                            <?php
                            // Limita o conteúdo para exibir apenas um trecho inicial
                            $conteudo_curto = substr($noticia['conteudo'], 0, 250); // Pega os primeiros 250 caracteres
                            // Se o conteúdo for maior que 250, adiciona reticências
                            if (strlen($noticia['conteudo']) > 250) {
                                $conteudo_curto .= '...';
                            }
                            echo nl2br(htmlspecialchars($conteudo_curto)); // nl2br para quebras de linha
                            ?>
                        </p>
                        <p class="card-text text-muted">
                            Publicado em: <?php echo date('d/m/Y H:i', strtotime($noticia['data_publicacao'])); ?>
                            por <?php echo htmlspecialchars($noticia['autor_nome']); ?>
                        </p>
                        <a href="detalhesNoticia.php?id=<?php echo $noticia['id']; ?>" class="btn btn-primary">Leia Mais</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="text-white text-center">Nenhuma notícia encontrada no momento.</p>';
            }
            ?>
        </div>
    </div>

    <footer class="footer bg-light mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>