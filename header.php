<?php
    if (isset($_SESSION)==0){
        session_start();
    }

    if (isset($_GET["deco"])){
        session_unset();
    }

    $database = "ecommerce";
    $host = "localhost";
    $utilisateur = "root";
    $mdp = "";
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC);

    $dsn = "mysql:dbname=".$database.";host=".$host;

    try {
        $connexion = new PDO($dsn,"root","",$options);
    } catch (Exception $e) {
        die("erreur :".$e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kalam&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comic+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
    <title>MgStore</title>
    <script src="./script/script.js" defer></script>
</head>
<body>
    <header> 
        <div class="logo">
            <img src="./img/logo.png">
        </div>    
        <nav>
            <ul>
                <li><a href="./index.php">Accueil</a></li>
                <li><a href="./produit.php">Produits</a></li>

                <?php 
                    if (isset($_SESSION["id"])){
                        echo '<li><a href="./compte.php">Mon compte</a></li>';
                        echo '<li><a href="./panier.php">Panier</a></li>';
                    } else {
                        echo '<li><a href="./inscription.php">Inscription</a></li>';
                        echo '<li><a href="./login.php">Se connecter</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header> 
                
    