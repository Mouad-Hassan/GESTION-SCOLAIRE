<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Ajouter un élève';
$erreurs   = [];  
$succes    = '';   

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom            = trim($_POST['nom']            ?? '');
    $prenom         = trim($_POST['prenom']         ?? '');
    $date_naissance = trim($_POST['date_naissance'] ?? '');
    $email          = trim($_POST['email']          ?? '');
    $adresse        = trim($_POST['adresse']        ?? '');
    $telephone      = trim($_POST['telephone']      ?? '');

    if ($nom === '')            $erreurs[] = 'Le nom est obligatoire.';
    if ($prenom === '')         $erreurs[] = 'Le prénom est obligatoire.';
    if ($date_naissance === '') $erreurs[] = 'La date de naissance est obligatoire.';
    if ($email === '')          $erreurs[] = 'L\'email est obligatoire.';

    if (empty($erreurs)) {
        $pdo = getDBConnection();

        $stmt = $pdo->prepare("
            INSERT INTO eleve (nom, prenom, date_naissance, email, adresse, telephone)
            VALUES (:nom, :prenom, :date_naissance, :email, :adresse, :telephone)
        ");

        $stmt->execute([
            ':nom'            => $nom,
            ':prenom'         => $prenom,
            ':date_naissance' => $date_naissance,
            ':email'          => $email,
            ':adresse'        => $adresse,
            ':telephone'      => $telephone,
        ]);

        header('Location: index.php?succes=1');
        exit;
    }
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 600px;">

    <h1 class="h3 mb-4">👨‍🎓 Ajouter un élève</h1>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($erreurs as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control"
                           value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance" class="form-control"
                           value="<?= htmlspecialchars($_POST['date_naissance'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control"
                           value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                           value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">💾 Enregistrer</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>