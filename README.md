# [Plan de Seguridad](https://drive.google.com/file/d/1Qrzuv5Zt8ZryuQqVVyqJ7Eqg5u0-BUS8/view?usp=drive_link)
# [Presentacion Final](https://drive.google.com/file/d/1GXlLSB3uTtHJ_nzSsJ-xaXygMC91Okrp/view?usp=drive_link)
# [Time Line](https://drive.google.com/file/d/16WIu4zxy5fRLojNl0Z6dqTc1A0Owtlk_/view?usp=drive_link)
# [Tutorial de Uso](https://drive.google.com/file/d/18ouAGCorZkZl2PuTw_7E2IYE1pN7w6ce/view?usp=drive_link)

# TFG

# 1. **Nombre del Proyecto:**

     **Servicio Virtualización Web (Leonardo)**

# 2. Integrantes del grupo:

Pablo Solano Colorado

Leandro Morales Aranda

# 3. Descripción:

Realizaremos un servicio de virtualización en la nube , para lanzar instancias en la misma. Elaboraremos bases de datos para almacenar los datos de los usuarios clientes, las instancias que adquieran y elaboraremos un correo corporativo del que dispondrán todos los clientes para cualquier tipo de asistencia. Será una alternativa a AWS y Azure.

# 4. Objetivos del proyecto:

`Crear una página web, que disponga de un servicio de virtualización para lanzar instancias en la misma.`

`Poder llevar a cabo todas las configuraciones de las instancias desde la propia web.`

`Permitir al usuario acceder a un dashboard, donde se mostrara información de la instancia junto a una consola para manipularla.`

`Proporcionar al usuario herramientas para la automatización y gestión de la configuración de las instancias.`

`Ofrecer al usuario variedad de tipos de instancias.`

`Establecer una facturación por tiempo de uso`

`Se realizara un plan de seguridad`

# 5. Tecnologías utilizadas:

     Ubuntu Desktop 20.04.

VirtualBox

Python.

DHCP, DNS y Servidor de correo.

Apache, PHP, HTML, CSS.

Cockpit Web Console.

# 6. Esquema E/R de la base de datos:


[![image-2.png](https://i.postimg.cc/2jH4Dcbv/image-2.png)](https://postimg.cc/NLHy8xxf)

[![image.png](https://i.postimg.cc/PJ6bVKZW/image.png)](https://postimg.cc/5QCF6Bsy)

    CREATE TABLE Usuario
    (
      idUsuario INT NOT NULL,
      Nombre INT NOT NULL,
      Contraseña INT NOT NULL,
      Email INT NOT NULL,
      Rol INT NOT NULL,
      Saldo INT NOT NULL,
      PRIMARY KEY (idUsuario)
    );
    
    CREATE TABLE Instancia
    (
      idInstancia INT NOT NULL,
      PrecioInicial INT NOT NULL,
      Tipo INT NOT NULL,
      Tamaño INT NOT NULL,
      idUsuario INT NOT NULL,
      PRIMARY KEY (idInstancia),
      FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario)
    );
    
    CREATE TABLE Pago
    (
      idPago INT NOT NULL,
      Cantidad INT NOT NULL,
      idUsuario INT NOT NULL,
      PRIMARY KEY (idPago),
      FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario)
    );
    
    CREATE TABLE Disco
    (
      idDisco INT NOT NULL,
      Almacenamiento INT NOT NULL,
      idInstancia INT NOT NULL,
      PRIMARY KEY (idDisco),
      FOREIGN KEY (idInstancia) REFERENCES Instancia(idInstancia)
    );
