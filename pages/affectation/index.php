<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Affectations';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();
$stmt = $pdo->query("
    SELECT
        a.id_affectation,
        a.annee_scolaire,
        c.nom_classe,
        c.niveau,
        e.nom        AS ens_nom,
        e.prenom     AS ens_prenom,
        e.specialite,
        m.libelle    AS matiere,
        m.coefficient
    FROM affectation a
    JOIN classe     c ON a.id_classe     = c.id_classe
    JOIN enseignant e ON a.id_enseignant = e.id_enseignant
    JOIN matiere    m ON a.id_matiere    = m.id_matiere
    ORDER BY a.annee_scolaire DESC, c.nom_classe ASC
");
$affectations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">🔗 Liste des Affectations</h1>
        <a href="create.php" class="btn btn-success">+ Nouvelle affectation</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Année scolaire</th>
                        <th>Classe</th>
                        <th>Enseignant</th>
                        <th>Matière</th>
                        <th class="text-center">Coefficient</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($affectations)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucune affectation enregistrée.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($affectations as $aff): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$aff['id_affectation']) ?></td>
                                <td><?= htmlspecialchars($aff['annee_scolaire']) ?></td>
                                <td>
                                    <?= htmlspecialchars($aff['nom_classe']) ?>
                                    <small class="text-muted">(<?= htmlspecialchars($aff['niveau']) ?>)</small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($aff['ens_nom']) ?>
                                    <?= htmlspecialchars($aff['ens_prenom']) ?>
                                    <small class="text-muted d-block"><?= htmlspecialchars($aff['specialite']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($aff['matiere']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        Coeff. <?= (int)$aff['coefficient'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $aff['id_affectation'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $aff['id_affectation'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cette affectation ?')">🗑️ Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>