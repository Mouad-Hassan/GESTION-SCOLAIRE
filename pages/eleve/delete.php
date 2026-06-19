<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

$pdo = getDBConnection();

$id = (int)($_GET['id'] ?? 0);

if ($id === 0) {
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare("SELECT id_eleve FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM inscription WHERE id_eleve = :id");
$stmt->execute([':id' => $id]);

$stmt = $pdo->prepare("DELETE FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => $id]);

header('Location: index.php?succes=supprime');
exit;