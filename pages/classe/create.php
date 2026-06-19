<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Ajouter une classe';
$erreurs   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_classe = trim($_POST['nom_classe'] ?? '');
    $niveau     = trim($_POST['niveau']     ?? '');

    if ($nom_classe === '') $erreurs[] = 'Le nom de la classe est obligatoire.';
    if ($niveau === '')     $erreurs[] = 'Le niveau est obligatoire.';

    if (empty($erreurs)) {
        $pdo  = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO classe (nom_classe, niveau) VALUES (:nom_classe, :niveau)");
        $stmt->execute([':nom_classe' => $nom_classe, ':niveau' => $niveau]);
        header('Location: index.php?succes=1');
        exit;
    }
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 500px;">

    <h1 class="h3 mb-4">🏫 Ajouter une classe</h1>

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
                           placeholder="Ex : 1A, 2B…"
                           value="<?= htmlspecialchars($_POST['nom_classe'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Niveau <span class="text-danger">*</span></label>
                    <select name="niveau" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php
                        $niveaux = ['Première année','Deuxième année','Troisième année','Quatrième année'];
                        foreach ($niveaux as $n):
                            $sel = (($_POST['niveau'] ?? '') === $n) ? 'selected' : '';
                        ?>
                            <option value="<?= $n ?>" <?= $sel ?>><?= $n ?></option>
                        <?php endforeach; ?>
                    </select>
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