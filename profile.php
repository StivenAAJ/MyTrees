<?php
session_start();
require_once 'utils/buyTrees-funcs.php';
require_once 'utils/trees-funcs.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$trees = getTrees(); 
$userId = $_SESSION['user_id'];
$purchasedTrees = getUserPurchasedTrees($userId);
$userId = $_SESSION['user_name'];
require('inc/header.php');
?>

<?php if (isset($_SESSION['user_name'])): ?>
      <div class="welcome-message">
        <h2>Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2> 
      </div>
<?php else: ?>
      <div class="welcome-message">
        <p>para visualizar tu perfil, por favor, inicia sesion</p><!--Este mensaje no se va a mostrar por la validacion de arriba-->  
        <li><a href="/login.php">Inicia Sesión</a></li>
      </div>
<?php endif; ?>
<body>
<h1 class="titulo1">Tus Árboles Comprados:</h1>
    <div class="card-container">
        <?php foreach ($purchasedTrees as $tree): ?>
            <div class="card" data-name="<?= htmlspecialchars($tree['especie']) ?>">
                <img src="<?= htmlspecialchars($tree['foto_arbol']) ?>" alt="<?= htmlspecialchars($tree['especie']) ?>">
                <div class="card-content">
                    <h3><?= htmlspecialchars($tree['especie']) ?></h3>
                    <p>
                        Ubicación: <?= htmlspecialchars($tree['ubicacion']) ?><br>
                        Estado: <?= htmlspecialchars($tree['estado']) ?><br>
                        Precio: $<?= number_format($tree['precio'], 2) ?>
                        Tamaño: <?= htmlspecialchars($tree['tam']) ?><br>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php require('inc/footer.php'); ?>