<?php
// Démarrage de la session
session_start();

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit();
}

// Inclusion du fichier de configuration de la base de données
require_once "config.php";

// Initialisation des variables de message d'erreur et de succès
$message = "";
$success = "";

// Traitement du formulaire de connexion
if (isset($_POST['login'])) {
    // Récupération des données du formulaire
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation des données
    if (empty($email) || empty($password)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        // Vérification si l'utilisateur existe dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mdp'])) {
            // Création de la session et redirection vers la page d'accueil
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['last_activity'] = time();
            header("Location: welcome.php");
            exit();
        } else {
            $message = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<h1>Connexion</h1>
<?php if (!empty($message)) : ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<form method="post">
    <div>
        <label for="email">Adresse e-mail:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit" name="login">Se connecter</button>
</form>
<p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a>.</p>
</body>
</html>

