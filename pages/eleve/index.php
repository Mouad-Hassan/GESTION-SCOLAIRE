<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Élèves';

require_once __DIR__ . '/../../includes/header.php';

require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();

$stmt = $pdo->query("SELECT * FROM eleve ORDER BY nom ASC");

$eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">👨‍🎓 Liste des Élèves</h1>
        <a href="create.php" class="btn btn-success">+ Ajouter un élève</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($eleves)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Aucun élève enregistré.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($eleves as $eleve): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$eleve['id_eleve']) ?></td>
                                <td><?= htmlspecialchars($eleve['nom']) ?></td>
                                <td><?= htmlspecialchars($eleve['prenom']) ?></td>
                                <td><?= htmlspecialchars($eleve['date_naissance']) ?></td>
                                <td><?= htmlspecialchars($eleve['email']) ?></td>
                                <td><?= htmlspecialchars($eleve['adresse']) ?></td>
                                <td><?= htmlspecialchars($eleve['telephone']) ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $eleve['id_eleve'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $eleve['id_eleve'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cet élève ?')">🗑️ Supprimer</a>
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