


   


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


<style>











form {
    max-width: 600px;
    margin: 0 auto;
    background: #f9f9f9;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}



input[type="submit"] {
    background: #333;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background: #575757;
}
</style>
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
            <li id="#" ><a href="index.php">
              <i class="fas fa-home" ></i>
              <span class="nav-item">Inicio</span>
            </a></li>
            <li><a href="vms.php">
              <i class="fas fa-desktop"></i>
              <span class="nav-item">Mis SV</span>
            </a></li>
            <li id="on"><a href="soporte.php">
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
 



    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h2>Enviar Ticket</h2>
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="detalles">Detalles:</label><br>
        <input type="text" id="detalles" name="detalles" maxlength="60" required><br><br>

        <input type="submit" value="Enviar Ticket">
    </form>

    <?php
session_start();

$usuario = $_SESSION['usuario'];
$descripcion = $_POST['descripcion'];
$detalles = $_POST['detalles'];

$conn = new mysqli("localhost", "pablo", "root", "leonardo");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT idUsuario FROM Usuario WHERE nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($idUsuario);
$stmt->fetch();
$stmt->close();

if ($idUsuario) {
    $stmt = $conn->prepare("INSERT INTO Tickets (Descripcion, Detalles, idUsuario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $descripcion, $detalles, $idUsuario);
    
    if ($stmt->execute()) {
        echo "Ticket enviado exitosamente.";
    } else {
        echo "Error al enviar el ticket: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Usuario no encontrado.";
}
?>

          </div>
         
        </section>
      </div>
    </body>
    </html></span>


     
      
          <section class="main">
            <div class="main-top">
            <h2>Enviar Ticket</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="detalles">Detalles:</label><br>
        <input type="text" id="detalles" name="detalles" maxlength="60" required><br><br>

        <input type="submit" value="Enviar Ticket">
    </form>

    

<?php }else{
        print 'No has iniciado sesion';
        echo ' Inicia sesión aquí: <a href="login.php">Login</a>';

        }?>




