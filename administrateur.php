<?php
// Démarrage de la session
session_start();

// On verifie si user est defini et si l'utilisatuer a le role admin
//Si ce n'est pas le cas redirection vers index.php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}


// Récupération du nom de l'utilisateur connecté
require_once "config.php";
$stmt = $pdo->prepare("SELECT nom FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$nom = $user['nom'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Administrateur</title>
</head>
<body>
<h1>Bienvenue Administrateur : <?php echo $nom; ?></h1>
<p>Vous êtes connecté en tant qu'administrateur. Vous avez accès à certaines fonctionnalités réservées aux administrateurs.</p>
<p>
    <a href="gestion_sauvegarde.php">Gestion des sauvegardes</a> |
    <a href="gestion_utilisateur.php">Gestion des utilisateurs</a> |
    <a href="index.php">Se déconnecter</a>
</p>
</body>
</html>
