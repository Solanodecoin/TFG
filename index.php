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
        <li><a href="">
          <i class="fas fa-user"></i>
          <span class="nav-item">Perfil</span>
        </a></li>
        <li><a href="vms.php">
          <i class="fas fa-desktop"></i>
          <span class="nav-item">Mis SV</span>
        </a></li>
        <li><a href="">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Soporte</span>
        </a></li>
        <li><a href="" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Salir</span>
        </a></li>
      </ul>
    </nav>

    <section class="main">
      <div class="main-top">

      </div>
      <div class="main-skills">
        <div class="card">
          <i class="fas fa-laptop-code"></i>
          <h3>Web developemt</h3>
          <p>Join Over 1 million Students.</p>
          <button>Get Started</button>
        </div>
        <div class="card">
          <i class="fab fa-wordpress"></i>
          <h3>WordPress</h3>
          <p>Join Over 3 million Students.</p>
          <button>Get Started</button>
        </div>
        <div class="card">
          <i class="fas fa-palette"></i>
          <h3>graphic design</h3>
          <p>Join Over 2 million Students.</p>
          <button>Get Started</button>
        </div>
        <div class="card">
          <i class="fab fa-app-store-ios"></i>
          <h3>IOS dev</h3>
          <p>Join Over 1 million Students.</p>
          <button>Get Started</button>
        </div>
      </div>

      <section class="main-course">
        <h1>My courses</h1>
        <div class="course-box">
          <ul>
            <li class="active">In progress</li>
            <li>explore</li>
            <li>incoming</li>
            <li>finished</li>
          </ul>
          <div class="course">
            <div class="box">
              <h3>HTML</h3>
              <p>80% - progress</p>
              <button>continue</button>
              <i class="fab fa-html5 html"></i>
            </div>
            <div class="box">
              <h3>CSS</h3>
              <p>50% - progress</p>
              <button>continue</button>
              <i class="fab fa-css3-alt css"></i>
            </div>
            <div class="box">
              <h3>JavaScript</h3>
              <p>30% - progress</p>
              <button>continue</button>
              <i class="fab fa-js-square js"></i>
            </div>
          </div>
        </div>
      </section>
    </section>
  </div>
</body>
</html></span>

<?php

}else{
        print 'No has iniciado sesion';
        echo ' Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>



