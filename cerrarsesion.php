<?php


$_SESSION = array();

// Si estás usando cookies de sesión, destrúyelas también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión
session_destroy();

// Redirige a la página de inicio de sesión u otra página deseada
header("Location: index.php");
exit;
?>
