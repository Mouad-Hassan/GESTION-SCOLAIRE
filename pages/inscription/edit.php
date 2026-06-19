<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/bootstrap.php';

$pageTitle = 'Modifier une inscription';
$erreurs   = [];
$pdo       = getDBConnection();
$id        = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM inscription WHERE id_inscription = :id");
$stmt->execute([':id' => $id]);
$insc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$insc) { header('Location: index.php'); exit; }

$eleves  = $pdo->query("SELECT id_eleve, nom, prenom FROM eleve ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$classes = $pdo->query("SELECT id_classe, nom_classe, niveau FROM classe ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_eleve         = (int)($_POST['id_eleve']         ?? 0);
    $id_classe        = (int)($_POST['id_classe']        ?? 0);
    $date_inscription = trim($_POST['date_inscription']   ?? '');

    if ($id_eleve === 0)          $erreurs[] = 'Veuillez choisir un élève.';
    if ($id_classe === 0)         $erreurs[] = 'Veuillez choisir une classe.';
    if ($date_inscription === '')  $erreurs[] = 'La date est obligatoire.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE inscription
            SET date_inscription = :date_inscription,
                id_eleve         = :id_eleve,
                id_classe        = :id_classe
            WHERE id_inscription = :id
        ");
        $stmt->execute([
            ':date_inscription' => $date_inscription,
            ':id_eleve'         => $id_eleve,
            ':id_classe'        => $id_classe,
            ':id'               => $id,
        ]);
        header('Location: index.php?succes=modifie');
        exit;
    }
    $insc = array_merge($insc, $_POST);
}

require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 500px;">

    <h1 class="h3 mb-4">✏️ Modifier l'inscription</h1>

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
                    <label class="form-label">Élève <span class="text-danger">*</span></label>
                    <select name="id_eleve" class="form-select" required>
                        <option value="">-- Choisir un élève --</option>
                        <?php foreach ($eleves as $e): ?>
                            <option value="<?= $e['id_eleve'] ?>"
                                <?= ($insc['id_eleve'] == $e['id_eleve']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Classe <span class="text-danger">*</span></label>
                    <select name="id_classe" class="form-select" required>
                        <option value="">-- Choisir une classe --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c['id_classe'] ?>"
                                <?= ($insc['id_classe'] == $c['id_classe']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom_classe'] . ' — ' . $c['niveau']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date d'inscription <span class="text-danger">*</span></label>
                    <input type="date" name="date_inscription" class="form-control"
                           value="<?= htmlspecialchars($insc['date_inscription']) ?>" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>