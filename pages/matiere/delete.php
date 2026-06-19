<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pdo = getDBConnection();
$id  = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT id_matiere FROM matiere WHERE id_matiere = :id");
$stmt->execute([':id' => $id]);
if (!$stmt->fetch()) { header('Location: index.php'); exit; }

// Supprimer les affectations liées (FK)
$pdo->prepare("DELETE FROM affectation WHERE id_matiere = :id")->execute([':id' => $id]);

// Supprimer la matière
$pdo->prepare("DELETE FROM matiere WHERE id_matiere = :id")->execute([':id' => $id]);

header('Location: index.php?succes=supprime');
exit;