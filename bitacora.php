<?php
require_once 'utils/functions.php';
require_once 'utils/trees-funcs.php';

// User and species verification
session_start();
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
}
// Call to the getTrees function in functions for trees.
$trees = getTrees();

require('inc/header.php'); 
?>
<h1>Registrar Actualización de Árbol</h1>
    
<form action="utils/bita-funcs.php" method="POST" id="bitacora-form">
        <label for="tree-id">Árbol:</label>
        <select id="tree-id" name="tree_id" required>
            <option value="">Seleccione un árbol</option>
            <?php foreach ($trees as $tree): ?>
                <option value="<?= $tree['id'] ?>">
                    <?= "ID: {$tree['id']} - Especie: {$tree['especie']}" ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="tam">Tamaño Actual:</label>
        <input type="text" id="tam" name="tam" required>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="DISPONIBLE">DISPONIBLE</option>
            <option value="VENDIDO">VENDIDO</option>
        </select>

        <button type="submit" name="update_bitacora">Registrar Actualización</button>
    </form>



<?php require('inc/footer.php'); ?>