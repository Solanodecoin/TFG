<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('/img/leonardo.jpeg') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }
        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
            z-index: -1;
        }
        .container {
            text-align: center;
            color: white;
        }
        .title {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .slogan {
            font-size: 1.5em;
            margin-bottom: 30px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .buttons a {
            padding: 15px 30px;
            font-size: 1em;
            color: white;
            background-color: rgba(0, 123, 255, 0.7);
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .buttons a:hover {
            background-color: rgba(0, 123, 255, 1);
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>
    <div class="container">
        <div class="title">Bienvenido a Leonardo</div>
        <div class="slogan">Tu portal a la creatividad y la innovación</div>
        <div class="buttons">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>
</body>
</html>
