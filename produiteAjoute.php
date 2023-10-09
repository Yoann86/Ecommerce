<?php
    require "header.php";
?>

    <form action="./traitementProduit.php?traitement=ajout" method="post" enctype="multipart/form-data">
        <h1>Référencer un nouveau produit</h1>
        
        <input type="text" name="nom" placeholder="Nom" >
        <label for=""></label>
        <input type="text" name="prix" placeholder="Prix" >
        <label for=""></label>
        <input type="text" name="description" placeholder="Une courte description" >
        <label for=""></label>
        <input type="text" name="quantite" placeholder="Quantité">
        <label for=""></label>
        <input type="file" name="image" >
        <button type="submit" name="inscription" value="inscription">Validez</button>
    </form>
