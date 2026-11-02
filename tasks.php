<?php
require_once "auth.php";
$project_id = $_GET["project_id"] ?? $_POST["project_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO tasks (project_id, task_name, task_status, added_by) VALUES (?,?,?,?)");
    $stmt->execute([$project_id, $_POST["task_name"], $_POST["task_status"], $_SESSION["user_id"]]);
    header("Location: tasks.php?project_id=$project_id");
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch();


$stmt = $pdo->prepare("
    SELECT t.*,
           CONCAT(a.first_name,' ',a.last_name) AS added_name,
           CONCAT(u.first_name,' ',u.last_name) AS updated_name
    FROM tasks t
    JOIN users a ON a.id = t.added_by
    LEFT JOIN users u ON u.id = t.last_updated_by
    WHERE t.project_id = ?
    ORDER BY t.id DESC
");
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll();

include "nav.php";
?>

<a class="back-link" href="index.php">&larr; Back to projects</a>

<div class="card">
  <h2>➕ Add a task to: <?= htmlspecialchars($project["name"]) ?></h2>
  <form method="POST" class="inline-form">
    <input type="hidden" name="project_id" value="<?= $project_id ?>">
    <div class="field grow">
      <label>Task name</label>
      <input name="task_name" required>
    </div>
    <div class="field">
      <label>Status</label>
      <select name="task_status">
        <option>Pending</option>
        <option>In Progress</option>
        <option>Done</option>
      </select>
    </div>
    <button type="submit">Add task</button>
  </form>
</div>

<div class="card">
  <h2>✅ Tasks</h2>
  <div class="table-wrap">
    <table>
      <tr>
        <th>ID</th>
        <th>Task</th>
        <th>Status</th>
        <th>Added by</th>
        <th>Last updated by</th>
        <th>Last updated</th>
        <th>Actions</th>
      </tr>

      <?php if (!$tasks): ?>
        <tr><td colspan="7" class="empty">No tasks yet. Add one above!</td></tr>
      <?php endif; ?>

      <?php foreach ($tasks as $t): ?>
      <tr>
        <td><?= $t["id"] ?></td>
        <td><b><?= htmlspecialchars($t["task_name"]) ?></b></td>
        <td>
          <span class="badge s-<?= strtolower(str_replace(' ', '-', $t["task_status"])) ?>">
            <?= htmlspecialchars($t["task_status"]) ?>
          </span>
        </td>
        <td><?= htmlspecialchars($t["added_name"]) ?></td>
        <td><?= htmlspecialchars($t["updated_name"] ?? "-") ?></td>
        <td class="small"><?= $t["last_updated"] ?></td>
        <td>
          <a class="btn btn-sm btn-edit" href="edit_task.php?id=<?= $t["id"] ?>">Edit</a>
          <form method="POST" action="delete_task.php" class="inline"
                onsubmit="return confirm('Delete this task?');">
            <input type="hidden" name="id" value="<?= $t["id"] ?>">
            <input type="hidden" name="project_id" value="<?= $project_id ?>">
            <button type="submit" class="btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

</div>
</body>
</html>
