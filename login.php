<?php
require_once "config.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST["username"]]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["full_name"] = $user["first_name"] . " " . $user["last_name"];
        header("Location: index.php");
        exit;
    }
    $error = "Wrong username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

<div class="auth-box">
  <h1>🔐 Welcome Back</h1>
  <p class="subtitle">Log in to your Project Tracker</p>

  <?php if (isset($_GET["registered"])): ?>
    <div class="msg msg-success">Registered! Please login.</div>
  <?php endif; ?>
  <?php if (isset($_GET["loggedout"])): ?>
    <div class="msg msg-success">You have been logged out.</div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="field">
      <label>Username</label>
      <input name="username" required>
    </div>
    <div class="field">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit">Login</button>
  </form>

  <p class="switch">No account yet? <a href="register.php">Register</a></p>
</div>

</body>
</html>