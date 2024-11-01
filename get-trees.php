<?php
// Incluye el archivo con la función para obtener los árboles
require_once 'utils/trees-funcs.php';
$trees = getTrees(); // Obtén todos los árboles de la base de datos
require('inc/header.php'); 
?>
<body>
    <h1 class="titulo1">Árboles en Venta</h1>
    <div class="card-container">
        <?php foreach ($trees as $tree): ?>
            <div class="card" data-name="<?= htmlspecialchars($tree['especie']) ?>">
                <img src="<?= htmlspecialchars($tree['foto_arbol']) ?>" alt="<?= htmlspecialchars($tree['especie']) ?>">
                <div class="card-content">
                    <h3><?= htmlspecialchars($tree['especie']) ?></h3>
                    <p>
                        Ubicación: <?= htmlspecialchars($tree['ubicacion']) ?><br>
                        Estado: <?= htmlspecialchars($tree['estado']) ?><br>
                        Precio: $<?= number_format($tree['precio'], 2) ?>
                    </p>
                    <a href="treeInfo.php?id=<?= $tree['id'] ?>" class="btn">Más Información</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php require('inc/footer.php'); ?>
