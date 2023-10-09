<?php
    require "header.php";
?>
    
    <form action="./traitementClient.php?traitement=connexion" method="post">
        <h1>Se connecter</h1>
        <label for="">Mail</label>
        <input type="text" name="email" placeholder="Votre mail" >
        <label for="">Mot de passe</label>
        <input type="password" name="mdp" placeholder="Votre mdp">
        <button type="submit" name="Se connecter" value="Se connecter">Se connecter</button>
    </form>

    <br>

    <?php 
        if (isset($_GET["erreur"])){
            if ($_GET["erreur"]=="infos"){
                echo "Les informations de connexion sont erronées !";
            }
        }
        
    ?>

<?php
    require "footer.php";
?>