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
var_dump($setlists)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/main.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Setlist Manager</title>
</head>

<body>
    <?php include 'nav-bar.html'; ?>
    <h2 class="centered-text form-title"><?= $currentUser->getUsername() ?>'s Setlists</h2>
    
    <div class="setlist">
        <div class="setlist-row setlist-header">
            <div class="setlist-field">Name</div>
            <div class="setlist-field">Location</div>
            <div class="setlist-field">Date</div>
            <div class="setlist-field">Event Type</div>
            <i id="hidden" class="chevron-right fas fa-chevron-right"></i>  
</div>
        <?php
            foreach ($setlists as $setlist)
            {
        ?>      <a class="setlist-row">
                    <div class="setlist-field"><?= $setlist->getName() ?></div>
                    <div class="setlist-field"><?= $setlist->getCity() . ", " . $setlist->getState() ?></div>
                    <div class="setlist-field"><?= $setlist->getDate() ?></div>
                    <div class="setlist-field"><?= $setlist->getType() ?></div>
                    <i class="chevron-right fas fa-chevron-right"></i>
                </a>
        <?php
            }
        ?>
    </div>
</body>
</html>
