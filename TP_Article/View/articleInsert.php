<?php
     
     require '../Config/bdd.php';
     ini_set('display_errors', '1');

?>

<!DOCTYPE html>
<html>
    <?php 
    require_once 'header.php'; 
    require_once '../Controller/articleController.php';

    //On traite le formulaire
    if(!empty($_POST)){
        if(
            isset($_POST["product_name"], $_POST["description"], $_POST["price"], $_POST["category"], $_POST["image"])
            && !empty($_POST["product_name"]) && !empty($_POST["description"]) && !empty($_POST["price"]) && !empty($_POST["category"]) && !empty($_POST["image"])){
                
                //Le formualaire est complet
                //On récupère les données en les protégeant (failles xss)
                //On retire toutes les balises du product_name
                $product_name = strip_tags($_POST["product_name"]);
                
                //On neutralise toute balise de la description
                $description = htmlspecialchars($_POST["description"]);

                //On peut les enregistrer et se connecter à la bdd
                require_once '../Config/bdd.php';

                //On écrit la requête
                $sql = "INSERT INTO `item`(`product_name`, `description`, `price`, `category`, `image`, `is_active`, `date`) VALUES (:product_name, :description, :price, :category, :image, 1, now())";

                //On prpare la reqête
                $query = $db->prepare($sql);

                //On injecte les valeurs
                $query->bindValue(":product_name", $product_name, PDO::PARAM_STR);
                $query->bindValue(":description", $description, PDO::PARAM_STR);
                $query->bindValue(":price", $_POST["price"], PDO::PARAM_INT);
                $query->bindValue(":category", $_POST["category"], PDO::PARAM_STR);
                $query->bindValue(":image", $_POST["image"], PDO::PARAM_STR);

                //On execute la requête
                if(!$query->execute()){
                    die("Une erreur es survenue!!!");
                }

                //On récupère le product_id de l'article
                //$product_id = $db->lastInserId();

                die("Article ajouté sous le numéro ");

            }else {
                die("Le formulaire est incomplet");
            }
    }
    ?>
    
    <body>
        
        
         <div class="container admin">
            <div class="row">
                <h1><strong>Ajouter un item</strong></h1>
                <br>
                <form class="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_name">Nom:</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nom">

                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="price">Prix: (en €)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix">
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <div>
                        <input type="radio" id="Homme" name="category" value="Homme"
                                checked>
                        <label for="Homme">Homme</label>
                        </div>

                        <div>
                        <input type="radio" id="category" name="category" value="Femme">
                        <label for="Femme">Femme</label>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="image">Saisir l'url de votre image:</label>
                        <input type="text" id="image" name="image" style="width: 100%"> 
                        
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="TP_Article/index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div> 
        <?php require_once '../assets/script.php'; ?>  
    </body>
</html>