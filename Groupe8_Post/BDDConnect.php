<?php

    $hostBD = "localhost";
    // nom BD
    $nomBD = "MMIBLOG22";
    // Serveur
    // Avec encodage UTF8
    $serverBD = "mysql:dbname=$nomBD;host=$hostBD;charset=utf8";

    // nom utilisateur de connexion à la BDD
    $userBD = 'root';         // Votre login
    // mot de passe de connexion à la BDD
    $passBD = 'root';  

    try {
        $db = new PDO($serverBD, $userBD, $passBD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    } catch (PDOException $err) {
        die('Echec connexion GESTIONNOTES : ' . $err->getMessage());
    }
