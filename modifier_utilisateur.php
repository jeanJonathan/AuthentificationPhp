<?php
session_start();

// Vérification si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Inclure le fichier de configuration de la base de données
require_once "config.php";

// Initialiser les variables d'erreur et de succès
$error = "";
$success = "";

// Vérification si l'identifiant d'utilisateur est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Vérification si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les valeurs soumises du formulaire
        $nom = trim($_POST['nom']);
        $email = trim($_POST['email']);
        $mdp = trim($_POST['mdp']);
        $role = trim($_POST['role']);

        // Vérifier si le nom n'est pas vide
        if (empty($nom)) {
            $error = "Veuillez entrer un nom d'utilisateur valide.";
        }
        // Vérifier si l'adresse e-mail est valide
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Veuillez entrer une adresse e-mail valide.";
        }
        // Vérifier si le mot de passe est valide
        elseif (strlen($mdp) < 6) {
            $error = "Veuillez entrer un mot de passe d'au moins 6 caractères.";
        }
        // Si toutes les données sont valides, mise à jour des informations de l'utilisateur dans la base de données
        else {
            // Hasher le mot de passe avant de le stocker dans la base de données
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparer la requête SQL pour mettre à jour les informations de l'utilisateur
            $sql = "UPDATE utilisateurs SET nom=?, email=?, mdp=?, role=? WHERE id=?";

            // Préparer la requête et l'exécuter
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nom, $email, $mdp_hash, $role, $id])) {
                $success = "Les informations de l'utilisateur ont été mises à jour avec succès.";
            } else {
                $error = "Une erreur s'est produite lors de la mise à jour des informations de l'utilisateur.";
            }
        }
    } else {
        // Récupérer les informations de l'utilisateur à partir de la base de données
        $sql = "SELECT * FROM utilisateurs WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe dans la base de données
        if (!$user) {
            $error = "L'utilisateur spécifié n'existe pas.";
        } else {
            // Pré-remplir le formulaire avec les informations de l'utilisateur
            $nom = $user['nom'];
            $email = $user['email'];
            $role = $user['role'];
        }
    }
} else {
    $error = "L'identifiant d'utilisateur n'a pas été spécifié.";
}
?>
//Formulaire de modification
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<form method="post" action="modifier_utilisateur.php">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" value="<?php echo $user['nom']; ?>">

    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>">

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>">

    <label for="role">Role:</label>
    <select name="role">
        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
        <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Utilisateur</option>
    </select>

    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <input type="submit" value="Modifier">
</form>


</body>
</html>