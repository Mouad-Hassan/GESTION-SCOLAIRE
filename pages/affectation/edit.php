<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Modifier une affectation';
$erreurs   = [];
$pdo       = getDBConnection();
$id        = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM affectation WHERE id_affectation = :id");
$stmt->execute([':id' => $id]);
$aff = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aff) { header('Location: index.php'); exit; }

$classes     = $pdo->query("SELECT id_classe, nom_classe, niveau FROM classe ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);
$enseignants = $pdo->query("SELECT id_enseignant, nom, prenom, specialite FROM enseignant ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$matieres    = $pdo->query("SELECT id_matiere, libelle FROM matiere ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $annee_scolaire = trim($_POST['annee_scolaire'] ?? '');
    $id_classe      = (int)($_POST['id_classe']      ?? 0);
    $id_enseignant  = (int)($_POST['id_enseignant']  ?? 0);
    $id_matiere     = (int)($_POST['id_matiere']     ?? 0);

    if ($annee_scolaire === '') $erreurs[] = 'L\'année scolaire est obligatoire.';
    if ($id_classe === 0)       $erreurs[] = 'Veuillez choisir une classe.';
    if ($id_enseignant === 0)   $erreurs[] = 'Veuillez choisir un enseignant.';
    if ($id_matiere === 0)      $erreurs[] = 'Veuillez choisir une matière.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE affectation
            SET annee_scolaire = :annee_scolaire,
                id_classe      = :id_classe,
                id_enseignant  = :id_enseignant,
                id_matiere     = :id_matiere
            WHERE id_affectation = :id
        ");
        $stmt->execute([
            ':annee_scolaire' => $annee_scolaire,
            ':id_classe'      => $id_classe,
            ':id_enseignant'  => $id_enseignant,
            ':id_matiere'     => $id_matiere,
            ':id'             => $id,
        ]);
        header('Location: index.php?succes=modifie');
        exit;
    }
    $aff = array_merge($aff, $_POST);
}

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 550px;">

    <h1 class="h3 mb-4">✏️ Modifier l'affectation</h1>

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
                    <label class="form-label">Année scolaire <span class="text-danger">*</span></label>
                    <input type="text" name="annee_scolaire" class="form-control"
                           value="<?= htmlspecialchars($aff['annee_scolaire']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Classe <span class="text-danger">*</span></label>
                    <select name="id_classe" class="form-select" required>
                        <option value="">-- Choisir une classe --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= $c['id_classe'] ?>"
                                <?= ($aff['id_classe'] == $c['id_classe']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom_classe'] . ' — ' . $c['niveau']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Enseignant <span class="text-danger">*</span></label>
                    <select name="id_enseignant" class="form-select" required>
                        <option value="">-- Choisir un enseignant --</option>
                        <?php foreach ($enseignants as $e): ?>
                            <option value="<?= $e['id_enseignant'] ?>"
                                <?= ($aff['id_enseignant'] == $e['id_enseignant']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nom'] . ' ' . $e['prenom'] . ' (' . $e['specialite'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Matière <span class="text-danger">*</span></label>
                    <select name="id_matiere" class="form-select" required>
                        <option value="">-- Choisir une matière --</option>
                        <?php foreach ($matieres as $m): ?>
                            <option value="<?= $m['id_matiere'] ?>"
                                <?= ($aff['id_matiere'] == $m['id_matiere']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['libelle']) ?>
                            </option>
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