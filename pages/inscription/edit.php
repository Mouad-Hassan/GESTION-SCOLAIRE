<?php

$pageTitle = 'Modifier une inscription';
$erreurs = [];
require_once '../../config/database.php';
$pdo = getDBConnection();

/* ID inscription */
$id = (int)($_GET['id'] ?? 0);

if ($id == 0) {
    header('Location: index.php');
    exit;
}

/* inscription */
$stmt = $pdo->prepare("SELECT * FROM inscription WHERE id_inscription = ?");
$stmt->execute([$id]);
$insc = $stmt->fetch();

if (!$insc) {
    header('Location: index.php');
    exit;
}

/* données */
$eleves = $pdo->query("SELECT id_eleve, nom, prenom FROM eleve ORDER BY nom")->fetchAll();
$classes = $pdo->query("SELECT id_classe, nom_classe, niveau FROM classe ORDER BY nom_classe")->fetchAll();

/* submit */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_eleve = $_POST['id_eleve'] ?? '';
    $id_classe = $_POST['id_classe'] ?? '';
    $date_inscription = $_POST['date_inscription'] ?? '';

    /* validation */
    if ($id_eleve == '') $erreurs[] = "Choisir un élève";
    if ($id_classe == '') $erreurs[] = "Choisir une classe";
    if ($date_inscription == '') $erreurs[] = "Date obligatoire";

    if (empty($erreurs)) {

        $stmt = $pdo->prepare("
            UPDATE inscription
            SET id_eleve = ?, id_classe = ?, date_inscription = ?
            WHERE id_inscription = ?
        ");

        $stmt->execute([
            $id_eleve,
            $id_classe,
            $date_inscription,
            $id
        ]);

        header('Location: index.php?success=1');
        exit;
    }

    /* garder valeurs */
    $insc['id_eleve'] = $id_eleve;
    $insc['id_classe'] = $id_classe;
    $insc['date_inscription'] = $date_inscription;
}

require_once '../../includes/header.php';
require_once '../../includes/navbar.php';
?>

<div class="container mt-4" style="max-width: 520px;">

    <h2 class="mb-3">✏️ Modifier inscription</h2>

    <?php if (!empty($erreurs)): ?>
        <div style="background:#ffdddd;padding:10px;margin-bottom:10px;">
            <?php foreach ($erreurs as $e): ?>
                <p style="margin:0;">• <?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div style="margin-bottom:10px;">
            <label>Élève</label><br>
            <select name="id_eleve" style="width:100%;padding:5px;">
                <option value="">-- choisir --</option>
                <?php foreach ($eleves as $e): ?>
                    <option value="<?= $e['id_eleve'] ?>"
                        <?= ($insc['id_eleve'] == $e['id_eleve']) ? 'selected' : '' ?>>
                        <?= $e['nom'] . ' ' . $e['prenom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>Classe</label><br>
            <select name="id_classe" style="width:100%;padding:5px;">
                <option value="">-- choisir --</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id_classe'] ?>"
                        <?= ($insc['id_classe'] == $c['id_classe']) ? 'selected' : '' ?>>
                        <?= $c['nom_classe'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>Date inscription</label><br>
            <input type="date" name="date_inscription"
                   value="<?= $insc['date_inscription'] ?>"
                   style="width:100%;padding:5px;">
        </div>

        <button type="submit" style="padding:8px 15px;">
            Mettre à jour
        </button>

    </form>

</div>

<?php require_once '../../includes/footer.php'; ?>