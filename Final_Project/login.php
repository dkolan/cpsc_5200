<?php
// Includes
include 'includes/sql_lib.php';

createUser($_POST["email"],
    $_POST["username"],
    $_POST["password"],
    date('Y-m-d H:i:s'));
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
    <div class="login-container">
        <h2>Setlist Tracker</h2>
        <form action="setlists.php" method="post">
            <input name="username" class="text-input" type="text" placeholder="Username" required="true">
            <input name="password" class="text-input" type="password" placeholder="Password" required="true">
            <div class="remember-checkbox"><label><input type="checkbox" /> Remember me</label></div>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Register for an account.</a>
    </div>
</body>
</html>
