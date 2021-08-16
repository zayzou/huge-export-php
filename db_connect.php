<?php
include "credential.php";

try{
    $pdo = new PDO($dsn,$username,$password,$options);
}catch (PDOException $ex){
    throw new PDOException($ex->getMessage());

}

/**
 * return array of data 
 */
function getData($query)
{
    global $pdo;
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}

//todo refactor export rgb



