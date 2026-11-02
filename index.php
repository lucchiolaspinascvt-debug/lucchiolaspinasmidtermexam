<?php
require_once "auth.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO projects (name, status, added_by) VALUES (?,?,?)");
    $stmt->execute([$_POST["name"], $_POST["status"], $_SESSION["user_id"]]);
    header("Location: index.php");
    exit;
}


$projects = $pdo->query("
    SELECT p.*,
           CONCAT(a.first_name,' ',a.last_name) AS added_name,
           CONCAT(u.first_name,' ',u.last_name) AS updated_name
    FROM projects p
    JOIN users a ON a.id = p.added_by
    LEFT JOIN users u ON u.id = p.last_updated_by
    ORDER BY p.id DESC
")->fetchAll();

include "nav.php";
?>

<div class="card">
  <h2>➕ Add a project</h2>
  <form method="POST" class="inline-form">
    <div class="field grow">
      <label>Project name</label>
      <input name="name" required>
    </div>
    <div class="field">
      <label>Status</label>
      <select name="status">
        <option>Ongoing</option>
        <option>Completed</option>
        <option>On Hold</option>
      </select>
    </div>
    <button type="submit">Add project</button>
  </form>
</div>

<div class="card">
  <h2>📁 All projects</h2>
  <div class="table-wrap">
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Added by</th>
        <th>Last updated by</th>
        <th>Last updated</th>
        <th>Actions</th>
      </tr>

      <?php if (!$projects): ?>
        <tr><td colspan="7" class="empty">No projects yet. Add your first one above!</td></tr>
      <?php endif; ?>

      <?php foreach ($projects as $p): ?>
      <tr>
        <td><?= $p["id"] ?></td>
        <td><b><?= htmlspecialchars($p["name"]) ?></b></td>
        <td>
          <span class="badge s-<?= strtolower(str_replace(' ', '-', $p["status"])) ?>">
            <?= htmlspecialchars($p["status"]) ?>
          </span>
        </td>
        <td><?= htmlspecialchars($p["added_name"]) ?></td>
        <td><?= htmlspecialchars($p["updated_name"] ?? "-") ?></td>
        <td class="small"><?= $p["last_updated"] ?></td>
        <td>
          <a class="btn btn-sm" href="tasks.php?project_id=<?= $p["id"] ?>">Tasks</a>
          <a class="btn btn-sm btn-edit" href="edit_project.php?id=<?= $p["id"] ?>">Edit</a>
          <form method="POST" action="delete_project.php" class="inline"
                onsubmit="return confirm('Delete this project?');">
            <input type="hidden" name="id" value="<?= $p["id"] ?>">
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