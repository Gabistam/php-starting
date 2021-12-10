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
                $sql = "UPDATE INTO `item`(`product_name`, `description`, `price`, `category`, `image`, `is_active`, `date`) VALUES (:product_name, :description, :price, :category, :image, 1, now())";

                //On prepare la reqête
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

                die("Article mise à jour ");

            }else {
                die("mise à jour incomplète");
            }
    }
    ?>


    
    <body>
        <h1> Ma boutique </h1>
         <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Modifier un article</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'articleUpdate.php?product_id='.$product_id;?>" role="form"  method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Nom:
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nom" value="<?php echo $product_name;?>">
                           
                        </div>
                        <div class="form-group">
                            <label for="description">Description:
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description;?>">
                            <span class="help-inline"><?php echo $descriptionError;?></span>
                        </div>
                        <div class="form-group">
                        <label for="price">Prix: (en €)
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price;?>">
                            <span class="help-inline"><?php echo $priceError;?></span>
                        </div>


                        <div class="form-group">
                            <label for="category">Catégorie:
                            <select class="form-control" id="category" name="category">
                            <?php

                               foreach ($db->query('SELECT * FROM categories') as $row) 
                               {
                                    if($row['product_id'] == $category)
                                        echo '<option selected="selected" value="'. $row['product_id'] .'">'. $row['product_name'] . '</option>';
                                    else
                                        echo '<option value="'. $row['product_id'] .'">'. $row['product_name'] . '</option>';;
                               }
                            ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <p><?php echo $image;?></p>
                            <label for="image">Sélectionner une nouvelle image:</label>
                            <input type="file" id="image" name="image"> 
                            <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$image;?>" alt="...">
                        <div class="price">
                            <?php echo number_format((float)$price, 2, '.', ''). ' €';?>
                        </div>
                        <div class="caption">
                            <h4><?php echo $product_name;?></h4>
                            <p><?php echo $description;?></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <?php require_once '../assets/script.php'; ?>
    </body>
</html>