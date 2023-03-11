<?php
// Inclure le fichier de configuration de la base de données et les fonctions utiles
require_once 'config.php';
require_once 'functions.php';

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
/*
if (!isUserLoggedIn() || !isUserAdmin()) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: connexion.php');
    exit();
}
*/
// Vérifier si l'ID de l'utilisateur à supprimer a été envoyé en paramètre GET
/*
if (empty($_GET['id'])) {
    // Rediriger l'utilisateur vers la page d'accueil des utilisateurs
    header('Location: utilisateurs.php');
    exit();
}
*/

// Récupérer l'ID de l'utilisateur à supprimer depuis les paramètres GET
$user_id = $_GET['id'];

// Vérifier si l'utilisateur à supprimer existe dans la base de données
$user = getUserById($user_id);
if (!$user) {
    // Afficher un message d'erreur si l'utilisateur n'existe pas
    $_SESSION['error'] = "L'utilisateur avec l'ID $user_id n'existe pas.";
    header('Location: gestion_utilisateur.php');
    exit();
}

// Vérifier si le formulaire de confirmation de suppression a été soumis
if (!empty($_POST['confirm'])) {
    // Supprimer l'utilisateur de la base de données
    deleteUserById($user_id);

    // Afficher un message de succès
    $_SESSION['success'] = 'L\'utilisateur a été supprimé avec succès.';
    header('Location: gestion_utilisateur.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supprimer l'utilisateur <?php echo $user['nom'].' '.$user['prenom']; ?> - Mon application</title>
</head>
<body>
<h1>Supprimer l'utilisateur <?php echo $user['nom'].' '.$user['prenom']; ?></h1>

<p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>

<form method="post">
    <input type="submit" name="confirm" value="Oui">
    <a href="gestion_utilisateur.php">Non</a>
</form>
</body>
</html>
