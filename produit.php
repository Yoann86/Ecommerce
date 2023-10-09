<?php
    require "header.php";
?>
    <div class="grid-article">
        <?php 
            $statement = $connexion->query("SELECT * FROM article");
            $res = $statement->fetchALL();

            foreach ($res as $val){
                echo '<div class="tome"><div class="tome-couverture"><img class="img-prod" src="data:image/jpeg;base64,'
                .base64_encode($val['image']).'"/> <div class="tome-description"><p>'.$val["description"]
                ."</p></div></div>";
                echo "<h1>".$val['nom']."</h1> ".$val['prix']."€"." - quantité : ".$val["quantite"];
                ?><div class="options"><?php
                if (isset($_SESSION["id"])){
                    echo "<a href='./traitementProduit.php?traitement=ajoutPanier&id=".$val["id"]
                    ."'>Ajouter au panier</a>";
                } 
                
                if (isset($_SESSION["admin"])){
                    if ($_SESSION["admin"]==1){
                        echo " - <a href='./produitModif.php?id=".$val["id"]
                        ."'>modifier</a>";
                        echo " - <a href='./traitementProduit.php?traitement=supprimer&id=".$val["id"]
                        ."'>supprimer</a>";
                    }
                }
                ?></div></div><?php
            }
        ?>
    </div>
    
    <div class="admin">
        <?php
            if (isset($_SESSION["admin"])){
                if ($_SESSION["admin"]==1){
                    echo '<a href="./produiteAjoute.php">Référencer un nouveau produit</a>';
                }
            }
        ?>
    </div>

<?php
    require "footer.php";
?>