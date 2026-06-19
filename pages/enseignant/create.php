<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Ajouter un enseignant';
$erreurs   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom       = trim($_POST['nom']       ?? '');
    $prenom    = trim($_POST['prenom']    ?? '');
    $specialite= trim($_POST['specialite']?? '');
    $email     = trim($_POST['email']     ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if ($nom === '')        $erreurs[] = 'Le nom est obligatoire.';
    if ($prenom === '')     $erreurs[] = 'Le prénom est obligatoire.';
    if ($specialite === '') $erreurs[] = 'La spécialité est obligatoire.';
    if ($email === '')      $erreurs[] = 'L\'email est obligatoire.';

    if (empty($erreurs)) {
        $pdo  = getDBConnection();
        $stmt = $pdo->prepare("
            INSERT INTO enseignant (nom, prenom, specialite, email, telephone)
            VALUES (:nom, :prenom, :specialite, :email, :telephone)
        ");
        $stmt->execute([
            ':nom'        => $nom,
            ':prenom'     => $prenom,
            ':specialite' => $specialite,
            ':email'      => $email,
            ':telephone'  => $telephone,
        ]);
        header('Location: index.php?succes=1');
        exit;
    }
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 600px;">

    <h1 class="h3 mb-4">👨‍🏫 Ajouter un enseignant</h1>

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
                    <label class="form-label">Spécialité <span class="text-danger">*</span></label>
                    <input type="text" name="specialite" class="form-control"
                           value="<?= htmlspecialchars($_POST['specialite'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
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