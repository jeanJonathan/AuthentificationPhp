<?php

function dbConnect()
{
    $dbHost = 'localhost';
    $dbName = 'authentification';
    $dbUser = 'root';
    $dbPassword = '';

    try {
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);
        return $db;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function addUser($nom, $prenom, $email, $password, $role = 'user')
{
    $db = dbConnect();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = $db->prepare('INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (:nom, :prenom, :email, :password, :role)');
    $query->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => $role
    ]);
}

function getUserByEmail($email)
{
    $db = dbConnect();

    $query = $db->prepare('SELECT * FROM utilisateurs WHERE email = :email');
    $query->execute(['email' => $email]);

    $user = $query->fetch();

    return $user;
}

function updateUser($id, $nom, $prenom, $email, $role)
{
    $db = dbConnect();

    $query = $db->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, role = :role WHERE id = :id');
    $query->execute([
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'role' => $role
    ]);
}

function deleteUser($id)
{
    $db = dbConnect();

    $query = $db->prepare('DELETE FROM utilisateurs WHERE id = :id');
    $query->execute(['id' => $id]);
}

function getAllUsers()
{
    $db = dbConnect();

    $query = $db->query('SELECT * FROM utilisateurs');
    $users = $query->fetchAll();

    return $users;
}

function isUserAdmin($email)
{
    $user = getUserByEmail($email);

    if ($user && $user['role'] === 'admin') {
        return true;
    }

    return false;
}
