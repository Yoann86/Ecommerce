<?php

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

    switch($_GET['traitement']){
        case "ajout":
            $nom = $_POST["nom"];
            $prix = intval($_POST["prix"]);
            $description = $_POST["description"];
            $quantite = intval($_POST["quantite"]);

            if (($nom == "") || ($prix == "") || ($quantite == "")){
                header('Location: ./produiteAjoute.php?erreur=infos');
                break;
            }

            if (isset($_FILES['image'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
        
                $statement = $connexion->prepare("INSERT INTO article (`nom`,`prix`,`description`,`quantite`,`image`) VALUES (?,?,?,?,?)");
                $statement->bindParam(1, $nom);
                $statement->bindParam(2, $prix);
                $statement->bindParam(3, $description);
                $statement->bindParam(4, $quantite);
                $statement->bindParam(5,$image, PDO::PARAM_LOB);
                $statement->execute();

                header('Location: ./produit.php');
                break;
                
            } 

            header('Location: ./produitAjoute.php?erreur=invalide');
            break;
        
        case "modifInfo":
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $description = $_POST['description'];
            $quantite = $_POST['quantite'];
            $id = $_GET["id"];


            if (($nom=="")||($prix=="")||($description=="")||($quantite=="")){
                header("Location: ./produitModif.php?erreur=infos&id=$id");
                break;
            }

            $statement = $connexion->prepare("UPDATE article SET nom = ?, prix = ?, `description` = ?, quantite = ? WHERE id = '$id'");
            $statement->bindParam(1, $nom);
            $statement->bindParam(2, $prix);
            $statement->bindParam(3, $description);
            $statement->bindParam(4, $quantite);
            $statement->execute();
        
            header("Location: ./produitModif.php?changement=infos&id=$id");
            break;
        
        case "modifImg":
            $id = $_GET["id"];

            if (isset($_FILES['image'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
        
                $statement = $connexion->prepare("UPDATE article SET `image` = ?  WHERE id = '$id'");
                $statement->bindParam(1,$image, PDO::PARAM_LOB);
                $statement->execute();

                header("Location: ./produitModif.php?changement=img&id=$id");
                break;
            } 
        
            header("Location: ./produitModif.php?oui=ouis&id=$id");
            break;
        
        case "supprimer":
            $id = $_GET["id"];

            $statement = $connexion->query("DELETE FROM article WHERE id = '$id'");

            header("Location: ./produit.php");
            break;

        case "ajoutPanier":

            if (isset($_SESSION)==0){
                session_start();
            }

            $idArticle = $_GET["id"];
            $idClient = $_SESSION["id"];

            $statement = $connexion->prepare("INSERT INTO client_achat (`id_client`,`id_article`) VALUES (?,?)");
            $statement->bindParam(1, $idClient);
            $statement->bindParam(2, $idArticle);
            $statement->execute();

            header("Location: ./produit.php");
            break;

        case "suppPanier":
            $id = $_GET["id"];

            $statement = $connexion->query("DELETE FROM client_achat WHERE id = '$id'");

            header("Location: ./panier.php");
            break;
        
        case "achat":

            if (isset($_SESSION)==0){
                session_start();
            }
            $id = $_SESSION["id"];

            $statement = $connexion->query("SELECT nom,prix,image  FROM client_achat,article WHERE id_client='$id' AND id_article=article.id");
            $res = $statement->fetchALL();

            foreach($res as $val){
                $nom = $val["nom"];
                $prix = $val["prix"];
                $image = $val["image"];
                $statement2 = $connexion->prepare("INSERT INTO historique (id_client,nom,prix,image) VALUES (?,?,?,?)");
                $statement2->bindParam(1, $id);
                $statement2->bindParam(2, $nom);
                $statement2->bindParam(3, $prix);
                $statement2->bindParam(4, $image, PDO::PARAM_LOB);
                $statement2->execute();
            }

            $statement = $connexion->query("DELETE FROM client_achat WHERE id_client = '$id'");

            header("Location: ./panier.php?changement=achat");
            break;
            
    }