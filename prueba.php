<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar el nombre del contenedor desde el formulario
    $container_name = $_POST['container_name'];
    
    // Comando para crear una instancia de Docker con el nombre proporcionado
    $output = shell_exec("docker run -d --name $container_name ubuntu");
    
    // Capturar el ID del contenedor recién creado
    $container_id = trim(shell_exec("docker ps -qf name=$container_name"));

    // Verificar si el contenedor se creó correctamente
    if ($container_id !== "") {
        echo "Se creó correctamente la instancia de Docker. ID del contenedor: $container_id";
    } else {
        echo "Error al crear la instancia de Docker.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear instancia Docker</title>
</head>
<body>
    <h1>Crear instancia Docker</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="container_name">Nombre del contenedor:</label>
        <input type="text" id="container_name" name="container_name" required>
        <input type="submit" value="Crear instancia">
    </form>
</body>
</html>
