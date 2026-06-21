<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Tableau de bord';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$pdo = getDBConnection();

$stats = [
    'eleves'       => (int)$pdo->query("SELECT COUNT(*) FROM eleve")->fetchColumn(),
    'enseignants'  => (int)$pdo->query("SELECT COUNT(*) FROM enseignant")->fetchColumn(),
    'classes'      => (int)$pdo->query("SELECT COUNT(*) FROM classe")->fetchColumn(),
    'matieres'     => (int)$pdo->query("SELECT COUNT(*) FROM matiere")->fetchColumn(),
    'inscriptions' => (int)$pdo->query("SELECT COUNT(*) FROM inscription")->fetchColumn(),
    'affectations' => (int)$pdo->query("SELECT COUNT(*) FROM affectation")->fetchColumn(),
];

$stmt = $pdo->query("
    SELECT e.nom, e.prenom, c.nom_classe, i.date_inscription
    FROM inscription i
    JOIN eleve e ON i.id_eleve = e.id_eleve
    JOIN classe c ON i.id_classe = c.id_classe
    ORDER BY i.date_inscription DESC
    LIMIT 5
");
$inscriptions = $stmt->fetchAll();
?>

<main class="container py-4">
    <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $stats['eleves'] ?></div>
            <div class="stat-label"><i class="bi bi-people me-1"></i>Élèves</div>
            <a href="../pages/eleve/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['enseignants'] ?></div>
            <div class="stat-label"><i class="bi bi-person-workspace me-1"></i>Enseignants</div>
            <a href="../pages/enseignant/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['classes'] ?></div>
            <div class="stat-label"><i class="bi bi-building me-1"></i>Classes</div>
            <a href="../pages/classe/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['matieres'] ?></div>
            <div class="stat-label"><i class="bi bi-book me-1"></i>Matières</div>
            <a href="../pages/matiere/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['inscriptions'] ?></div>
            <div class="stat-label"><i class="bi bi-journal-check me-1"></i>Inscriptions</div>
            <a href="../pages/inscription/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['affectations'] ?></div>
            <div class="stat-label"><i class="bi bi-link-45deg me-1"></i>Affectations</div>
            <a href="../pages/affectation/index.php" class="btn btn-primary btn-sm mt-2">Gérer</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
