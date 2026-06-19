<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Modifier un élève';
$erreurs   = [];

$pdo = getDBConnection();
$id = (int)($_GET['id'] ?? 0);

if ($id === 0) {
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => $id]);
$eleve = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$eleve) {
    header('Location: index.php');
    exit;
}

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
        $stmt = $pdo->prepare("
            UPDATE eleve
            SET nom            = :nom,
                prenom         = :prenom,
                date_naissance = :date_naissance,
                email          = :email,
                adresse        = :adresse,
                telephone      = :telephone
            WHERE id_eleve = :id
        ");

        $stmt->execute([
            ':nom'            => $nom,
            ':prenom'         => $prenom,
            ':date_naissance' => $date_naissance,
            ':email'          => $email,
            ':adresse'        => $adresse,
            ':telephone'      => $telephone,
            ':id'             => $id,
        ]);

        header('Location: index.php?succes=modifie');
        exit;
    }
    $eleve = array_merge($eleve, $_POST);
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 600px;">

    <h1 class="h3 mb-4">✏️ Modifier l'élève</h1>

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
                           value="<?= htmlspecialchars($eleve['nom']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control"
                           value="<?= htmlspecialchars($eleve['prenom']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance" class="form-control"
                           value="<?= htmlspecialchars($eleve['date_naissance']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($eleve['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control"
                           value="<?= htmlspecialchars($eleve['adresse'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                           value="<?= htmlspecialchars($eleve['telephone'] ?? '') ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>