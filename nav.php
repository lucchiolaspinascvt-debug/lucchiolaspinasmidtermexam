<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Project Tracker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <a class="brand" href="index.php">📋 Project Tracker</a>
  <div class="nav-right">
    <span class="user-chip">👤 <?= htmlspecialchars($_SESSION["full_name"]) ?></span>
    <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
  </div>
</nav>

<div class="container">