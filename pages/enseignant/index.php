<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des Enseignants';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();
$stmt    = $pdo->query("SELECT * FROM enseignant ORDER BY nom ASC");
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">👨‍🏫 Liste des Enseignants</h1>
        <a href="create.php" class="btn btn-success">+ Ajouter un enseignant</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Spécialité</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($enseignants)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun enseignant enregistré.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($enseignants as $ens): ?>
                            <tr>
                                <td><?= htmlspecialchars((string)$ens['id_enseignant']) ?></td>
                                <td><?= htmlspecialchars($ens['nom']) ?></td>
                                <td><?= htmlspecialchars($ens['prenom']) ?></td>
                                <td><?= htmlspecialchars($ens['specialite']) ?></td>
                                <td><?= htmlspecialchars($ens['email']) ?></td>
                                <td><?= htmlspecialchars($ens['telephone']) ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $ens['id_enseignant'] ?>"
                                       class="btn btn-warning btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $ens['id_enseignant'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cet enseignant ?')">🗑️ Supprimer</a>
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