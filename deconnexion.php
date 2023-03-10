<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = array();

// Si on veut détruire complètement la session, il faut également effacer le cookie de session.
// Note : cela détruira la session, et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Enfin, on détruit la session
session_destroy();

// Rediriger vers la page d'accueil
header("Location: index.php");
exit();
?>
