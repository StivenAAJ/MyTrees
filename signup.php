<?php
include('utils/functions.php');

$error_msg = ''; // Inicializar la variable de error

require('inc/header.php');
?>
<div class="main-container">
    <div class="signup-banner">
        <h1 class="signup-title">Signup</h1>
        <p class="signup-description">This is the signup process</p>
        <hr class="signup-divider">
    </div>
    <form method="post" action="./actions/signup.php">
        <div class="error">
            <?php echo $error_msg; ?>
        </div>
        <div class="form-group">
            <label for="name">First Name</label>
            <input id="name" class="form-control" type="text" name="name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input id="last-name" class="form-control" type="text" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input id="phone" class="form-control" type="text" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input id="address" class="form-control" type="text" name="address" required>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input id="country" class="form-control" type="text" name="country" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-control" type="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Sign up</button>
    </form>
</div>
<?php require('inc/footer.php'); ?>
