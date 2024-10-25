<?php
include('utils/functions.php');
require('inc/header.php');
?>

<div class="main_index-container">
  <!-- Mensaje de bienvenida personalizado -->
  <?php if (isset($_SESSION['user_name'])): ?>
    <div class="welcome-message">
      <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
      <p>Tu rol es: <?php echo htmlspecialchars($_SESSION['user_role']); ?>.</p>
    </div>
  <?php else: ?>
    <div class="welcome-message">
      <p>Bienvenido a nuestra comunidad de cuidado de árboles. ¡Inicia sesión para ver más detalles!</p>
    </div>
  <?php endif; ?>

  <!-- Contenido principal -->
  <section class="index-hero">
    <div class="hero-content">
      <h1>Welcome to My trees</h1>
      <p>Making the difference, tree by tree</p>
    </div>
  </section>
  <div class="card-container">
    <div class="card">
      <img src="images/SauceLloron.jpeg" alt="Sauce Lloron">
      <div class="card-content">
        <h3>Sauce llorón</h3>
        <p>
          El sauce llorón (Salix babylonica) es un árbol que pertenece
          a la familia de las salicáceas y es nativo del este de Asia (especialmente del norte de China).
        </p>
        <a href="arboles.php#SauceL" class="btn">Más Información</a>
      </div>
    </div>
  </div>
</div>

<?php require('inc/footer.php'); ?>
