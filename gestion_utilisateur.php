<?php
// Vérifier que l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer la liste de tous les utilisateurs
require_once('config.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM utilisateurs";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
</head>
<body>
<h1>Gestion des utilisateurs</h1>
<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Adresse e-mail</th>
        <th>Rôle</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['nom']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="modifier_utilisateur.php?id=<?php echo $user['id']; ?>">Modifier</a>
                <a href="supprimer_utilisateur.php?id=<?php echo $user['id']; ?>">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p><a href="administrateur.php">Retour à la page d'administration</a></p>
</body>
</html>
