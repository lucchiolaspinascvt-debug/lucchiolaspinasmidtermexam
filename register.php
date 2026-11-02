<?php
require_once "config.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$_POST["username"]]);

    if ($check->fetch()) {
        $error = "Username already taken.";
    } elseif ($_POST["password"] != $_POST["confirm"]) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, address, age, username, password) VALUES (?,?,?,?,?,?)");
        $stmt->execute([
            $_POST["first_name"],
            $_POST["last_name"],
            $_POST["address"],
            $_POST["age"],
            $_POST["username"],
            password_hash($_POST["password"], PASSWORD_DEFAULT)
        ]);
        header("Location: login.php?registered=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

<div class="auth-box">
  <h1>📝 Create Account</h1>
  <p class="subtitle">Fill in your details to get started</p>

  <?php if ($error): ?>
    <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row2">
      <div class="field">
        <label>First name</label>
        <input name="first_name" required>
      </div>
      <div class="field">
        <label>Last name</label>
        <input name="last_name" required>
      </div>
    </div>
    <div class="field">
      <label>Address</label>
      <input name="address" required>
    </div>
    <div class="field">
      <label>Age</label>
      <input type="number" name="age" required>
    </div>
    <div class="field">
      <label>Username</label>
      <input name="username" required>
    </div>
    <div class="row2">
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="field">
        <label>Confirm password</label>
        <input type="password" name="confirm" required>
      </div>
    </div>
    <button type="submit">Register</button>
  </form>

  <p class="switch">Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>