<?php

require_once "../../config/database.php";

$pdo=getDBConnection();

$id=filter_input(
INPUT_POST,
'id',
FILTER_VALIDATE_INT
);

if($id){

try{

$stmt=$pdo->prepare("

DELETE FROM eleve

WHERE id_eleve=?

");

$stmt->execute([$id]);

}catch(PDOException $e){
}

}

header("Location:index.php");
exit;
?>