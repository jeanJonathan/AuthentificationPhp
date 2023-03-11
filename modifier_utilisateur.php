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