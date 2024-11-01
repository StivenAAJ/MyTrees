<?php
  session_start();
  include('utils/functions.php');
  $users = getUsers();

  if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
    }
?>
<?php require('inc/header.php')?>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="display-4">Users</h1>
      <p class="lead">List of users</p>
      <hr class="my-4">
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Telefono</th>
          <th>Email</th>
          <th>Dirección</th>
          <th>Pais</th>
          <th>Rol</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>

      <?php if (empty($users)): ?>
        <p>No users found</p>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
            <tr scope="row">
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['direccion']; ?></td>
                <td><?php echo $user['pais']; ?></td>
                <td><?php echo $user['rol']; ?></td>
                <td>
                  <a href="/workshop5/cruds.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Mas Informacion</a>
                </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>

      </tbody>
    </table>
  </div>
<?php require('inc/footer.php');