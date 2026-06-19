<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Modifier une classe';
$erreurs   = [];
$pdo       = getDBConnection();
$id        = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM classe WHERE id_classe = :id");
$stmt->execute([':id' => $id]);
$classe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$classe) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_classe = trim($_POST['nom_classe'] ?? '');
    $niveau     = trim($_POST['niveau']     ?? '');

    if ($nom_classe === '') $erreurs[] = 'Le nom de la classe est obligatoire.';
    if ($niveau === '')     $erreurs[] = 'Le niveau est obligatoire.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("UPDATE classe SET nom_classe = :nom_classe, niveau = :niveau WHERE id_classe = :id");
        $stmt->execute([':nom_classe' => $nom_classe, ':niveau' => $niveau, ':id' => $id]);
        header('Location: index.php?succes=modifie');
        exit;
    }
    $classe = array_merge($classe, $_POST);
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 500px;">

    <h1 class="h3 mb-4">✏️ Modifier la classe</h1>

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
                    <label class="form-label">Nom de la classe <span class="text-danger">*</span></label>
                    <input type="text" name="nom_classe" class="form-control"
                           value="<?= htmlspecialchars($classe['nom_classe']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Niveau <span class="text-danger">*</span></label>
                    <select name="niveau" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php
                        $niveaux = ['Première année','Deuxième année','Troisième année','Quatrième année'];
                        foreach ($niveaux as $n):
                            $sel = ($classe['niveau'] === $n) ? 'selected' : '';
                        ?>
                            <option value="<?= $n ?>" <?= $sel ?>><?= $n ?></option>
                        <?php endforeach; ?>
                    </select>
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