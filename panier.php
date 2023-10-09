<?php
    require "header.php";

    $id = $_SESSION["id"];

?>

<div class="panier">
    <?php

        $statement = $connexion->query("SELECT client_achat.id as id,nom,image FROM article,client_achat WHERE id_client='$id' AND id_article = article.id");
        $res = $statement->fetchALL();
        foreach( $res as $val) {
            echo '<div class="panier-item"><img class="img-prod" src="data:image/jpeg;base64,'.base64_encode($val['image']).'"/>';
            echo $val["nom"];
            echo " - <a href='./traitementProduit.php?traitement=suppPanier&id=".$val["id"]
            ."'>supprimer</a></div>";?><br><br><?php
            
        }

    ?>
</div>
<br>
<br>
    <a href="./traitementProduit.php?traitement=achat">Finaliser paiement</a>
<br>
<br>
<br>
<?php
    require "footer.php";
?>