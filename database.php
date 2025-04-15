<?php 
    $dsn = "mysql:host=localhost;dbname=to do list;charset=utf8";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "You are connected";
    } catch (PDOException $e) {     
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
?>