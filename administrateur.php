<?php
// Démarrage de la session
session_start();

// On verifie si user est defini et si l'utilisatuer a le role admin
//Si ce n'est pas le cas redirection vers index.php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

