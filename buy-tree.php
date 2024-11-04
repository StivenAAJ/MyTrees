<?php
session_start();
require_once 'utils/buyTrees-funcs.php';
require_once 'utils/trees-funcs.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$treeId = $_GET['id'] ?? null;

if ($treeId) {
    $tree = getTreeById($treeId);
    if (!$tree) {
        echo "Este árbol no está disponible para la compra.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($treeId && createPurchaseRequest($userId, $treeId)) {
        echo "Solicitud de compra enviada exitosamente. Espera la confirmación.";
        header("Location: /get-trees.php");
        exit();
    } else {
        echo "Hubo un error al procesar tu solicitud.";
    }
}



require('inc/header.php');
?>

<body>
    <h1>Confirmar Compra de Árbol</h1>
    <form action="buy-tree.php?id=<?= htmlspecialchars($treeId) ?>" method="POST" class="purchase-form">
        <h3>¿Deseas comprar el árbol: <?= htmlspecialchars($tree['especie']) ?>?</h3>
        <img src="<?= htmlspecialchars($tree['foto_arbol']) ?>">
        <p>Nombre científico: <?= htmlspecialchars($tree['nombre_cientifico']) ?></p>
        <p>Ubicación: <?= htmlspecialchars($tree['ubicacion']) ?></p>
        <p>Precio: ₡<?= number_format($tree['precio'], 2) ?></p>
        <p>Tamaño: <?= htmlspecialchars($tree['tam']) ?></p>
        <button type="submit" class="btn">Confirmar Compra</button>
        <a href="/get-trees.php" class="btn btn-cancel">Cancelar</a>
    </form>
<?php require('inc/footer.php'); ?>
</body>
