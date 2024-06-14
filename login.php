<?php
session_start();

   

if(isset($_POST['usuario']) && isset($_POST['password'])) {




  
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "pablo", "root", "leonardo");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $statement = $conn->prepare('SELECT * FROM Usuario WHERE Nombre = ? AND Contraseña = ?');
    $statement->bind_param('ss', $usuario, $password);
    $statement->execute();
    $resultado = $statement->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        echo "Te has conectado con : ". $usuario;
        exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Usuario Incorrecto");';
        echo '</script>';
    }

    $statement->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="estiloslogin.css">
</head>
<body>
    <div class="login-container">
        <h1 class="gradient-text">Iniciar Sesión</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" name="login">
            <div class="input-field">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingrese su usuario" required>
            </div>
            <div class="input-field">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="gradient-button">Iniciar Sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
    </div>
</body>
</html>
