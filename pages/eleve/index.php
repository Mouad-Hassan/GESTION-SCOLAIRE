<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/database.php';

$pageTitle = 'Liste des élèves';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$pdo = getDBConnection();

$message = $_SESSION['message'] ?? null;
$messageType = $_SESSION['message_type'] ?? 'success';
unset($_SESSION['message'], $_SESSION['message_type']);

$stmt = $pdo->query("
    SELECT e.*, c.nom_classe, i.annee_scolaire
    FROM eleve e
    LEFT JOIN inscription i ON e.id_eleve = i.id_eleve 
        AND i.annee_scolaire = (
            SELECT MAX(annee_scolaire) FROM inscription WHERE id_eleve = e.id_eleve
        )
    LEFT JOIN classe c ON i.id_classe = c.id_classe
    ORDER BY e.nom, e.prenom
");
$eleves = $stmt->fetchAll();
?>

<div class="container">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>👨‍🎓 Liste des élèves</span>
            <a href="create.php" class="btn btn-success">+ Ajouter un élève</a>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-<?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Classe actuelle</th>
                        <th>Année</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($eleve)): ?>
                        <tr><td colspan="7" style="text-align:center;">Aucun élève enregistré</td></tr>
                    <?php else: 
                        foreach ($eleve as $eleve): ?>
                        <tr>
                            <td><?= htmlspecialchars($eleve['matricule']) ?></td>
                            <td><?= htmlspecialchars($eleve['nom']) ?></td>
                            <td><?= htmlspecialchars($eleve['prenom']) ?></td>
                            <td><?= htmlspecialchars($eleve['date_naissance'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($eleve['nom_classe'] ?? 'Non inscrit') ?></td>
                            <td><?= htmlspecialchars($eleve['annee_scolaire'] ?? '-') ?></td>
                            <td>
                                <a href="edit.php?id=<?= (int)$eleve['id_eleve'] ?>" class="btn btn-warning btn-sm">✏️ Modifier</a>
                                <a href="delete.php?id=<?= (int)$eleve['id_eleve'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">🗑️ Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>