<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Tableau de bord';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$pdo = getDBConnection();
$stats = [
    'eleve'      => $pdo->query("SELECT COUNT(*) FROM eleve")->fetchColumn(),
    'enseignant' => $pdo->query("SELECT COUNT(*) FROM enseignant")->fetchColumn(),
    'classe'     => $pdo->query("SELECT COUNT(*) FROM classe")->fetchColumn(),
    'matiere'    => $pdo->query("SELECT COUNT(*) FROM matiere")->fetchColumn(),
    'inscription'=> $pdo->query("SELECT COUNT(*) FROM inscription")->fetchColumn(),
    'affectation'=> $pdo->query("SELECT COUNT(*) FROM affectation")->fetchColumn(),
];
?>

<div class="container">
    <h1 style="margin-bottom: 20px; color: var(--primary);">Tableau de bord</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['eleve']) ?></div>
            <div class="stat-label">👨‍🎓 Élève</div>
            <a href="/pages/eleve/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['enseignant']) ?></div>
            <div class="stat-label">👨‍🏫 Enseignant</div>
            <a href="/pages/enseignant/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['classe']) ?></div>
            <div class="stat-label">🏫 Classe</div>
            <a href="/pages/classe/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['matiere']) ?></div>
            <div class="stat-label">📖 Matière</div>
            <a href="/pages/matiere/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['inscription']) ?></div>
            <div class="stat-label">📝 Inscription</div>
            <a href="/pages/inscription/index.php" class="btn btn-primary btn-sm" style="margin-top: 10px;">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= htmlspecialchars((string)$stats['affectation']) ?></div>
            <div class="stat-label">🔗 Affectation</div>
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
                        FROM inscription i
                        JOIN eleve e ON i.id_eleve = e.id_eleve
                        JOIN classe c ON i.id_classe = c.id_classe
                        ORDER BY i.date_inscription DESC
                        LIMIT 5
                    ");
                    $inscription = $stmt->fetchAll();
                    
                    if (empty($inscription)): ?>
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

<?php require_once __DIR__ . '/../includes/footer.php';; ?>