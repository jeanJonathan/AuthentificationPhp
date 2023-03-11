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
    <a href="utilisateurs.php">Non</a>
</form>
</body>
</html>
