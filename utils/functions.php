<?php

//Retrieve all the users from the database
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

//Retrieve a specific user by his ID
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

/**
 * Create a connection with the database
 */
function getConnection(): bool|mysqli {
    $connection = mysqli_connect('localhost', 'root', '', 'mytrees');
    print_r(mysqli_connect_error());
    return $connection;
}

/**
 * Save a user in the database
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
  $password = md5($password);
  $role = 'USER';
  //Verify if the email exists
  if (emailExist($email)) {
    die('Este correo ya está registrado.');
  } else {
   
    $sql = "INSERT INTO users (name, lastname, phone, email, direccion, pais, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ssssssss", $name, $lastName, $phone, $email, $address, $country, $password, $role);
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


/**
 * Edit a user on the database
 */
function editUser($user) {
    $conn = getConnection();
    $userId = $user['id'];
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    $province = $user['province'];
    $password = $user['password'];
    $password = !empty($password) ? md5($password) : null;
    $status = isset($user['status']) ? $user['status'] : null;
    //Verify if the email exists, except is owned by the own user
    if (emailExist($email) && !isSameUser($email, $userId)) {
        die('this email already exists');
    } else {
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, province_id = ?";
        $types = "ssss"; 
        $params = [$firstName, $lastName, $email, $province];
        if ($status) {
            $sql .= ", status = ?";
            $types .= "s"; 
            $params[] = $status;
        }

        if ($password) {
            $sql .= ", password = ?";
            $types .= "s"; 
            $params[] = $password;
        }
        $sql .= " WHERE id = ?";
        $types .= "i";
        $params[] = $userId;

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
          
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


/**
 * Delete a user from the database
 */
function deleteUser($id) {
  $conn = getConnection();
  $sql = "DELETE FROM `users` WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $id); 
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

/**
 * check if the email exists, to prevent many users from using a single email
 */
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
 *checks if the user exists in the database, if so, it allows them to log in to the system.
 *
 */
function authenticate($username, $password): bool|array|null {
  $conn = getConnection();
  $passwordHash = md5($password);
  $sql = "SELECT id, name, rol FROM users WHERE email = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
      $conn->close();
      return false;
  }
  $stmt->bind_param("ss", $username, $passwordHash);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
      $userData = $result->fetch_assoc();
      $stmt->close();
      $conn->close();
      return $userData;
  }
  $stmt->close();
  $conn->close();
  return null;
}

