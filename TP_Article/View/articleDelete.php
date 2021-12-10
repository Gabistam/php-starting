<?php
    require '../Config/bdd.php';
 
    if(!empty($_GET['product_id'])) 
    {
        $product_id = checkInput($_GET['product_id']);
    }

    if(!empty($_POST)) 
    {
        $product_id = checkInput($_POST['product_id']);
        $statement = $db->prepare("DELETE FROM items WHERE product_id = ?");
        $statement->execute(array($product_id));
        header("Location: index.php"); 
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>
  
<!DOCTYPE html>
<html>

<!-- Insert header -->

  <?php require_once '../view/header.php'; ?>
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> TP Article <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer un item</strong></h1>
                <br>
                <form class="form" action="delete.php" role="form" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="index.php">Non</a>
                    </div>
                </form>
            </div>
        </div>   
    </body>
</html>

