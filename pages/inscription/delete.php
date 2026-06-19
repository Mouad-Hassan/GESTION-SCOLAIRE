<?php
declare(strict_types=1);


require_once dirname(__DIR__, 2) . '/bootstrap.php';

$pdo = getDBConnection();
$id  = (int)($_GET['id'] ?? 0);

if ($id === 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT id_inscription FROM inscription WHERE id_inscription = :id");
$stmt->execute([':id' => $id]);
if (!$stmt->fetch()) { header('Location: index.php'); exit; }

$pdo->prepare("DELETE FROM inscription WHERE id_inscription = :id")->execute([':id' => $id]);

header('Location: index.php?succes=supprime');
exit;