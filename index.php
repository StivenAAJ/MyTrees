<?php
include('utils/functions.php');
require('inc/header.php');

if (!isset($_SESSION['user_name'])) {
  header('Location: login.php');
  exit;
}
?>
  
  <!-- Mensaje de bienvenida personalizado -->
  <?php if (isset($_SESSION['user_name'])): ?>
      <div class="welcome-message">
        <h2>Bienvenido(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <h2>Su rol es : <?php echo htmlspecialchars($_SESSION['user_role']); ?></h2>
      </div>
    <?php else: ?>
      <div class="welcome-message">
        <p>Bienvenido(a) a nuestra comunidad de cuidado de árboles. ¡Inicia sesión para ver más detalles!</p>
      </div>
    <?php endif; ?>
  <!-- Contenido principal -->
  <section class="index-hero">
    <div class="hero-content">
      <h1>Bienvenido a My trees</h1>
      <p>Haciendo la diferencia, Arbol por Arbol</p>
    </div>
  </section>
  <div class="main_index-container">
    
    <h1>Nuestra Misión :</h1>
      <p>Impulsar la reforestación y la restauración ambiental a través de la colaboración comunitaria y la tecnología.
        A través de nuestra plataforma web, facilitamos la recaudación de fondos y promovemos la participación de personas y empresas
        comprometidas en la plantación y el cuidado de un millón de árboles, creando un impacto positivo y sostenible en el medio ambiente.
      </p>
    <h1>Nuestra Visión :</h1>
      <p>
      Ser líderes en la conservación y reforestación a nivel global mediante una red de apoyo que fomente la educación ambiental
      y el compromiso colectivo. Aspiramos a restaurar áreas degradadas y construir un futuro donde cada comunidad tenga acceso
      a los recursos y la motivación para sembrar un millón de árboles y contribuir a un planeta más verde y saludable.
      </p>
  </div>




<?php require('inc/footer.php'); ?>
