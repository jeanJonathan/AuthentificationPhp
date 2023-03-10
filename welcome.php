<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once "config.php";

$user_id = $_SESSION['user_id'];

// Récupération de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Affichage du message de bienvenue
echo "Bienvenue, " . $user['prenom'] . " " . $user['nom'] . "!";
// Afficher un bouton de déconnexion
echo '<form action="deconnexion.php" method="post">
          <input type="submit" value="Déconnexion">
      </form>';
?>
