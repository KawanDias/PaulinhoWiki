<?php
// Garante que a sessão seja iniciada apenas uma vez, sem warnings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'conexaoBd.php'; // Inclua sua conexão com o banco de dados

// Variável para a query de pesquisa
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $_GET['search'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriais - Minecraft Wiki</title>
    <link rel="icon" type="image/x-xicon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"
        type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Importação de fonte do Google Fonts (Open Sans para corpo, Roboto para títulos) */
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        :root {
            /* Cores baseadas nas imagens fornecidas */
            --navbar-bg-color: #212529; /* Fundo da Navbar (preto/cinza escuro) */
            --navbar-text-color: #FFFFFF; /* Texto da Navbar (branco) */
            --btn-login-bg: #4CAF50; /* Fundo do botão Login (verde) */
            --btn-login-hover: #45a049; /* Fundo do botão Login no hover */

            /* A cor da Hero Section será uma imagem, mas o texto ainda é branco */
            --hero-text-color: #FFFFFF; /* Texto da Hero Section (branco) */
            --hero-overlay-color: rgba(0, 0, 0, 0.4); /* Camada escura sobre a imagem (ajuste a opacidade) */

            --primary-text-color: #333333; /* Cor principal do texto (cinza escuro) */
            --secondary-text-color: #666666; /* Cor secundária do texto (cinza médio) */
            --background-light: #F5F5F5; /* Fundo geral do corpo da página (cinza claro) */
            --white: #FFFFFF; /* Cor branca pura */
            --border-color: #E0E0E0; /* Cor da borda dos cards */
            --shadow-light: rgba(0, 0, 0, 0.1); /* Sombra leve */
            --hover-effect-color: #007bff; /* Azul para links e ícones dos cards */
        }

        /* Reset básico (mantido, mas algumas propriedades serão sobrescritas pelo Bootstrap) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: var(--primary-text-color);
            background-color: var(--background-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px; /* Ajuste para a altura da navbar fixa */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /*
          **********************************************************
          * CSS para a barra de navegação (NavBar) - Adaptado das páginas anteriores
          **********************************************************
          */
        .main-navbar {
            background-color: #ffffff !important; /* Fundo branco para a barra de navegação */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil na parte inferior */
            padding: 15px 0; /* Espaçamento interno superior e inferior */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .main-navbar .container {
            /* Certifica-se de que o conteúdo da navbar está bem distribuído */
            max-width: 1200px; /* Ajuste conforme necessário para o seu layout */
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-navbar .navbar-brand {
            font-size: 24px; /* Tamanho da fonte do logo "Minecraft Wiki" */
            font-weight: 600; /* Negrito menos intenso */
            color: #218838 !important; /* Cor verde para o logo, sobrescrevendo o Bootstrap */
            text-decoration: none; /* Remover sublinhado padrão */
        }

        .main-navbar .nav-link {
            font-size: 18px; /* Tamanho da fonte dos links de navegação */
            color: #333333 !important; /* Cor mais escura para os links, sobrescrevendo o Bootstrap */
            margin-right: 30px; /* Espaçamento entre os links de navegação */
            transition: color 0.3s ease; /* Transição suave para a cor ao passar o mouse */
            position: relative; /* Necessário para posicionar o pseudo-elemento */
            overflow: hidden; /* Garante que a linha não vaze antes da animação */
            padding-bottom: 5px; /* Espaço para a linha que aparece abaixo */
            text-decoration: none; /* Remover sublinhado padrão */
        }

        .main-navbar .nav-link:last-child {
            margin-right: 0; /* Remove a margem do último item para não ter excesso de espaço */
        }

        /* Linha animada ao passar o mouse */
        .main-navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px; /* Espessura da linha */
            background-color: #218838; /* Cor da linha */
            transform: translateX(-100%); /* Começa fora da tela à esquerda */
            transition: transform 0.3s ease-out; /* Animação suave */
        }

        .main-navbar .nav-link:hover::after,
        .main-navbar .nav-link.active::after {
            /* Também para o link ativo */
            transform: translateX(0); /* Desliza para a posição normal */
        }

        .main-navbar .nav-link:hover,
        .main-navbar .nav-link.active {
            /* Também para o link ativo */
            color: #1a6d2c !important; /* Cor verde mais escura ao passar o mouse, sobrescrevendo o Bootstrap */
        }

        .main-navbar .btn-success {
            background-color: #218838 !important; /* Fundo verde para o botão Login */
            border-color: #218838 !important; /* Borda verde para o botão Login */
            color: #ffffff !important; /* Texto branco para o botão Login */
            padding: 10px 25px; /* Preenchimento interno do botão */
            border-radius: 5px; /* Borda arredondada do botão */
            font-size: 18px; /* Tamanho da fonte do botão */
            transition: background-color 0.3s ease, border-color 0.3s ease; /* Transição suave para cor e borda */
            text-decoration: none; /* Remover sublinhado padrão */
        }

        .main-navbar .btn-success:hover {
            background-color: #1a6d2c !important; /* Fundo verde mais escuro ao passar o mouse */
            border-color: #1a6d2c !important; /* Borda verde mais escura ao passar o mouse */
        }

        /* --- Seção de Destaque (Hero Section) --- */
        .hero-section {
            /* Fundo com imagem desfocada e propriedades de cover */
            background: url('assets/img/principalDesfoque.jpg') no-repeat center center/cover;
            color: var(--hero-text-color);
            text-align: center;
            padding: 80px 20px;
            position: relative;
            overflow: hidden;
        }

        /* Camada escura sobre a imagem para melhor legibilidade do texto */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--hero-overlay-color); /* Usando a variável de overlay */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        /* Ajuste para o formulário de busca dentro da Hero Section */
        .search-form-hero { /* Renomeei para evitar conflito com .search-form no main content */
            display: flex;
            justify-content: center;
            gap: 10px;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form-hero input[type="text"] {
            flex-grow: 1; /* Permite que o input cresça */
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            background-color: var(--white);
            color: var(--primary-text-color);
        }

        .search-form-hero input[type="text"]::placeholder {
            color: var(--secondary-text-color);
        }

        .search-form-hero button {
            padding: 12px 25px;
            background-color: var(--btn-login-bg);
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form-hero button:hover {
            background-color: var(--btn-login-hover);
        }

        /* --- Seção Principal de Tutoriais (Tutoriais Main Content) --- */
        .tutoriais-main-content {
            flex-grow: 1; /* Permite que o conteúdo principal ocupe o espaço restante */
            padding: 60px 20px;
            background-color: var(--white);
            min-height: 60vh;
        }

        .tutoriais-main-content h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 2.2rem;
            color: var(--primary-text-color);
            text-align: center;
            margin-bottom: 40px;
        }

        .tutorial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .tutorial-card {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 10px var(--shadow-light);
            padding: 25px;
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Alinha o conteúdo à esquerda */
            text-align: left; /* Alinha o texto à esquerda */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative; /* Para o botão de excluir */
            height: 100%; /* Garante que os cards tenham a mesma altura na linha */
        }

        .tutorial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        /* Ajustes para os ícones e meta-informações */
        .card-icon {
            font-size: 3rem;
            color: var(--hover-effect-color);
            margin-bottom: 15px;
            align-self: center; /* Centraliza o ícone */
        }

        .tutorial-card h3 {
            font-family: 'Roboto', sans-serif;
            font-size: 1.4rem;
            margin-bottom: 10px;
        }

        .tutorial-card h3 a {
            color: var(--primary-text-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .tutorial-card h3 a:hover {
            color: var(--hover-effect-color);
        }

        .tutorial-card p {
            font-size: 0.95rem;
            color: var(--secondary-text-color);
            margin-bottom: 20px;
            flex-grow: 1; /* Permite que o parágrafo ocupe o espaço disponível */
        }

        .card-meta {
            display: flex;
            justify-content: flex-start; /* Alinha as meta-infos à esquerda */
            font-size: 0.85rem;
            color: var(--secondary-text-color);
            margin-top: auto;
            margin-bottom: 15px;
            gap: 15px;
            width: 100%; /* Ocupa a largura total do card */
        }

        .card-meta i {
            margin-right: 5px;
            color: var(--hover-effect-color);
        }

        .btn-card {
            display: inline-block;
            background-color: var(--hover-effect-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            align-self: flex-start; /* Alinha o botão à esquerda */
        }

        .btn-card:hover {
            background-color: #0056b3;
        }

        /* Estilo para o botão de exclusão */
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #dc3545; /* Cor vermelha para indicar exclusão */
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
            z-index: 10; /* Garante que o botão esteja acima do conteúdo */
        }

        .delete-btn:hover {
            background-color: rgba(220, 53, 69, 0.2); /* Fundo levemente vermelho ao passar o mouse */
            color: #dc3545;
        }

        /* Estilo para o botão de edição (NOVO) */
        .edit-btn {
            position: absolute;
            top: 10px;
            right: 50px; /* Ajuste para não colidir com o botão de exclusão */
            background: none;
            border: none;
            color: #007bff; /* Cor azul para indicar edição */
            font-size: 1.2rem; /* Tamanho do ícone */
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
            z-index: 10;
        }

        .edit-btn:hover {
            background-color: rgba(0, 123, 255, 0.2); /* Fundo levemente azul ao passar o mouse */
            color: #007bff;
        }


        /* --- Rodapé (Footer) --- */
        .footer {
            background-color: #f8f9fa; /* Cor de fundo do rodapé Bootstrap */
            padding: 30px 0;
            color: #6c757d; /* Cor do texto padrão do Bootstrap */
            margin-top: auto; /* Empurra o footer para a parte inferior */
        }

        .footer .list-inline-item a {
            color: #218838 !important; /* Links do rodapé verdes */
            text-decoration: none;
        }

        .footer .list-inline-item a:hover {
            color: #1a6d2c !important; /* Links do rodapé verdes mais escuros ao hover */
        }

        .footer .bi-facebook,
        .footer .bi-twitter,
        .footer .bi-instagram {
            color: #6c757d !important; /* Ícones sociais cinzas */
            transition: color 0.3s ease;
        }

        .footer .bi-facebook:hover,
        .footer .bi-twitter:hover,
        .footer .bi-instagram:hover {
            color: #007bff !important; /* Ícones sociais azuis ao hover (exemplo) */
        }

        /* --- Responsividade (Media Queries) --- */
        @media (max-width: 991.98px) {
            /* Ponto de quebra para tablets e mobiles */
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

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content p {
                font-size: 1.2rem;
            }

            .search-form-hero { /* Ajuste para o novo nome */
                flex-direction: column;
            }

            .search-form-hero input[type="text"],
            .search-form-hero button {
                width: 100%;
                max-width: 300px;
            }

            .tutorial-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; // Inclui o header, que já contém a navbar e a lógica de sessão ?>

    <main>
        <section class="hero-section tutoriais-hero">
            <div class="hero-content">
                <h1>Aprenda e Explore o Mundo do Minecraft</h1>
                <p>Navegue por nossos tutoriais detalhados para dominar cada aspecto do jogo.</p>
                <form action="tutoriais.php" method="GET" class="search-form-hero">
                    <input type="text" placeholder="Buscar tutoriais..." name="search"
                        value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Buscar</button>
                </form>
            </div>
        </section>

        <section class="tutoriais-main-content container">
            <h2>Nossos Tutoriais</h2>

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

            // Consulta os tutoriais do banco de dados
            // Alterado de 'breve_descricao' para 'descricao' para corresponder à sua tabela
            $sql_tutoriais = "SELECT t.id, t.titulo, t.descricao, t.conteudo, t.data_publicacao, t.autor_id, u.nomeUsuario AS autor_nome
                              FROM tutoriais t
                              JOIN usuarios u ON t.autor_id = u.idUsuario";

            // Adiciona a cláusula WHERE se houver uma pesquisa
            if (!empty($search_query)) {
                // Pesquisa no título, descricao e conteúdo
                $sql_tutoriais .= " WHERE t.titulo LIKE ? OR t.descricao LIKE ? OR t.conteudo LIKE ?";
            }
            $sql_tutoriais .= " ORDER BY t.data_publicacao DESC";

            if ($stmt = $conn->prepare($sql_tutoriais)) {
                if (!empty($search_query)) {
                    $param_search = "%" . $search_query . "%";
                    $stmt->bind_param("sss", $param_search, $param_search, $param_search);
                }
                $stmt->execute();
                $result_tutoriais = $stmt->get_result();

                if ($result_tutoriais && $result_tutoriais->num_rows > 0) {
                    ?>
                    <div class="tutorial-grid">
                        <?php
                        // Exibe cada tutorial
                        while ($tutorial = $result_tutoriais->fetch_assoc()) {
                            ?>
                            <article class="tutorial-card">
                                <?php
                                // Exibe o botão de exclusão APENAS se o usuário logado for 'Admin'
                                if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Admin') {
                                    ?>
                                    <a href="actionDeleteTutorial.php?id=<?php echo $tutorial['id']; ?>"
                                       class="delete-btn"
                                       onclick="return confirm('Tem certeza que deseja excluir este tutorial?');"
                                       title="Excluir Tutorial">
                                        &times;
                                    </a>
                                    <?php
                                }

                                // Exibe o botão de edição se o usuário for Admin OU se for Tutor e o autor do tutorial
                                if (isset($_SESSION['usuario_tipo']) && ($_SESSION['usuario_tipo'] === 'Admin' || ($_SESSION['usuario_tipo'] === 'Tutor' && $tutorial['autor_id'] == $_SESSION['usuario_id']))) {
                                    ?>
                                    <a href="editarTutorial.php?id=<?php echo $tutorial['id']; ?>"
                                       class="edit-btn"
                                       title="Editar Tutorial">
                                        <i class="fas fa-pencil-alt"></i> </a>
                                    <?php
                                }
                                ?>
                                <div class="card-icon">
                                    <i class="fas fa-hammer"></i> 
                                </div>
                                <h3><a href="detalhesTutorial.php?id=<?php echo $tutorial['id']; ?>">
                                    <?php echo htmlspecialchars($tutorial['titulo']); ?>
                                </a></h3>
                                <?php if (!empty($tutorial['descricao'])): // Alterado de breve_descricao para descricao ?>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($tutorial['descricao'])); // Alterado de breve_descricao para descricao ?></p>
                                <?php else: ?>
                                    <p class="card-text">
                                        <?php
                                        // Limita o conteúdo para exibir apenas um trecho inicial
                                        $conteudo_curto = substr($tutorial['conteudo'], 0, 150);
                                        if (strlen($tutorial['conteudo']) > 150) {
                                            $conteudo_curto .= '...';
                                        }
                                        echo nl2br(htmlspecialchars($conteudo_curto));
                                        ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="card-meta">
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($tutorial['autor_nome']); ?></span>
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($tutorial['data_publicacao'])); ?></span>
                                </div>
                                <a href="detalhesTutorial.php?id=<?php echo $tutorial['id']; ?>" class="btn-card">Ler Tutorial</a>
                            </article>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    echo '<p class="text-center text-secondary">Nenhum tutorial encontrado no momento. ' . (!empty($search_query) ? 'Refine sua pesquisa.' : '') . '</p>';
                }
                $stmt->close();
            } else {
                echo '<p class="text-center text-danger">Erro na preparação da query: ' . $conn->error . '</p>';
            }
            $conn->close();
            ?>
        </section>
    </main>

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