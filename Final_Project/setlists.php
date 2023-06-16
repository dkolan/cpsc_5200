<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - Log In</title>
</head>

<?php
$file = fopen('data/users.csv', 'r');

// Skip the header row
fgetcsv($file);

$found = false;
$usernamePost = $_POST["username"];
$passwordPost = $_POST["password"];

while (($data = fgetcsv($file)) !== false) {
    $email = $data[0];
    $username = $data[1];
    $password = $data[2];

    if ($username === $usernamePost && $password === $passwordPost) {
        $found = true;
        break;
    }
}

fclose($file);
?>

<body>
    <?php
    if ($found) {
        echo $usernamePost . " logged in!";
    } else {
        echo "Not found.";
        echo $usernamePost;
    }
    ?>
    <!-- <div class="login-container">
        <h2>Setlist Tracker</h2>
        <form action="user.php" method="post">
            <input class="text-input" type="text" placeholder="Username" required="true">
            <input class="text-input" type="password" placeholder="Password" required="true">
            <div class="remember-checkbox"><label><input type="checkbox" /> Remember me</label></div>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Register for an account.</a>
    </div> -->
</body>
</html>
