<?php
require_once "auth.php";
$id = $_GET["id"] ?? $_POST["id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE projects SET name=?, status=?, last_updated_by=?, last_updated=NOW() WHERE id=?");
    $stmt->execute([$_POST["name"], $_POST["status"], $_SESSION["user_id"], $id]);
    header("Location: index.php");
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

include "nav.php";
?>

<a class="back-link" href="index.php">&larr; Back to projects</a>

<div class="card">
  <h2>✏️ Edit project</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= $project["id"] ?>">

    <div class="field">
      <label>Project name</label>
      <input name="name" value="<?= htmlspecialchars($project["name"]) ?>" required>
    </div>

    <div class="field">
      <label>Status</label>
      <select name="status">
        <?php foreach (["Ongoing","Completed","On Hold"] as $s): ?>
          <option <?= $project["status"] == $s ? "selected" : "" ?>><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit">Save changes</button>
    <a class="btn btn-gray" href="index.php">Cancel</a>
  </form>
</div>

</div>
</body>
</html>