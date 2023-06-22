<?php
include 'phpass-0.5/PasswordHash.php';

function createConnection()
{
    $servername = "sysmysql8.auburn.edu";
    $username = "dzk0077";
    $password = "Petty2-Gallon-Audibly";
    $db = "dzk0077db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function createUser($email, $username, $password, $date)
{
    if(userExists($email, $username) > 0)
    {
        return false;
    }

    $conn = createConnection();

    // Prepare sql statement
    $sql = "INSERT INTO st_users (email, username, password, date_created)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Hash the password
    $hasher = new PasswordHash(8, FALSE);
    $hashedPass = $hasher->HashPassword($password);

    $stmt->bind_param("ssss", $email, $username, $hashedPass, $date);

    // Execute the statement
    if ($stmt->execute()) {
        // Modal for user created?
    } else {
        // Modal for error? $stmt->error;
    }

    // Close myslqi objs
    $stmt->close();
    $conn->close();
    return true;
}

function authUser($username, $password)
{
    $conn = createConnection();

    // Prepare the SQL query with placeholders
    // $sql = "SELECT * FROM st_users WHERE username = ? AND password = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $usernamePost);

    $sql = "SELECT id, password FROM st_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $stmt->bind_result($id, $storedHash);
    $stmt->fetch();

    // Check password
    $hasher = new PasswordHash(8, FALSE);
    $validPassword = $hasher->CheckPassword($password, $storedHash);

    if ($validPassword) {
        setcookie('user_id', $id, time() + 3600, '/');
        // echo $username . "logged in.";
    } else {
        // Failed login, redirect to login.php
        header('Location: login.php');
    }

    // Close myslqi objs
    $stmt->close();
    $conn->close();
}

function userExists($emailPost, $usernamePost)
{
    $conn = createConnection();
    $sql = "SELECT COUNT(*) FROM st_users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $emailPost, $usernamePost);

    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $stmt->close();
    $conn->close();
    return $count;
}
?>