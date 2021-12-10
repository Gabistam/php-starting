

<!DOCTYPE html>
<html>  
<!-- Insert header -->
<?php require_once 'view/header.php'; ?>

    <body>

        <div class="container admin">
            <div class="row">
                <h1><strong>Liste des article   </strong><a href="view/articleInsert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Prix</th>
                      <th>Catégorie</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require 'Config/bdd.php';
    

                    while($item = $requete->fetch(PDO::FETCH_ASSOC)) 
                      {
                        echo '<tr>';
                        echo '<td>'. $item['product_name'] . '</td>';
                        echo '<td>'. $item['description'] . '</td>';
                        echo '<td>'. number_format($item['price'], 2, '.', '') . '</td>';
                        echo '<td>'. $item['category'] . '</td>';
                        echo '<td width=300>';
                        echo '<a class="btn btn-default" href="view.php?product_id='.$item['product_id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                        echo ' ';
                        echo '<a class="btn btn-primary" href="View/articleUpdate.php"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="View/articleDelete.php?product_id='.$item['product_id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                      }

                  ?>
                  </tbody>
                </table>
            </div>
        </div>

      <?php require_once 'assets/script.php'; ?>

    </body>
</html>
