<?php

require_once "../../config/database.php";

$pdo=getDBConnection();

$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

if(!$id){

header("Location:index.php");
exit;

}

$stmt=$pdo->prepare("
SELECT *
FROM eleve
WHERE id_eleve=?
");

$stmt->execute([$id]);

$eleve=$stmt->fetch();

if(!$eleve){

header("Location:index.php");
exit;
}

$errors=[];

if($_SERVER['REQUEST_METHOD']=="POST"){

$matricule=trim($_POST['matricule']);

$nom=trim($_POST['nom']);

$prenom=trim($_POST['prenom']);

$date=$_POST['date_naissance'];

$email=trim($_POST['email']);

$adresse=trim($_POST['adresse']);

$telephone=trim($_POST['telephone']);

$stmt=$pdo->prepare("
SELECT COUNT(*)
FROM eleve
WHERE matricule=?
AND id_eleve<>?
");

$stmt->execute([
$matricule,
$id
]);

if($stmt->fetchColumn()>0){

$errors[]="Matricule déjà utilisé.";

}

if(empty($errors)){

$stmt=$pdo->prepare("

UPDATE eleve SET

matricule=?,

nom=?,

prenom=?,

date_naissance=?,

email=?,

adresse=?,

telephone=?

WHERE id_eleve=?

");

$stmt->execute([
$matricule,
$nom,
$prenom,
$date,
$email,
$adresse,
$telephone,
$id

]);

header("Location:index.php");
exit;
}
}

$pageTitle="Modifier élève";
require_once "../../includes/header.php";

require_once "../../includes/navbar.php";

?>
<div class="container">

<div class="card">

<div class="card-header">Modifier élève</div>

<div class="card-body">

<?php foreach($errors as $e): ?>

<div class="alert alert-danger">

<?=htmlspecialchars($e)?>

</div>

<?php endforeach; ?>

<form method="POST">

<input class="form-control mb-3"
name="matricule"
value="<?=htmlspecialchars($eleve['matricule'])?>">

<input class="form-control mb-3"
name="nom"
value="<?=htmlspecialchars($eleve['nom'])?>">

<input class="form-control mb-3"
name="prenom"
value="<?=htmlspecialchars($eleve['prenom'])?>">

<input type="date"
class="form-control mb-3"
name="date_naissance"
value="<?=$eleve['date_naissance']?>">

<input class="form-control mb-3"
name="email"
value="<?=htmlspecialchars($eleve['email'])?>">

<input class="form-control mb-3"
name="adresse"
value="<?=htmlspecialchars($eleve['adresse'])?>">

<input class="form-control mb-3"
name="telephone"
value="<?=htmlspecialchars($eleve['telephone'])?>">

<button class="btn btn-success">Modifier</button>

</form>
</div>
</div>
</div>
<?php require_once "../../includes/footer.php"; ?>