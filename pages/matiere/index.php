<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Matières';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();

$stmt    = $pdo->query("SELECT * FROM matiere ORDER BY libelle ASC");
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">📖 Liste des Matières</h1>
        <a href="create.php" class="btn btn-success">+ Ajouter une matière</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th class="text-center">Coefficient</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($matieres)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucune matière enregistrée.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($matieres as $matiere): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$matiere['id_matiere']) ?></td>
                                <td><?= htmlspecialchars($matiere['libelle']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        Coeff. <?= (int)$matiere['coefficient'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($matiere['description'] ?? '') ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $matiere['id_matiere'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $matiere['id_matiere'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cette matière ?')">🗑️ Supprimer</a>
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