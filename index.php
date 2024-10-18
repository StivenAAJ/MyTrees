<?php
  include('utils/functions.php');

?>
<?php require('inc/header.php') ?>
  <div class="main-container">
    <div class="signup-banner">
      <h1 class="signup-title">Login</h1>
      <p class="signup-description">Welcome Back</p>
      <hr class="signup-divider">
    </div>
    <form method="post" action="./actions/signup.php">
      <div class="error">
        <?php echo $error_msg; ?>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" class="form-control" type="text" name="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" class="form-control" type="password" name="password">
      </div>
      <button type="submit" class="btn-primary"> Sign up </button>
    </form>
  </div>
<?php require('inc/footer.php') ?>