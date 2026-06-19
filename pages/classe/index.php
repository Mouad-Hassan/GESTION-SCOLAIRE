<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Classes';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();
$stmt = $pdo->query("
    SELECT
        c.id_classe,
        c.nom_classe,
        c.niveau,
        COUNT(i.id_inscription) AS nb_eleves
    FROM classe c
    LEFT JOIN inscription i ON c.id_classe = i.id_classe
    GROUP BY c.id_classe, c.nom_classe, c.niveau
    ORDER BY c.nom_classe ASC
");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">🏫 Liste des Classes</h1>
        <a href="create.php" class="btn btn-success">+ Ajouter une classe</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nom de la classe</th>
                        <th>Niveau</th>
                        <th class="text-center">Nb. Élèves</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($classes)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucune classe enregistrée.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($classes as $classe): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$classe['id_classe']) ?></td>
                                <td><?= htmlspecialchars($classe['nom_classe']) ?></td>
                                <td><?= htmlspecialchars($classe['niveau']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">
                                        <?= (int)$classe['nb_eleves'] ?> élève(s)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $classe['id_classe'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $classe['id_classe'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cette classe ?')">🗑️ Supprimer</a>
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