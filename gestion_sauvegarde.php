<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des sauvegardes</title>
</head>
<body>
<h1>Gestion des sauvegardes</h1>
<p>Vous pouvez sauvegarder et restaurer la base de données à partir de cette page.</p>

<form action="gestion_sauvegarde.php" method="post">
    <input type="submit" name="sauvegarder" value="Sauvegarder la base de données">
    <input type="submit" name="restaurer" value="Restaurer la base de données">
</form>

</body>
</html>
<?php
// Connexion à la base de données
require_once('config.php');

// Vérification si l'utilisateur a cliqué sur le bouton sauvegarder
if (isset($_POST['sauvegarder'])) {
    // Nom du fichier de sauvegarde
    $backup_file = 'backup-' . date('Y-m-d_H-i-s') . '.sql';

    // on a ajouté le nom de la table utilisateurs à la commande de sauvegarde, ce qui permet de ne sauvegarder que les données de cette table.
    $command = "mysqldump --user=" . DB_USER . " --password=" . DB_PASS . " --host=" . DB_HOST . " " . DB_NAME . " utilisateurs > " . $backup_file;

    // Exécution de la commande
    system($command);

    echo "<p>La base de données a été sauvegardée dans le fichier $backup_file</p>";
}


// Vérification si l'utilisateur a cliqué sur le bouton restaurer
if (isset($_POST['restaurer'])) {
    // Vérification si un fichier de sauvegarde a été sélectionné
    if (isset($_FILES['backup_file']) && $_FILES['backup_file']['error'] == 0) {
        // Récupération du fichier de sauvegarde
        $backup_file = $_FILES['backup_file']['tmp_name'];

        // Commande de restauration de la base de données
        $command = "mysql --user=" . DB_USER . " --password=" . DB_PASSWORD . " --host=" . DB_HOST . " " . DB_NAME . " < " . $backup_file;

        // Exécution de la commande
        system($command);

        echo "<p>La base de données a été restaurée à partir du fichier $backup_file</p>";
    } else {
        echo "<p>Veuillez sélectionner un fichier de sauvegarde valide</p>";
    }
}
?>
