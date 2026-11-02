<?php
require_once "auth.php";

$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$_POST["id"]]);

header("Location: index.php");
exit;