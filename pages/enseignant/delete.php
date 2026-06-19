<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pdo = getDBConnection();
$id  = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT id_enseignant FROM enseignant WHERE id_enseignant = :id");
$stmt->execute([':id' => $id]);
if (!$stmt->fetch()) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("DELETE FROM affectation WHERE id_enseignant = :id");
$stmt->execute([':id' => $id]);

$stmt = $pdo->prepare("DELETE FROM enseignant WHERE id_enseignant = :id");
$stmt->execute([':id' => $id]);

header('Location: index.php?succes=supprime');
exit;