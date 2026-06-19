<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Modifier une matière';
$erreurs   = [];
$pdo       = getDBConnection();
$id        = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM matiere WHERE id_matiere = :id");
$stmt->execute([':id' => $id]);
$matiere = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matiere) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $libelle     = trim($_POST['libelle']      ?? '');
    $coefficient = (int)($_POST['coefficient'] ?? 0);
    $description = trim($_POST['description']  ?? '');

    if ($libelle === '')   $erreurs[] = 'Le libellé est obligatoire.';
    if ($coefficient <= 0) $erreurs[] = 'Le coefficient doit être supérieur à 0.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE matiere
            SET libelle = :libelle, coefficient = :coefficient, description = :description
            WHERE id_matiere = :id
        ");
        $stmt->execute([
            ':libelle'     => $libelle,
            ':coefficient' => $coefficient,
            ':description' => $description,
            ':id'          => $id,
        ]);
        header('Location: index.php?succes=modifie');
        exit;
    }
    $matiere = array_merge($matiere, $_POST);
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 500px;">

    <h1 class="h3 mb-4">✏️ Modifier la matière</h1>

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
                           value="<?= htmlspecialchars($matiere['libelle']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Coefficient <span class="text-danger">*</span></label>
                    <input type="number" name="coefficient" class="form-control" min="1" max="10"
                           value="<?= htmlspecialchars((string)$matiere['coefficient']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($matiere['description'] ?? '') ?></textarea>
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