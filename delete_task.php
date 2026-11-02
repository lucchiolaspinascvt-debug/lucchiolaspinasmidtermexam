<?php
require_once "auth.php";

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$_POST["id"]]);

header("Location: tasks.php?project_id=" . $_POST["project_id"]);
exit;