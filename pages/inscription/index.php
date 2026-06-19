<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Inscriptions';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();
$stmt = $pdo->query("
    SELECT
        i.id_inscription,
        i.date_inscription,
        e.nom        AS eleve_nom,
        e.prenom     AS eleve_prenom,
        c.nom_classe,
        c.niveau
    FROM inscription i
    JOIN eleve  e ON i.id_eleve  = e.id_eleve
    JOIN classe c ON i.id_classe = c.id_classe
    ORDER BY i.date_inscription DESC
");
$inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">📝 Liste des Inscriptions</h1>
        <a href="create.php" class="btn btn-success">+ Nouvelle inscription</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Niveau</th>
                        <th>Date d'inscription</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inscriptions)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucune inscription enregistrée.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($inscriptions as $insc): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$insc['id_inscription']) ?></td>
                                <td>
                                    <?= htmlspecialchars($insc['eleve_nom']) ?>
                                    <?= htmlspecialchars($insc['eleve_prenom']) ?>
                                </td>
                                <td><?= htmlspecialchars($insc['nom_classe']) ?></td>
                                <td><?= htmlspecialchars($insc['niveau']) ?></td>
                                <td><?= htmlspecialchars($insc['date_inscription']) ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $insc['id_inscription'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $insc['id_inscription'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cette inscription ?')">🗑️ Supprimer</a>
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