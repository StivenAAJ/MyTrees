<?php
require_once 'utils/functions.php';
require_once 'utils/trees-funcs.php';
require_once 'utils/especies-funcs.php';

// Verificación de usuario y especies
session_start();
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
}

// Verificar si existen especies antes de mostrar el formulario
if (!verifySpeciesExist()) {
    echo "<p>No existen especies en el sistema. <a href='especies.php'>Crear especies</a> o <a href='trees.php'>Volver al CRUD de árboles</a>.</p>";
    exit();
}

// Obtener la lista de especies
$especies = getEspecies();
$trees = getTrees();
require('inc/header.php'); 

// Verificar si estamos en modo edición
$treeToEdit = null;
$isEditing = isset($_GET['id']);

if ($isEditing) {
    $treeId = $_GET['id'];
    $treeToEdit = getTreeById($treeId);
    if (!$treeToEdit) {
        echo "<p>Error: Árbol no encontrado. <a href='trees.php'>Volver al CRUD de árboles</a>.</p>";
        exit;
    }
}
?>

<body>
    <h1>Administrar Árboles</h1>
    
    <section class="tree-form">
        <form action="actions/<?php echo $isEditing ? 'tree_edit.php?id=' . $treeId : 'tree_create.php'; ?>" 
              method="POST" enctype="multipart/form-data">
            
            <h2><?php echo $isEditing ? 'Editar Árbol' : 'Crear Árbol'; ?></h2>

            <label for="especie">Especie:</label>
            <select name="especie" id="especie" required>
                <?php foreach ($especies as $especie): ?>
                    <option value="<?php echo htmlspecialchars($especie['idEspecie']); ?>"
                        <?php echo $isEditing && $especie['idEspecie'] == $treeToEdit['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($especie['nombreComercial']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="ubicacion">Ubicación Geográfica:</label>
            <input type="text" id="ubicacion" name="ubicacion" value="<?php echo $isEditing ? htmlspecialchars($treeToEdit['ubicacion']) : ''; ?>" required>
            
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="<?php echo $isEditing ? htmlspecialchars($treeToEdit['estado']) : ''; ?>" required>
            
            <label for="precio">Precio:</label>
            <input type="text" id="precio" name="precio" value="<?php echo $isEditing ? htmlspecialchars($treeToEdit['precio']) : ''; ?>" required>
            
            <label for="foto">Foto del Árbol:</label>
            <input type="file" id="foto" name="foto" <?php echo $isEditing ? '' : 'required'; ?>>
            
            <?php if ($isEditing && $treeToEdit['foto_arbol']): ?>
                <p>Foto actual: <img src="<?php echo htmlspecialchars($treeToEdit['foto_arbol']); ?>" alt="Foto del árbol" width="100"></p>
            <?php endif; ?>
            
            <button type="submit"><?php echo $isEditing ? 'Guardar Cambios' : 'Crear Árbol'; ?></button>
        </form>
    </section>
    
    <section class="tree-list">
        <h2>Lista de Árboles en Venta</h2>
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
                    <a href="trees.php?id=<?php echo $tree['id']; ?>">Editar</a> |
                    <a href="actions/tree_delete.php?id=<?php echo $tree['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este árbol?');">Eliminar</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </section>
<?php require('inc/footer.php'); ?>


