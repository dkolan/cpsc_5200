<?php
// Includes
include 'sql_lib.php';

// SQL
$conn = createConnection();

// POST params from login.php
$usernamePost = $_POST["username"];
$passwordPost = $_POST["password"];

// Prepare the SQL query with placeholders
$sql = "SELECT * FROM st_users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usernamePost, $passwordPost);

// Execute the statement
$stmt->execute();
$stmt->bind_result($id, $email, $username, $password, $date_created);

if ($stmt->fetch()) {
    echo $username . "logged in.";
} else {
    // Failed login, redirect to login.php
    header('Location: login.php');
}

// Close myslqi objs
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - Log In</title>
</head>

<body>

</body>
</html>
