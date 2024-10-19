<?php
  include('utils/functions.php');
  $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php require('inc/header.php')?>
  <div class="container">
    <div class="hero">
      <h1 class="title">Login</h1>
      <p class="subtitle">Welcome Back !</p>
      <hr class="divider">
    </div>
    <form method="post" action="./actions/login.php" class="form">
      <div class="form__error">
        <?php echo $error_msg; ?>
      </div>
      <div class="form__group">
        <label for="email" class="form__label">Email Address</label>
        <input id="email" class="form__input" type="text" name="username">
      </div>
      <div class="form__group">
        <label for="password" class="form__label">Password</label>
        <input id="password" class="form__input" type="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
<?php require('inc/footer.php')?>
