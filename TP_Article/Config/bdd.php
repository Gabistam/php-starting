<?php

    //Constante d'environnement
define("DBHOST", "localhost");
define("DBNAME", "shop");
define("DBUSER", "root");
define("DBPASS", "");


//DSN de connexion
$dsn = "mysql:dbname=" . DBNAME. ";host=".DBHOST;

try{
    //On instancie PDO
    $db = new PDO($dsn, DBUSER, DBPASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    

}catch(PDOException $e) {
    die("Erreur:" .$e->getMessage());
}
//Connexion ok à partir d'ici

    //Récupération des données tables
    
    $sql = "SELECT * FROM `item`";

    $requete = $db->query($sql);

?>
