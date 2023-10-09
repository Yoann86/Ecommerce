<?php
    require "header.php";

    $id = $_GET["id"];
    $statement = $connexion->query("SELECT * FROM article WHERE id='$id'");
    $res = $statement->fetch();
    

?>

    <form action="./traitementProduit.php?traitement=modifInfo&id=<?=$id?>"  method="post">
        <h1>Modifier les informations du produit</h1>
        <label for="">Nom</label>
        <input type="text" name="nom" placeholder="Nom" value="<?= $res["nom"] ?>">
        <label for="">Prix</label>
        <input type="text" name="prix" placeholder="Nom" value="<?= $res["prix"] ?>">
        <label for="">Description</label>
        <input type="text" name="description" placeholder="Nom" value="<?= $res["description"] ?>">
        <label for="">Quantité</label>
        <input type="text" name="quantite" placeholder="Nom" value="<?= $res["quantite"] ?>">
        <button type="submit" name="modif" value="modif">Modifier</button>
    </form>

    <form action="./traitementProduit.php?traitement=modifImg&id=<?=$id?>" method="post" enctype="multipart/form-data">
        <h1>Modifier l'image du produit</h1>
        <input type="file" name="image">
        <button type="submit" name="modifImage" value="modifImage">Modifier</button>
    </form>