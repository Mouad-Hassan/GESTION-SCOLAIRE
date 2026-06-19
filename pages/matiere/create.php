<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Ajouter une matière';
$erreurs   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $libelle     = trim($_POST['libelle']     ?? '');
    $coefficient = (int)($_POST['coefficient'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if ($libelle === '')     $erreurs[] = 'Le libellé est obligatoire.';
    if ($coefficient <= 0)   $erreurs[] = 'Le coefficient doit être supérieur à 0.';

    if (empty($erreurs)) {
        $pdo  = getDBConnection();
        $stmt = $pdo->prepare("
            INSERT INTO matiere (libelle, coefficient, description)
            VALUES (:libelle, :coefficient, :description)
        ");
        $stmt->execute([
            ':libelle'     => $libelle,
            ':coefficient' => $coefficient,
            ':description' => $description,
        ]);
        header('Location: index.php?succes=1');
        exit;
    }
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 500px;">

    <h1 class="h3 mb-4">📖 Ajouter une matière</h1>

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
                    <label class="form-label">Libellé <span class="text-danger">*</span></label>
                    <input type="text" name="libelle" class="form-control"
                           value="<?= htmlspecialchars($_POST['libelle'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Coefficient <span class="text-danger">*</span></label>
                    <input type="number" name="coefficient" class="form-control" min="1" max="10"
                           value="<?= htmlspecialchars((string)($_POST['coefficient'] ?? '')) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
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