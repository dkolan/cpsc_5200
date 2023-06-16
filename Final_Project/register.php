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
        <h3>Register New User</h3>
        <form action="login.php" method="post">
            <input name="email" class="text-input" type="email" placeholder="Email" required="true">
            <input name="username" class="text-input" type="text" placeholder="Username" required="true">
            <input name="password" class="text-input" type="password" placeholder="Password" required="true">
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
