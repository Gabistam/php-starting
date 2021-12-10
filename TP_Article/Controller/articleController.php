<?php
require_once('../config/bdd.php');
ini_set('display_errors', '1');

if(isset($_POST['valider'])){
  post($_POST, $pdo);
}

function post($values, $pdo) // values = contenu de $_POST
{
  $req = $pdo->prepare("INSERT INTO article VALUES (NULL, :product_name, :content, :category,:path,:price, 1, now())");
  $req->bindParam(':product_name', $values['product_name'], PDO::PARAM_STR);
  $req->bindParam(':description', $values['content'], PDO::PARAM_STR);
  $req->bindParam(':category', $values['category'], PDO::PARAM_STR);
  $req->bindParam(':image', $values['url_picture'], PDO::PARAM_STR);
  $req->bindParam(':price', $values['price'], PDO::PARAM_INT);
  $req->execute();
}