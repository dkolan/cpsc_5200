<?php

include 'phpass-0.5/PasswordHash.php';

function createConnection() {
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

function createUser($email, $username, $password, $date) {
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
}

function authUser($username, $password) {
    $conn = createConnection();

    // Prepare the SQL query with placeholders
    // $sql = "SELECT * FROM st_users WHERE username = ? AND password = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $usernamePost);

    $sql = "SELECT password FROM st_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $stmt->bind_result($storedHash);
    $stmt->fetch();

    // Check password
    $hasher = new PasswordHash(8, FALSE);
    $validPassword = $hasher->CheckPassword($password, $storedHash);

    if ($validPassword) {
        // echo $username . "logged in.";
    } else {
        // Failed login, redirect to login.php
        header('Location: login.php');
    }

    // Close myslqi objs
    $stmt->close();
    $conn->close();
}
?>
