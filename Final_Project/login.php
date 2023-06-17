<?php
// Includes
include 'sql_lib.php';

// SQL
$conn = createConnection();

// Params from register.php
$userEmail = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$dateCreated = date('Y-m-d H:i:s');

// Prepare sql statement
$sql = "INSERT INTO st_users (email, username, password, date_created)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ssss", $userEmail, $username, $password, $dateCreated);

// Execute the statement
if ($stmt->execute()) {
    // Modal for user created?
} else {
    // Modal for error? $stmt->error;
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

<?php
// $userEmail = $_POST["email"];
// $username = $_POST["username"];
// $password = $_POST["password"];

// // "Write" to the user file
// $data = $userEmail . ',' . $username . ',' . $password . "\n";

// $file = fopen("data/users.csv", "a"); // Open the file in append mode
// fwrite($file, $data); // Write the data to the file
// fclose($file); // Close the file
?>

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
