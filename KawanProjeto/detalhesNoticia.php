<?php
// Garante que a sessão seja iniciada apenas uma vez, sem warnings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclua seu header.php aqui se ele contiver a navegação principal
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Notícia - Em Desenvolvimento</title>
    <link rel="icon" type="image/x-xicon" href="assets/minecraft_logo_icon_168974.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px; /* Ajuste para a altura da sua navbar fixa */
        }
        .main-content {
            flex-grow: 1; /* Faz com que o conteúdo principal ocupe o espaço restante */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }
        .message-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        .message-box h1 {
            color: #28a745; /* Um verde bonito para a mensagem */
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        .message-box p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 25px;
        }
        .message-box .btn {
            background-color: #007bff; /* Azul Bootstrap para o botão */
            border-color: #007bff;
            color: #fff;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .message-box .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <div class="message-box">
            <h1>Conteúdo Em Desenvolvimento!</h1>
            <p>Os detalhes completos desta notícia estão sendo cuidadosamente preparados.</p>
            <p>Agradecemos a sua paciência e volte em breve para conferir as novidades!</p>
            <a href="noticias.php" class="btn">Voltar para Notícias</a>
        </div>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>