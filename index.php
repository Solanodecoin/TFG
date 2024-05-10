<?php
session_start();
if(isset($_SESSION['usuario'])){ ?>

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
        <li><a href="cerrarsesion.php">Cerrar Sesión</a></li> 
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
        <li><a href="Perfil.html">Perfil</a></li>
        <li><a href="">Gender</a></li>
        <li><a href="#section3">Geo</a></li><br>
        <li><a href="cerrarsesion.php">Cerrar Sesión</a></li> 
      </ul>
    </div>
    <br>


    <div class="col-sm-9">
      
      <div class="well">


        <h4>Dashboard</h4>
        <h1>Crear Maquina Virtual</h1>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="vmname">Nombre de la Maquina</label>
        <input type="text" id="vmname" name="vmname" required>
        
        <label for="os_select">Sistema Operativo:</label>
        <select id="sistema" name="sistema">
            <option value="ubuntu">ubuntu</option>
            <option value="Debian">Debian</option>
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

<?php



// Verifica si se ha hecho clic en el enlace para iniciar la VM












$usuario = $_SESSION['usuario']  ;
$sistema = $_POST['sistema'];
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
    // Capturar el nombre de la maquina
    $vmname = $_POST['vmname'];
    
    // comando para realizar la importacion de la maquina
    
    


    // Verificar si el contenedor se creó correctamente
 

        $statement = $conn->stmt_init();
        $statement->prepare('SELECT nombre FROM Instancia WHERE nombre = ?');
        $statement->bind_param('s', $vmname);
        $statement->execute();
        $resultado = $statement->get_result();
        
        if ($resultado->num_rows > 0) {
          echo "Ya existe";
        }else{

        

          $output = shell_exec("sudo -u pablo VBoxManage import \"/media/pablo/8692CBAB92CB9E55/IMPORTACIONES/$sistema.ova\" --vsys 0 --vmname \"$vmname\"");
    
          $nombre_maquina = "NombreDeTuMaquina";


          $comando_buscar_vm = "VBoxManage list vms | grep '\"$vmname\"'";
          $resultado = shell_exec($comando_buscar_vm);

          if($resultado != ""){

            echo "Maquina creada correctamente";
            $conn = new mysqli("localhost", "pablo", "root", "leonardo");
            $statement = $conn->prepare('INSERT INTO Instancia (nombre, Tipo, Tamaño, idUsuario) VALUES (?, ?, ?, ?)');
            $statement->bind_param('ssss', $vmname, $sistema, $tamaño, $idUsuario);
            $statement->execute();
            $resultado = $statement->get_result();
            
          } else{ 
          echo "Hay problemas";
        }

        }
        
          

    } 
  

    $statement = $conn->stmt_init();
    $statement->prepare('SELECT nombre, Tamaño FROM Instancia WHERE idUsuario = ?');
    $statement->bind_param('s', $idUsuario);
    $statement->execute();
    $resultado = $statement->get_result();

    echo '<div>'; // Apertura del contenedor

    while ($registro = $resultado->fetch_assoc()) {
        $nombreVM = $registro['nombre'];
        $tamaño = $registro['Tamaño'];
        
        echo '<p>Nombre: ' . $nombreVM . ', Tamaño: ' . $tamaño . '</p><a href="index.php?accion=start_vm&vmname=' . $nombreVM . '">Start VM</a>' . '</p><a href="index.php?accion=stop_vm&vmname=' . $nombreVM . '">Stop VM</a>' . '</p><a href="index.php?accion=ip_vm&vmname=' . $nombreVM . '">IP VM</a>' . '<br>';

    }


     if (isset($_GET['accion']) && $_GET['accion'] === 'start_vm' ) {
      // Obtiene el ID de la instancia
      $vmname = $_GET['vmname'];
      echo $vmname;
      // Aquí debes sustituir "comando_para_iniciar_VM" por el comando real que necesites ejecutar para iniciar la VM
      shell_exec("sudo -u pablo VBoxManage startvm \"$vmname\" --type headless");
      
      // Mensaje de confirmación
      echo "La VM con ID: $vmname ha sido iniciada.";

      
  }
  

  

        if (isset($_GET['accion']) && $_GET['accion'] === 'ip_vm' ) {
          // Obtiene el ID de la instancia

          $vmname = $_GET['vmname'];
          $ip_command = "sudo -u pablo VBoxManage guestproperty get \"$vmname\" \"/VirtualBox/GuestInfo/Net/0/V4/IP\"";
          $ip_output = shell_exec($ip_command);

        // Aplicar expresión regular para extraer solo la IP
        preg_match('/Value: (\d+\.\d+\.\d+\.\d+)/', $ip_output, $matches);
        $ip = isset($matches[1]) ? $matches[1] : '';

        // Construir la URL con la variable $ip
        $url = "http://$ip:9090";

        // Mostrar el enlace si se pudo obtener la IP
        if (!empty($ip)) {
            echo "<p>La dirección IP es: <a href=\"$url\" target=\"_blank\">$ip</a></p>";
        } else {
            echo "<p>No se pudo obtener la IP.</p>";
        };
    
          
      }
  
      if (isset($_GET['accion']) && $_GET['accion'] === 'stop_vm' ) {
        // Obtiene el ID de la instancia
        $vmname = $_GET['vmname'];
        echo $vmname;
        // Aquí debes sustituir "comando_para_iniciar_VM" por el comando real que necesites ejecutar para iniciar la VM
        shell_exec("sudo -u pablo VBoxManage startvm \"$vmname\" --type headless");
        
        // Mensaje de confirmación
        echo "La VM con ID: $vmname ha sido iniciada.";
  
        
    }
    




    echo '</div>'; // Cierre del contenedor
?>

    
    <a href="login.php">Login</a>
    <a href="prueba.php">prueba</a>
    <a href="register.php">register</a>








<?php 

}else{
        print 'No has iniciado sesion';
        echo ' Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>



