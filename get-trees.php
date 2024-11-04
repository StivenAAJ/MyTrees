<?php
// Incluye el archivo con la función para obtener los árboles
require_once 'utils/trees-funcs.php';
$trees = getTrees(); // Obtén todos los árboles de la base de datos
require('inc/header.php'); 

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
  }
?>
<body>
    <h1 class="titulo1">Árboles en Venta</h1>
    <div class="card-container">
        <?php foreach ($trees as $tree): ?>
            <?php if ($tree['estado'] === 'DISPONIBLE'): ?>
                <div class="card" data-name="<?= htmlspecialchars($tree['especie']) ?>">
                    <img src="<?= htmlspecialchars($tree['foto_arbol']) ?>" alt="<?= htmlspecialchars($tree['especie']) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($tree['especie']) ?></h3>
                        <p>
                            Ubicación: <?= htmlspecialchars($tree['ubicacion']) ?><br>
                            Estado: <?= htmlspecialchars($tree['estado']) ?><br>
                            Precio: ₡<?= number_format($tree['precio'], 2) ?>
                            Tamaño: <?= htmlspecialchars($tree['tam']) ?><br>
                        </p>
                        <a href="buy-tree.php?id=<?= $tree['id'] ?>" class="btn">Comprar</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php require('inc/footer.php'); ?>

