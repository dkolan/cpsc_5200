<?php
include 'App/Controllers/UserController.php';
include 'App/Models/User.php';
use \App\Controllers\UserController;
use \App\Models\User;

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $user->setEmail($userEmail);
    $user->setUsername($username);
    $user->setPassword($password);

    $userId = $userController->createUser($user);

    $registrationFailed = false;
    if ($userId) {
        header('Location: login.php');
    } else {
        $registrationFailed = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - Register</title>
</head>

<body>
    <div class="login-container">
        <h2>Setlist Tracker</h2>
        <h3>Register New User</h3>
        <span class="user-created-msg">
            <?= $registrationFailed ? "Registration Unsuccessful." : "" ?>
        </span>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input name="email" class="text-input" type="email" placeholder="Email" required="true">
            <input name="username" class="text-input" type="text" placeholder="Username" required="true">
            <input name="password" class="text-input" type="password" placeholder="Password" required="true">
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>