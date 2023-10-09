<?php
    require "header.php";
?>
    
    <form action="./traitementClient.php?traitement=ajout" method="post">
        <h1>Inscription</h1>
        <label for="">Prénom</label>
        <input type="text" name="prenom" placeholder="Votre prénom" >
        <label for="">Nom</label>
        <input type="text" name="nom" placeholder="Votre nom" >
        <label for="">Mail</label>
        <input type="text" name="email" placeholder="Votre mail" >
        <label for="">Mot de passe</label>
        <input type="password" name="mdp" placeholder="Votre mdp">
        <button type="submit" name="inscription" value="inscription">Validez</button>
    </form>

    <br>
    <?php 
        if (isset($_GET["erreur"])){
            if ($_GET["erreur"]=="infos"){
                echo "Tous les champs doivent être remplis !";
            }
            if ($_GET["erreur"]=="email"){
                echo "Cet email est déjà utilisé !";
            }
        }
    ?>

<?php
    require "footer.php";
?>