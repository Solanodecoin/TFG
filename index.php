<?php
session_start();
if(isset($_SESSION['usuario'])){ 
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

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="UTF-8" />
      <title>Dashboard | Leonardo</title>
      <link rel="stylesheet" href="estilo.css" />
      <!-- Font Awesome Cdn Link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    </head>
    <body>
      <div class="container">
        <nav>
          <ul>
            <li><a href="#" class="logo">
              <img src="/img/usuario-de-perfil.png" alt="">
              <span class="nav-item"><?php echo $usuario?></span>
            </a></li>
            <li id="on" ><a href="index.php">
              <i class="fas fa-home" ></i>
              <span class="nav-item">Inicio</span>
            </a></li>
            <li><a href="vms.php">
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
          <div class="main-top">

          </div>
          <div class="main-skills">
           
          </div>

          <section class="main-course">
            <h1>Software</h1>
            <div class="course-box">
              
              <div class="course">
                <div class="box">
                  <h3>Cockpit Web Console</h3>
                  <br>
                  <button onclick="location.href='https://cockpit-project.org/'" >Acceder</button>
                  <i class="fa fa-terminal"></i>
                </div>
                <div class="box">
                  <h3>Grafana</h3>
                  <br>
                  <button onclick="location.href='http://192.168.1.21:3000'">Acceder</button>
                  <i class="img"><img src="/img/grafana.jpg" alt="" width="100" height="100" ></i>

                </div>
                <div class="box">
                  <h3>VirtualBox</h3>
                 <br>
                  <button onclick="location.href='https://www.virtualbox.org/'" > Acceder</button>
                  <i class="img"><img src="/img/Virtualbox_logo.png" alt="" width="100" height="100" ></i>
                  
                </div>
              </div>
            </div>
          </section>
        </section>
      </div>
    </body>
    </html></span>


<?php }else{
        header('Location: inicio.php');

        }?>




