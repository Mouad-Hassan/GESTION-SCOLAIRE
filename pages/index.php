<?php

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

$pageTitle = 'Tableau de bord';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$pdo = getDBConnection();
$stats = [
    'eleves'      => $pdo->query("SELECT COUNT(*) FROM eleves")->fetchColumn(),
    'enseignants' => $pdo->query("SELECT COUNT(*) FROM enseignants")->fetchColumn(),
    'classes'     => $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn(),
    'matieres'    => $pdo->query("SELECT COUNT(*) FROM matieres")->fetchColumn(),
    'inscriptions'=> $pdo->query("SELECT COUNT(*) FROM inscriptions")->fetchColumn(),
    'affectations'=> $pdo->query("SELECT COUNT(*) FROM affectations")->fetchColumn(),
];
?>

<div class="container">
    <h1 style="margin-bottom: 20px; color: var(--primary);">Tableau de bord</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['eleves']) ?></div>
            <div class="stat-label">👨‍🎓 Élèves</div>
            <a href="/pages/eleves/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['enseignants']) ?></div>
            <div class="stat-label">👨‍🏫 Enseignants</div>
            <a href="/pages/enseignants/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['classes']) ?></div>
            <div class="stat-label">🏫 Classes</div>
            <a href="/pages/classes/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['matieres']) ?></div>
            <div class="stat-label">📖 Matières</div>
            <a href="/pages/matieres/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['inscriptions']) ?></div>
            <div class="stat-label">📝 Inscriptions</div>
            <a href="/pages/inscriptions/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['affectations']) ?></div>
            <div class="stat-label">🔗 Affectations</div>
            <a href="/pages/affectation/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">📋 Dernières inscriptions</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("
                        SELECT e.nom, e.prenom, c.nom_classe, i.annee_scolaire, i.date_inscription
                        FROM inscriptions i
                        JOIN eleves e ON i.id_eleve = e.id_eleve
                        JOIN classes c ON i.id_classe = c.id_classe
                        ORDER BY i.date_inscription DESC
                        LIMIT 5
                    ");
                    $inscriptions = $stmt->fetchAll();
                    
                    if (empty($inscriptions)): ?>
                        <tr><td colspan="4" style="text-align:center;">Aucune inscription enregistrée</td></tr>
                    <?php else:
                        foreach ($inscriptions as $insc): ?>
                        <tr>
                            <td><?= htmlspecialchars($insc['nom'] . ' ' . $insc['prenom']) ?></td>
                            <td><?= htmlspecialchars($insc['nom_classe']) ?></td>
                            <td><?= htmlspecialchars($insc['annee_scolaire']) ?></td>
                            <td><?= htmlspecialchars($insc['date_inscription']) ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>