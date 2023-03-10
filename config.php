<?php
// Informations de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'bd_authentification');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuration de l'application
define('BASE_URL', 'http://localhost/http://training1/AuthentificationPhp/');
define('APP_NAME', 'AuthentificationPhp');

// Options de configuration
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}
