<?php
session_start();
if(isset($_SESSION['usuario'])){ ?>


<?php


$usuario = $_SESSION['usuario']  ;
$os_select = $_POST['os_select'];
$tamaño = $_POST['tamaño'];
$conn = new mysqli("localhost", "pablo", "root", "leonardo");
$stmt = $conn->prepare("SELECT idUsuario FROM Usuario WHERE nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($idUsuario);
$stmt->fetch();
$stmt->close();



echo "Usuario : ". $usuario . "  Su id es:  ". $idUsuario . "  ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar el nombre del contenedor desde el formulario
    $container_name = $_POST['container_name'];
    //sudo docker run -itd --name grande2 ubuntu
    // Comando para crear una instancia de Docker con el nombre proporcionado
    $output = shell_exec("docker run -itd --name $container_name $os_select 2>&1");
    
    // Capturar el ID del contenedor recién creado
    $container_id = trim(shell_exec("docker ps -qf name=$container_name"));

    // Verificar si el contenedor se creó correctamente
    if ($container_id !== "") {
        echo "Se creó correctamente la instancia de Docker. ID del contenedor: $container_id";
        echo "El id del contenedor se asigno a tu cuenta.";
        
        $conn = new mysqli("localhost", "pablo", "root", "leonardo");
        $statement = $conn->prepare('INSERT INTO Instancia (idDocker, Tipo, Tamaño, idUsuario, Nombre) VALUES (?, ?, ?, ?, ?)');
        $statement->bind_param('sssss', $container_id, $os_select, $tamaño, $idUsuario, $container_name);
        $statement->execute();
        $resultado = $statement->get_result();


    } else {
        echo "Error al crear la instancia de Docker.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear instancia Docker</title>
    <link rel="stylesheet" href="estilos/estilos.css">
</head>
<body>

<div class="perfil">

<img class="perfil" src="img/usuario-de-perfil.png" alt="usuario-de-perfil.png">
<h2>Pablo</h2>

</div>

<div class="dashboard">


<div class="sidebar">
    <h2>Menú</h2>
    
    <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="Perfil.html">Perfil</a></li>
        <li><a href="Configuracion.html">Configuración</a></li>
        <li><a href="cerrarsesion.html">Cerrar sesión</a></li>
    </ul>
</div>
<div class="main-content">
<h1>Crear instancia Docker</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="container_name">Nombre del contenedor:</label>
        <input type="text" id="container_name" name="container_name" required>
        
        <label for="os_select">Sistema Operativo:</label>
        <select id="os_select" name="os_select">
            <option value="ubuntu">systemd-ubuntu</option>
            <option value="debian">debian</option>
        </select>
        
        <label for="tamaño">Tamaño:</label>
        <select id="tamaño" name="tamaño">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="big">Big</option>
        </select>
        
        <input type="submit" value="Crear instancia">
    </form>

    <?php
    $statement = $conn->stmt_init();
    $statement->prepare('SELECT idDocker, Tamaño, Nombre FROM Instancia WHERE idUsuario = ?');
    $statement->bind_param('s', $idUsuario);
    $statement->execute();
    $resultado = $statement->get_result();

    echo '<div>'; // Apertura del contenedor

    while ($registro = $resultado->fetch_assoc()) {
        $idInstancia = $registro['idDocker'];
        $tamaño = $registro['Tamaño'];
        $instancianombre = $registro['Nombre'];
        echo '<p>ID: ' . $idInstancia . ', Tamaño: ' . $tamaño . " ,Nombre: ". $instancianombre . '</p>';
    }

    echo '</div>'; // Cierre del contenedor
?>

    
    <a href="login.php">Login</a>
    <a href="prueba.php">prueba</a>
    <a href="register.php">register</a>



















    
</div>
</div>


    
</body>


</html>
<?php }else{
        print 'No has iniciado sesion';
        echo 'Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>
