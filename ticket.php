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

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8" />
  <title>Dashboard | Leonardo</title>
  <link rel="stylesheet" href="estilo.css" />
  <link rel="stylesheet" href="style3.css" />
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
            <li id="#" ><a href="index.php">
              <i class="fas fa-home" ></i>
              <span class="nav-item">Inicio</span>
            </a></li>
            <li><a href="vms.php">
              <i class="fas fa-desktop"></i>
              <span class="nav-item">Mis SV</span>
            </a></li>
            <li ><a href="soporte.php">
              <i class="fas fa-question-circle"></i>
              <span class="nav-item">Soporte</span>
            </a></li>
            <li><a href="cerrarsesion.php" class="logout">
              <i class="fas fa-sign-out-alt"></i>
              <span class="nav-item">Salir</span>
            </a></li>
            
        <li><a href="ticket.php">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Panel Soporte</span>
        </a></li>
        
     
        
            
          </ul>
        </nav>


    <section class="main">
    <h1>Lista de Tickets</h1>
    <div class="ticket-container">
        
        <?php 
    
        $stmt = $conn->prepare("SELECT idTicket, Descripcion, Detalles, Estado FROM Tickets");
        $stmt->execute();
        $resultado = $stmt->get_result();
   
    
    while ($registro = $resultado->fetch_assoc()) {
      $idTicket = $registro['idTicket'];
      $descripcion = htmlspecialchars($registro['Descripcion']);
      $detalles = htmlspecialchars($registro['Detalles']);
      $estado = htmlspecialchars($registro['Estado']);
      
      echo '
      <div class="ticket">
          <h2>Ticket #' . $idTicket . '</h2>
          <p class="description">' . $descripcion . '. <span class="more-text" style="display: none;">' . $detalles . '</span></p>
          <p class="status ' . ($estado == 'Abierto' ? 'status-open' : 'status-closed') . '">' . $estado . '</p>
          <button onclick="toggleExpand(this)">Mostrar más</button>
      </div>';
      
  }
    ?></div>
        <!-- Agrega más tickets aquí -->
    </div>
    <script>
        function toggleExpand(button) {
            const ticket = button.parentElement;
            const moreText = ticket.querySelector('.more-text');

            if (moreText.style.display === "none") {
                moreText.style.display = "inline";
                button.textContent = 'Mostrar menos';
                ticket.classList.add('expanded');
            } else {
                moreText.style.display = "none";
                button.textContent = 'Mostrar más';
                ticket.classList.remove('expanded');
            }
        }
    </script>

    </section>
  </div>
</body>
</html></span>

<?php

}else{
        print 'No has iniciado sesion';
        echo ' Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>




    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   