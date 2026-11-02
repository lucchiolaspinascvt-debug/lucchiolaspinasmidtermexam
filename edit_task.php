<?php
require_once "auth.php";
$id = $_GET["id"] ?? $_POST["id"];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE tasks SET task_name=?, task_status=?, last_updated_by=?, last_updated=NOW() WHERE id=?");
    $stmt->execute([$_POST["task_name"], $_POST["task_status"], $_SESSION["user_id"], $id]);
    header("Location: tasks.php?project_id=" . $task["project_id"]);
    exit;
}

include "nav.php";
?>

<a class="back-link" href="tasks.php?project_id=<?= $task["project_id"] ?>">&larr; Back to tasks</a>

<div class="card">
  <h2>✏️ Edit task</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= $task["id"] ?>">

    <div class="field">
      <label>Task name</label>
      <input name="task_name" value="<?= htmlspecialchars($task["task_name"]) ?>" required>
    </div>

    <div class="field">
      <label>Status</label>
      <select name="task_status">
        <?php foreach (["Pending","In Progress","Done"] as $s): ?>
          <option <?= $task["task_status"] == $s ? "selected" : "" ?>><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit">Save changes</button>
    <a class="btn btn-gray" href="tasks.php?project_id=<?= $task["project_id"] ?>">Cancel</a>
  </form>
</div>

</div>
</body>
</html>