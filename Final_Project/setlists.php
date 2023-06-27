<?php
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
include 'App/Models/User.php';
use \App\Controllers\SetlistController;
use \App\Models\Setlist;
use \App\Models\User;

// If there is a cookie for current user, decode the JSON into a User object
// to be used for actions in the application.
if (isset($_COOKIE['currentUser']))
{
    $currentUser = new User();
    $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
}
$setlistController = new SetlistController();
$setlists = $setlistController->getSetlists($currentUser->getId());
// var_dump($setlists);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
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
                    <a class="menu-link" href="new-setlist.php">New Setlist</a>
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
    <h2 class="centered-text form-title"><?= $currentUser->getUsername() ?>'s Setlists</h2>
    <div class="pure-g">
        <div class="pure-u-1-3"></div>
        <div class="table-container pure-u-1-3">
            <div class="table-responsive">
                <table class="pure-table-bordered pure-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Event Type</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="pure-u-1-3"></div>
    </div>
<!--     
    <div class="header">
        <div class="field">Name</div>
        <div class="field">Location</div>
        <div class="field">Date</div>
        <div class="field">Event Type</div>
    </div> -->
</body>
</html>
