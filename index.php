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



<div class="perfil">

<img class="perfil" src="img/usuario-de-perfil.png" alt="usuario-de-perfil.png">
<h2>Pablo</h2>

</div>


<div class="main-content">


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










<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    
      
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }

    footer {
            position: fixed;
            bottom: 0;
           
        }
        footer a {
            color: #fff;
            text-decoration: none;
        }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Dashboard</a></li>
        <li><a href="age.html">Age</a></li>
        <li><a href="#">Gender</a></li>
        <li><a href="#">Geo</a></li>
        <li><a href="#">Cerrar Sesión</a></li> 
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Logo</h2>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="index.html">Dashboard</a></li>
        <li><a href="age.html">Age</a></li>
        <li><a href="#section3">Gender</a></li>
        <li><a href="#section3">Geo</a></li><br>
        <li><a href="#">Cerrar Sesión</a></li> 
      </ul>
    </div>
    <br>
    
    <div class="col-sm-9">
      
      <div class="well">


        <h4>Dashboard</h4>
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


      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>Users</h4>
            <p>1 Million</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Pages</h4>
            <p>100 Million</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Sessions</h4>
            <p>10 Million</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Bounce</h4>
            <p>30%</p> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="well">
            <p>Text</p> 
            <p>Text</p> 
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <p>Text</p> 
            <p>Text</p> 
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <p>Text</p> 
            <p>Text</p> 
            <p>Text</p> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="well">
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <p>Text</p> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




</body>
</html>