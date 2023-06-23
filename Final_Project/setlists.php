<?php
// Includes
include 'includes/sql_lib.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/main.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager</title>
</head>

<body>
    <div class="menu-container">
        <nav class="menu">
            <ul class="menu-nav">
                <li class="menu-item">
                    <a class="menu-link" href="setlists.php">Setlists Home</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="#">New Setlist</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="new-song.php">New Song</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="#">All Songs</a>
                </li>
            </ul>
            <a class="menu-link ml-auto" href="#">Log Out</a>
        </nav>
    </div>
</body>
</html>
