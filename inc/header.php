<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Trees</title>
  <link rel="stylesheet" href="css/all.css">
</head>

<body>
  <!-- Header with custom navigation -->
  <header class="header-index">
    <div class="header-name">My Trees</div>
    <div class="navbar">
      <nav>
        <ul>
        <li><a href="/mytrees/signup.php">Signup</a></li>
        <li><a href="/mytrees/login.php">Login</a></li>
        <li><a href="/mytrees/logout.php">Logout</a></li>
        <li><a href="/mytrees/users.php">Users</a></li>
        </ul>
      </nav>
      <div class="language-switch">
        <select>
          <option value="en">English</option>
          <option value="es">Español</option>
        </select>
      </div>
      <div class="theme-switch">
        <label class="switch">
            <input type="checkbox" id="input">
            <span class="slider"></span>
        </label>
      </div>
    </div>
  </header>
