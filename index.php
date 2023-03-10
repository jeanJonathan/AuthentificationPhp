<?php
//Connexion a la bd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=bd_authentification;charset=utf8', 'root', '');
    echo 'Connexion réussie à la base de données.';
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
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