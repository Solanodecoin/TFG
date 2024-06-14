<?php
session_start();
if(isset($_SESSION['usuario'])){ 
    $usuario = $_SESSION['usuario'];
    $sistema = $_POST['sistema'];
    $tamaño = $_POST['tamaño'];
    $conn = new mysqli("localhost", "pablo", "root", "leonardo");
    $stmt = $conn->prepare("SELECT idUsuario FROM Usuario WHERE nombre = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($idUsuario);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT Rol FROM Usuario WHERE idUsuario = ?");
    $stmt->bind_param("s", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($rol);
    $stmt->fetch();
    $stmt->close();

    
    ?>

<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard | Leonardo</title>
  <link rel="stylesheet" href="estilo.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>

<body>
<style>

body{
  background: lightgrey;
}


.vm-info {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
}

.vm-info p {
    margin: 0;
}

.vm-actions {
    margin-top: 5px;
}

.action-btn {
    display: inline-block;
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    margin-right: 5px;
}

.action-btn:hover {
    background-color: #0056b3;
}

.start {
    background-color: #28a745;
}

.stop {
    background-color: #dc3545;
}

.ip {
    background-color: #ffc107;
}


    .row.content {height: 550px}
    

    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    
      
    }
        

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

  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="/img/usuario-de-perfil.png" alt="">
          <span class="nav-item"><?php echo $usuario?></span>
        </a></li>
        <li  ><a href="index.php">
          <i class="fas fa-home" ></i>
          <span class="nav-item">Inicio</span>
        </a></li>
        <li id="on"><a href="vms.php">
          <i class="fas fa-desktop"></i>
          <span class="nav-item">Mis SV</span>
        </a></li>
        <li><a href="soporte.php">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Soporte</span>
        </a></li>
        <li><a href="cerrarsesion.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Salir</span>
        </a></li>
        <?php if ($rol == "admin") { ?>
        <li><a href="ticket.php">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Panel Soporte</span>
        </a></li>
        <?php } ?>
      </ul>
    </nav>

    <section class="main">
        <h1>Crear Nuevo SV</h1> </BR>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="vmname">Nombre de la Maquina</label>
        <input type="text" id="vmname" name="vmname" required>
        
        <label for="sistema">Sistema Operativo:</label>
        <select id="sistema" name="sistema">
            <option value="Ubuntu">Ubuntu</option>
            <option value="Windows">Windows</option>
        </select>
        
        <label for="tamaño">Tamaño:</label>
        <select id="tamaño" name="tamaño">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="big">Big</option>
        </select>
        
        <input type="submit" value="Crear instancia">
    </form>
        <br>

      <section class="main-course">
      <?php 
            
            
            $statement = $conn->stmt_init();
            $statement->prepare('SELECT nombre, Tamaño FROM Instancia WHERE idUsuario = ?');
            $statement->bind_param('s', $idUsuario);
            $statement->execute();
            $resultado = $statement->get_result();
        
        
            while ($registro = $resultado->fetch_assoc()) {
                $nombreVM = $registro['nombre'];
                $tamaño = $registro['Tamaño'];
                
                echo '
                <div class="vm-info">
            <p>Nombre: '. $nombreVM . ' | Tamaño: ' . $tamaño . ' </p>
            <div class="vm-actions">
                <a href="vms.php?accion=start_vm&vmname=' .$nombreVM .'" class="action-btn start">Start VM</a>
                <a href="vms.php?accion=stop_vm&vmname=' . $nombreVM .'" class="action-btn stop">Stop VM</a>
                <a href="vms.php?accion=ip_vm&vmname=' .$nombreVM .'" class="action-btn ip">IP VM</a>
                <a href="vms.php?accion=delete_vm&vmname=' .$nombreVM .'" class="action-btn stop">DELETE</a>
            </div>
        </div>
        ';
            }







            ?>
        
            
      </section>
    </section>
  </div>
</body>
</html></span>


<?php










if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $vmname = $_POST['vmname'];
    

 

        $statement = $conn->stmt_init();
        $statement->prepare('SELECT nombre FROM Instancia WHERE nombre = ?');
        $statement->bind_param('s', $vmname);
        $statement->execute();
        $resultado = $statement->get_result();
        
        if ($resultado->num_rows > 0) {
          echo '<script type="text/javascript">';
          echo 'alert("La maquina ' .$vmname . ' ya existe");';
          echo '</script>';
        }else{

        

          $output = shell_exec("sudo -u pablo VBoxManage import \"/media/pablo/8692CBAB92CB9E55/IMPORTACIONES/$sistema.ova\" --vsys 0 --vmname \"$vmname\"");
    
          $nombre_maquina = "NombreDeTuMaquina";


          $comando_buscar_vm = "VBoxManage list vms | grep '\"$vmname\"'";
          $resultado = shell_exec($comando_buscar_vm);

          if($resultado != ""){

            echo '<script type="text/javascript">';
            echo 'alert("La maquina ' .$vmname . ' ha sido creada correctamente");';
            echo '</script>';
            $conn = new mysqli("localhost", "pablo", "root", "leonardo");
            $statement = $conn->prepare('INSERT INTO Instancia (nombre, Tipo, Tamaño, idUsuario) VALUES (?, ?, ?, ?)');
            $statement->bind_param('ssss', $vmname, $sistema, $tamaño, $idUsuario);
            $statement->execute();
            $resultado = $statement->get_result();
            
          } else{ 
            echo '<script type="text/javascript">';
            echo 'alert("Hay algun problema, porfavor si no se soluciona abra un Ticket.");';
            echo '</script>';
        }

        }
        
          

    } 
  

    


     if (isset($_GET['accion']) && $_GET['accion'] === 'start_vm' ) {

      $vmname = $_GET['vmname'];
      echo $vmname;
     
      shell_exec("sudo -u pablo VBoxManage startvm \"$vmname\" --type headless");
      

      echo "";
      echo "<script type='text/javascript'>alert('La VM con ID: $vmname ha sido iniciada.');</script>";
      
  }
  

  

        if (isset($_GET['accion']) && $_GET['accion'] === 'ip_vm' ) {
  
         

          $vmname = $_GET['vmname'];
          $ip_command = "sudo -u pablo VBoxManage guestproperty get \"$vmname\" \"/VirtualBox/GuestInfo/Net/0/V4/IP\"";
          $ip_output = shell_exec($ip_command);
          preg_match('/Value: (\d+\.\d+\.\d+\.\d+)/', $ip_output, $matches);
          $ip = isset($matches[1]) ? $matches[1] : '';

          if (!empty($ip)) {
          $conn = new mysqli("localhost", "pablo", "root", "leonardo");
          $statement = $conn->prepare('SELECT Tipo from Instancia WHERE nombre = ?');
          $statement->bind_param('s', $vmname);
          $statement->execute();
          $resultado = $statement->get_result();

          $tipo =$resultado->fetch_assoc();


          
          
          
          
          if ($tipo['Tipo'] == "Windows"){

            echo '<script type="text/javascript">';
            echo 'alert("La IP de su máquina es:  ' . $ip . '");';
            echo '</script>';;

          }else{
            $url = "http://$ip:9090";

           
            echo '<script type="text/javascript">';
            echo 'alert("La IP de su máquina es: ' . $tipo['Tipo'] . '. Pincha en el siguiente enlace para acceder a ella: ' . $url . '");';
            echo '</script>';

          }
 
        




        

        
            
        } else {
          echo '<script type="text/javascript">';
          echo 'alert("No se pudo obtener la ip de la maquina: ' .$vmname . ', contacte con soporte.");';
          echo '</script>';
        };
    
          
      }
  
      if (isset($_GET['accion']) && $_GET['accion'] === 'stop_vm' ) {

        $vmname = $_GET['vmname'];
        echo $vmname;
       
        shell_exec("sudo -u pablo VBoxManage controlvm \"$vmname\"poweroff");
        

        echo '<script type="text/javascript">';
        echo 'alert("La maquina ' .$vmname . ' ha sido parada correctamente");';
        echo '</script>';
  
        
    }
    if (isset($_GET['accion']) && $_GET['accion'] === 'delete_vm' ){

      $vmname = $_GET['vmname'];
      $conn = new mysqli("localhost", "pablo", "root", "leonardo");
      $statement = $conn->prepare('DELETE  FROM Instancia WHERE nombre = ?');
      $statement->bind_param('s', $vmname);
      $statement->execute();
      $resultado = $statement->get_result();
      
      $comando_borrar_vm = "sudo -u pablo VBoxManage unregistervm \"$vmname\" --delete";


      $resultado = shell_exec($comando_borrar_vm);


      $comando_buscar_vm = "VBoxManage list vms | grep '\"$vmname\"'";
      $resultado_busqueda = shell_exec($comando_buscar_vm);

      echo '<script type="text/javascript">';
      echo 'alert("La maquina ' .$vmname . ' ha sido borrada correctamente");';
      echo '</script>';

    }




?>

<?php

}else{
        print 'No has iniciado sesion';
        echo ' Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>



