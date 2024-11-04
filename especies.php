<?php
session_start();
require_once 'utils/functions.php';
require_once 'utils/especies-funcs.php';

// Verificar si el usuario es admin
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
}

$especieToEdit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'crear') {
        $nombreCo = $_POST['nombreCo'];
        $nombreCi = $_POST['nombreCi'];

        if (especieExists($nombreCo, $nombreCi)) {
            echo "<script>alert('La especie ya existe en la base de datos.');</script>";
        } else {
            createEspecie($nombreCo, $nombreCi);
            header("Location: especies.php");
            exit();
        }
    } elseif ($accion === 'editar') {
        $id = $_POST['id'];
        $especieToEdit = getEspecieById($id);
    } elseif ($accion === 'guardarEdicion') {
        $id = $_POST['id'];
        $nombreCo = $_POST['nombreCo'];
        $nombreCi = $_POST['nombreCi'];
        updateEspecie($id, $nombreCo, $nombreCi);
        header("Location: especies.php");
        exit();
    } elseif ($accion === 'eliminar') {
        $id = $_POST['id'];
        deleteEspecie($id);
        header("Location: especies.php");
        exit();
    }
     // Redirigir después de crear o eliminar para evitar reenvío de formulario
    if ($accion !== 'editar') {
        header("Location: especies.php");
        exit();
    }
}

// Obtener todas las especies
$especies = getEspecies();
require('inc/header.php'); 
?>

<body>
    <h1>Administración de Especies</h1>
    <!-- Formulario para crear o editar especies -->
    <form method="POST" action="especies.php">
        <input type="hidden" name="id" value="<?= $especieToEdit['idEspecie'] ?? '' ?>">
        <label>Nombre comercial de la especie:</label>
        <input type="text" name="nombreCo" value="<?= $especieToEdit['nombreComercial'] ?? '' ?>" required>
        <label>Nombre científico de la especie:</label>
        <input type="text" name="nombreCi" value="<?= $especieToEdit['nombreCientifico'] ?? '' ?>" required>
        
        <?php if ($especieToEdit): ?>
            <button type="submit" name="accion" value="guardarEdicion">Guardar Cambios</button>
        <?php else: ?>
            <button type="submit" name="accion" value="crear">Agregar Especie</button>
        <?php endif; ?>
    </form>

    <!-- Tabla de especies -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Comercial</th>
                <th>Nombre Científico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($especies as $especie): ?>
                <tr>
                    <td><?= $especie['idEspecie'] ?></td>
                    <td><?= $especie['nombreComercial'] ?></td>
                    <td><?= $especie['nombreCientifico'] ?></td>
                    <td>
                        <form method="POST" action="especies.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $especie['idEspecie'] ?>">
                            <button type="submit" name="accion" value="editar">Editar</button>
                        </form>
                        <form method="POST" action="especies.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $especie['idEspecie'] ?>">
                            <button type="submit" name="accion" value="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php require('inc/footer.php'); ?>
</body>

