<?php
//Connexion a la bd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=bd_authentification;charset=utf8', 'root', '');
    echo 'Connexion réussie à la base de données.';
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}

// Traitement du formulaire d'inscription
if(isset($_POST['inscription'])) {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    // Vérification de l'adresse e-mail
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse e-mail invalide";
    } else {
        // Vérification de l'existence de l'adresse e-mail dans la base de données
        $requete = $bdd->prepare("SELECT COUNT(*) AS nb FROM utilisateurs WHERE email = ?");
        $requete->execute(array($email));
        $resultat = $requete->fetch();
        $requete->closeCursor();

        if($resultat['nb'] > 0) {
            $erreur = "Cette adresse e-mail est déjà utilisée";
        } else {
            // Insertion des données dans la base de données
            $requete = $bdd->prepare("INSERT INTO utilisateurs(nom, prenom, email, mdp) VALUES(?, ?, ?, ?)");
            $requete->execute(array($nom, $prenom, $email, $mdp));
            $requete->closeCursor();

            // Redirection vers la page de connexion
            header("Location: connexion.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Inscription</h1>

<form method="post">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br>
    <label>Prénom :</label><br>
    <input type="text" name="prenom" required><br>
    <label>Adresse e-mail :</label><br>
    <input type="email" name="email" required><br>
    <label>Mot de passe :</label><br>
    <input type="password" name="mdp" required><br>
    <input type="submit" name="inscription" value="S'inscrire">
</form>
</body>
</html>