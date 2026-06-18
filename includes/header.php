<?php
if(!isset($pageTitle)){
    $pageTitle="Gestion Scolaire";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($pageTitle) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?php

$path = str_repeat("../", substr_count($_SERVER['PHP_SELF'],'/')-2);

?>

<link rel="stylesheet" href="<?= $path ?>assets/css/style.css">


</head>


<body>


<?php
if(session_status()===PHP_SESSION_NONE){
    session_start();
}
?>