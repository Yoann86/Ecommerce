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

    function testMail(string $email,$connexion){
        $statement = $connexion->query("SELECT id FROM utilisateur WHERE email='$email'");
        $res = $statement->fetchALL();
        return (empty($res)!=0);
    }

    switch($_GET['traitement']){
        case "ajout":
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            if (($nom == "") || ($prenom == "") || ($email == "") || ($mdp == "")){
                header('Location: ./inscription.php?erreur=infos');
                break;
            }

            if (testMail($email,$connexion)){
                $cout = ['cost' => 12];
                $hash = password_hash($mdp, PASSWORD_BCRYPT, $cout);
                $statement = $connexion->prepare("INSERT INTO utilisateur (`nom`,`prenom`,`email`,`mdp`) VALUES (?,?,?,?)");
                $statement->bindParam(1, $nom);
                $statement->bindParam(2, $prenom);
                $statement->bindParam(3, $email);
                $statement->bindParam(4, $hash);
                $statement->execute();
                header('Location: ./login.php');
                break;
            }

            header('Location: ./inscription.php?erreur=email');
            break;
        

        case "connexion":
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $statement = $connexion->query("SELECT * FROM utilisateur");
            $res = $statement->fetchALL();

            foreach($res as $val){
                if(password_verify($mdp, $val['mdp'])){
                    if ($email == $val['email']){
                        if (isset($_SESSION)==0){
                            session_start();
                        }
                        $_SESSION["id"] = $val["id"];
                        $_SESSION["prenom"] = $val["prenom"];
                        $_SESSION["nom"] = $val["nom"];     
                        $_SESSION["email"] = $val["email"];
                        $_SESSION["mdp"] = $val["mdp"];
                        $_SESSION["admin"] = $val["admin"];
                        header("Location: ./index.php");
                        return;
                    }
                }
            }
            header("Location: ./login.php?erreur=infos");
            break;
        
        case "modifInfo":

            if (isset($_SESSION)==0){
                session_start();
            }

            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $id = $_SESSION["id"];
            $ancienMail = $_SESSION["email"];

            if (($nom=="")||($prenom=="")||($email=="")){
                header('Location: ./compte.php?erreur=infos');
                break;
            }

            if ($ancienMail != $email){
                if (testMail($email,$connexion)!=1){
                    header('Location: ./compte.php?erreur=mail');
                    break;
                }
            }

            $statement = $connexion->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, email = ? WHERE id = '$id'");
            $statement->bindParam(1, $nom);
            $statement->bindParam(2, $prenom);
            $statement->bindParam(3, $email);
            $statement->execute();

            $_SESSION["prenom"] = $prenom;
            $_SESSION["nom"] = $nom; 
            $_SESSION["email"] = $email;
        
            header('Location: ./compte.php?changement=infos');
            break;

        case "modifMdp":
            $mdp = $_POST["mdp"];

            if ($mdp==""){
                header('Location: ./compte.php?erreur=infos');
                break;
            }

            if (isset($_SESSION)==0){
                session_start();
            }

            $id = $_SESSION["id"];
            $cout = ['cost' => 12];
            $hash = password_hash($mdp, PASSWORD_BCRYPT, $cout);
            
            $statement = $connexion->prepare("UPDATE utilisateur SET mdp = ? WHERE id = '$id'");
            $statement->bindParam(1, $hash);
            $statement->execute();
            header('Location: ./compte.php?changement=mdp');
            break;
                
    }

    