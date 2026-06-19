<?php
require_once "../../config/database.php";

$pdo=getDBConnection();
$errors=[];

if($_SERVER['REQUEST_METHOD']=="POST"){

$matricule=trim($_POST['matricule']);

$nom=trim($_POST['nom']);

$prenom=trim($_POST['prenom']);

$date= $_POST['date_naissance'];

$email=trim($_POST['email']);

$adresse=trim($_POST['adresse']);

$telephone=trim($_POST['telephone']);

if(empty($matricule)||empty($nom)||empty($prenom)){

$errors[]="Les champs obligatoires sont requis.";

}

if(empty($errors)){

$stmt=$pdo->prepare("
SELECT COUNT(*)
FROM eleve
WHERE matricule=?
");

$stmt->execute([$matricule]);

if($stmt->fetchColumn()>0){

$errors[]="Ce matricule existe déjà.";

}
}

if(empty($errors)){

$stmt=$pdo->prepare("

INSERT INTO eleve
(
matricule,
nom,
prenom,
date_naissance,
email,
adresse,
telephone
)

VALUES (?,?,?,?,?,?,?)

");

$stmt->execute([

$matricule,
$nom,
$prenom,
$date,
$email,
$adresse,
$telephone

]);

header("Location:index.php");

exit;

}
}

$pageTitle="Ajouter élève";

require_once "../../includes/header.php";

require_once "../../includes/navbar.php";

?>

<div class="container">

<div class="card">

<div class="card-header">Ajouter un élève</div>

<div class="card-body">

<?php foreach($errors as $erreur): ?>

<div class="alert alert-danger">

<?=htmlspecialchars($erreur)?>

</div>

<?php endforeach; ?>

<form method="POST">
<input class="form-control mb-3"name="matricule"placeholder="Matricule">

<input class="form-control mb-3"name="nom"placeholder="Nom">

<input class="form-control mb-3"name="prenom"placeholder="Prénom">

<input type="date"class="form-control mb-3"name="date_naissance">

<input class="form-control mb-3"name="email"placeholder="Email">

<input class="form-control mb-3"name="adresse"placeholder="Adresse">

<input class="form-control mb-3"name="telephone"placeholder="Téléphone">

<button class="btn btn-success">Enregistrer</button>

</form>
</div>
</div>
</div>
<?php require_once "../../includes/footer.php"; ?>