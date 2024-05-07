<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="login-container"> <h1 class="gradient-text">Registro</h1> <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

            <div class="input-field"> <label for="usuario">Nombre de usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingrese su nombre de usuario" required>
            </div>
            <div class="input-field">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
            </div>
            <div class="input-field">
                <label for="password2">Confirme contraseña</label>
                <input type="password" name="password2" id="password2" placeholder="Confirme su contraseña" required>
            </div>

            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="email" required>
            </div>




            <div class="form-actions"> <button type="submit" class="gradient-button">Registrarse</button>
            </div>

<?php

if (isset($_POST["usuario"]) && isset($_POST["password"]) && isset($_POST["password2"]) && isset($_POST["email"])) {
    $user = $_POST["usuario"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];

    if ($password == $password2) {
        $conn = new mysqli("localhost", "pablo", "root", "leonardo");

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $statement = $conn->prepare('SELECT * FROM Usuario WHERE Nombre = ? LIMIT 1');
        $statement->bind_param('s', $user);
        $statement->execute();
        $resultado = $statement->get_result();

        if ($resultado->num_rows > 0) {
            echo "El usuario ya existe";
        } else {
            $insertStatement = $conn->prepare('INSERT INTO Usuario (Nombre, Contraseña, Email) VALUES (?, ?, ?)');
            $insertStatement->bind_param('sss', $user, $password, $email);
            $insertStatement->execute();
            echo "Usuario registrado exitosamente";
            $insertStatement->close();
        }

        $statement->close();
        $conn->close();
    } else {
        echo "Las contraseñas no coinciden";
    }
} else {
    echo "Todos los campos son requeridos";
}

?>




















</head>

</form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
