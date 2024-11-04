<?php
session_start();
include('utils/buyTrees-funcs.php');
//include('utils/functions.php'); 
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
}

// Obtain user ID
$userId = $_GET['id'] ?? null;

if (!$userId) {
    die("ID de usuario no proporcionado.");
}

$user = getUserById($userId);
$purchasedTrees = getUserPurchasedTrees($userId);

require('inc/header.php');
?>

<div class="container friend-tree">
    <h1 class="display-4">Árboles comprados por <?= htmlspecialchars($user['name'] . ' ' . $user['lastname']); ?></h1>
    <hr class="my-4">

    <?php if (empty($purchasedTrees)): ?>
        <p>No se han encontrado árboles para este usuario.</p>
    <?php else: ?>
        <div class="tree-cards">
            <?php foreach ($purchasedTrees as $tree): ?>
                <div class="card" data-name="<?= htmlspecialchars($tree['especie']) ?>">
                    <img src="<?= htmlspecialchars($tree['foto_arbol']) ?>" alt="<?= htmlspecialchars($tree['especie']) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($tree['especie']) ?></h3>
                        <p>
                            Ubicación: <?= htmlspecialchars($tree['ubicacion']) ?><br>
                            Estado: <?= htmlspecialchars($tree['estado']) ?><br>
                            Tamaño: <?= htmlspecialchars($tree['tam']) ?><br>
                            Precio: ₡<?= number_format($tree['precio'], 2) ?>
                        </p>
            <!--Pasar al CRUD de arboles el ID del arbol y el ID del usuario-->
                        <a href="trees.php?id=<?php echo $tree['id']; ?>&user_id=<?php echo $userId; ?>">Editar Arbol</a>
                        <a href="bitacora.php?id=<?= $tree['id'] ?>" class="btn">Editar Registro</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require('inc/footer.php'); ?>
