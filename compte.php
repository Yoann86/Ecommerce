<?php
    require "header.php";
    $id = $_SESSION["id"];
?>
<br>

<div class="compte-presentation">
    <h1>Bonjour <?=$_SESSION["prenom"] ?> <?=$_SESSION["nom"] ?>  </h1>
    <div class="compte">
        <a  href='./index.php?deco=1'>Se deconnecter</a>
    </div>
</div>

<div class="console">
    
        <?php 
            if (isset($_GET["erreur"])){
                if ($_GET["erreur"]=="infos"){
                    echo "<h5>Tous les champs doivent être remplis !</h5>";
                }
                if ($_GET["erreur"]=="mail"){
                    echo "<h5>Cet email est déjà utilisé !</h5>";
                }
            }

            if (isset($_GET["changement"])){
                if ($_GET["changement"]=="infos"){
                    echo "<h6>Informations modifiées avec succès !</h6>";
                }
                if ($_GET["changement"]=="mdp"){
                    echo "<h6>Mot de passe modifié avec succès ! </h6>";
                }
            }
        ?>
    
</div>


<div class="moncompte">

    <form action="./traitementClient.php?traitement=modifInfo"  method="post">
        <h1>Changer mes informations</h1>
        <label for=""><h3>Prénom</h3></label>
        <input type="text" name="prenom" placeholder="Votre prénom" value="<?php echo $_SESSION["prenom"]?>">
        <label for=""><h3>Nom</h3></label>
        <input type="text" name="nom" placeholder="Votre nom" value="<?php echo $_SESSION["nom"]?>">
        <label for=""><h3>Mail</h3></label>
        <input type="text" name="email" placeholder="Votre Email" value="<?php echo $_SESSION["email"]?>">
        <button type="submit" name="modif" value="modif">Modifier</button>
    </form>

    <form action="./traitementClient.php?traitement=modifMdp"  method="post">
        <h1>Changer mon mot de passe</h1>
        <input type="password" name="mdp" placeholder="Nouveau mdp" value="">
        <button type="submit" name="modifMdp" value="modifMdp">Changer</button>
    </form>

</div>


<div class="historique">
    <h1>Historique d'achat</h1>

    <?php 
        $statement = $connexion->query("SELECT * FROM historique WHERE id_client='$id'");
        $res = $statement->fetchALL();
        $res = array_reverse($res);
        foreach ($res as $val){
            echo '<img class="img-prod" src="data:image/jpeg;base64,'.base64_encode($val['image']).'"/>';
            echo "".$val['nom']." - ".$val['prix']."€"." - ".$val["date"] ?><br><br><br><br><?php
        }
    ?>
</div>

<?php
    require "footer.php";
?>