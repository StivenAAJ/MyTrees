<?php

function getUsers(): array {
    $conn = getConnection();
    $users = [];
  
    if ($conn) {
        $query = "SELECT id, name, lastname, phone, email, direccion, pais, password, rol FROM users";
        $result = mysqli_query($conn, $query);
  
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        }
  
        mysqli_close($conn);
    }
  
    return $users;
}

function getUserById($Id) {
  $conn = getConnection();
  if ($conn) {
      $sql = "SELECT name, lastname, phone, email, direccion, pais, password, rol FROM users WHERE id = '$Id'";
      $result = mysqli_query($conn, $sql);
      $user = []; 

      if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
              $user = $row;
          }
      } else {
          error_log("SQL Error: " . mysqli_error($conn)); 
      }

      mysqli_close($conn); 
      return $user; 
  } else {
      return [];
  }
}


function getConnection(): bool|mysqli {
    $connection = mysqli_connect('localhost', 'root', '', 'mytrees');
    print_r(mysqli_connect_error());
    return $connection;
}

/**
 * Saves an specific user into the database
 */
function saveUser($user) {
  $conn = getConnection();
  $name = $user['name'];
  $lastName = $user['lastName'];
  $phone = $user['phone'];
  $email = $user['email'];
  $address = $user['address'];
  $country = $user['country'];
  $password = $user['password'];
  $password = md5($password); // Encriptación de la contraseña
  $role = 'USER'; // Rol predeterminado

  // Verificar si el correo electrónico ya existe
  if (emailExist($email)) {
    die('Este correo ya está registrado.');
  } else {
    // Consulta SQL corregida (añadir todos los campos)
    $sql = "INSERT INTO users (name, lastname, phone, email, direccion, pais, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
      // Vincular los parámetros (incluir el rol en el bind_param)
      mysqli_stmt_bind_param($stmt, "ssssssss", $name, $lastName, $phone, $email, $address, $country, $password, $role);

      // Ejecutar la consulta
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return true;
      } else {
        die("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
      }
    } else {
      die("Error al preparar la consulta: " . mysqli_error($conn));
    }
  }
}



function editUser($user) {
    $conn = getConnection();
    $userId = $user['id'];
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    $province = $user['province'];
    $password = $user['password'];
    
    // Encriptar la contraseña si está presente
    $password = !empty($password) ? md5($password) : null;

    // Aceptar el status proporcionado, si no está presente, mantener el actual
    $status = isset($user['status']) ? $user['status'] : null;

    // Comprobar si el correo electrónico ya existe, excepto si pertenece al mismo usuario
    if (emailExist($email) && !isSameUser($email, $userId)) {
        die('this email already exists');
    } else {
        // Construir la consulta SQL de forma dinámica
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, province_id = ?";
        
        $types = "ssss"; // Tipos para los 4 primeros parámetros

        $params = [$firstName, $lastName, $email, $province];

        // Agregar status si está presente
        if ($status) {
            $sql .= ", status = ?";
            $types .= "s"; // Agregar tipo para status
            $params[] = $status;
        }

        // Agregar password si está presente
        if ($password) {
            $sql .= ", password = ?";
            $types .= "s"; // Agregar tipo para password
            $params[] = $password;
        }
        
        // Añadir el WHERE para el id del usuario
        $sql .= " WHERE id = ?";
        $types .= "i"; // Agregar tipo para el id
        $params[] = $userId;

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Vincular los parámetros en un solo bind_param
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            
            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return true;
            } else {
                die("Error executing query: " . mysqli_stmt_error($stmt));
            }
        }
    }
    mysqli_close($conn);
    return false;
}



function deleteUser($id) {
  $conn = getConnection();

  // Prepare the SQL statement with a placeholder
  $sql = "DELETE FROM `users` WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  
  // Bind parameters (i for integer)
  mysqli_stmt_bind_param($stmt, 'i', $id); 

  // Execute the statement
  if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt); 
      mysqli_close($conn); 
      return true;
  } else {
      die("Error executing query: " . mysqli_stmt_error($stmt));
      mysqli_stmt_close($stmt);
      return false; 
  }
}


function emailExist($email) {
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE `email` = '$email'";
  $result = $conn->query($sql);

  if ($conn->connect_errno) {
    $conn->close();
    return false;
  }
  $results = $result->fetch_array();
  $conn->close();
  return $results;
}

/**
 * Get one specific student from the database
 *
 * @id Id of the student
 */
function authenticate($username, $password): bool|array|null {
  $conn = getConnection();
  $password = md5($password);

  // Corregido: comillas simples eliminadas alrededor de 'status'
  $sql = "SELECT * FROM users WHERE `email` = '$username' AND `password` = '$password' AND `rol` = 'USER'";
  $result = $conn->query($sql);

  // Verificamos si hay un error de conexión
  if ($conn->connect_errno) {
      $conn->close();
      return false;
  }

  // Verificamos si hay resultados
  if ($result && $result->num_rows > 0) {
      $userData = $result->fetch_array();
      $conn->close();
      return $userData; // Devuelve los datos del usuario
  }

  $conn->close();
  return null; // Devuelve null si no hay coincidencias
}