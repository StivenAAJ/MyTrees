<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Trees</title>
  <link rel="stylesheet" href="./css/all.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <!-- Header with custom navigation -->
  <header class="header-index">
    <div class="header-name">
      My Trees <i class="fas fa-tree"></i> 
    </div>
    <div class="navbar">
      <nav>
        <ul>
          <li><a href="/index.php">Home</a></li>
          <li><a href="/signup.php">Signup</a></li>
          <li><a href="/login.php">Login</a></li>
          <select onchange="if (this.value) window.location.href=this.value;"> 
            <option value="">Advanced</option>
            <option value="/friends.php">Friends</option>
            <option value="/trees.php">Trees</option> 
            <option value="/dashboard.php">Dashboard</option>          
          </select>
          <li><a href="/logout.php">Logout</a></li>
          <li><a href="/profile.php">My profile</a></li>
        </ul>
      </nav>
    </div>
  </header>
