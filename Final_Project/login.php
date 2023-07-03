<?php
// Includes
include 'App/Controllers/UserController.php';
include 'App/Models/User.php';
use \App\Controllers\UserController;
use \App\Models\User;

foreach ($_COOKIE as $key => $value)
{
    unset($_COOKIE[$key]);
    setcookie($key, "", time() - 1, "/");
}

$userController = new UserController();
// If the request on this page is a POST, grab the form data and auth the user.
// If the user is successfully authenticated, set the user's data (JSON),
// and store it as a cookie (which only accepts primitives, hence JSON), and go to setlists.php.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $user->setUsername($username);
    $user->setPassword($password);

    $userId = $userController->authUser($user);

    $loginFailed = false;
    if ($userId != -1)
    {
        $currentUser = new User();
        $currentUser = $userController->getUserById($userId);
        $serializedUser = $currentUser->serialize();
        setcookie('currentUser', $serializedUser, time() + 3600, '/');
        header('Location: setlists.php');
    } else
    {
        $loginFailed = true;
    }
}
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
        <span class="user-created-msg">
            <?= $loginFailed ? "Login Unsuccessful." : "" ?>
        </span>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input name="username" class="text-input" type="text" placeholder="Username" required="true">
            <input name="password" class="text-input" type="password" placeholder="Password" required="true">
            <div class="remember-checkbox"><label><input type="checkbox" /> Remember me</label></div>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Register for an account.</a>
    </div>
</body>
</html>