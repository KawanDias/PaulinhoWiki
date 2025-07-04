<?php
// header.php

// Garante que a sessão seja iniciada apenas uma vez, sem warnings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-light bg-light fixed-top main-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-success fw-bold fs-4" href="index.php">Minecraft Wiki</a>

        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="noticias.php">Notícias</a></li>
            <li class="nav-item"><a class="nav-link" href="tutoriais.php">Tutoriais</a></li>
            
            <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Admin'): ?>
                <li class="nav-item"><a class="nav-link" href="adicionarNoticia.php">Adicionar Notícia</a></li>
                <li class="nav-item"><a class="nav-link" href="adicionarTutorial.php">Adicionar Tutorial</a></li>
            <?php endif; ?>
        </ul>

        <?php
        if (isset($_SESSION['usuario_id'])):
        ?>
            <div class="d-flex align-items-center">
                <span class="me-3 fw-bold text-success">
                    Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
                </span>
                <a class="btn btn-danger px-4" href="logout.php">Sair</a>
            </div>
        <?php else: ?>
            <a class="btn btn-success px-4" href="index.php#signup">Login</a>
        <?php endif; ?>
    </div>
</nav>

<style>
    /* Estilos CSS da sua navbar, se não estiverem em um arquivo CSS externo */
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
    .btn-danger { /* Estilo para o botão "Sair", que agora é btn-danger */
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #ffffff !important;
    }
    .btn-danger:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
    }

    /* Para garantir que o fixed-top não sobreponha o conteúdo */
    body {
        padding-top: 70px; /* Ajuste este valor para a altura exata da sua navbar, se necessário */
    }

    /* Responsividade para a navbar, adaptado dos seus outros arquivos */
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
        .main-navbar .btn-success,
        .main-navbar .btn-danger { /* Inclui o btn-danger aqui para responsividade */
            margin-top: 15px;
        }
    }
</style>