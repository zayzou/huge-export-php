<?php
include "credential.php";

try{
    $pdo = new PDO($dsn,$username,$password,$options);
}catch (PDOException $ex){
    throw new PDOException($ex->getMessage());

}






