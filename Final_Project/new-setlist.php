<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Includes
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
include 'App/Models/User.php';
use \App\Models\User;
use \App\Controllers\SetlistController;
use \App\Models\Setlist;

// Check for currentUser data to use for Setlist creation
// If cookie is not set, wipe all cookies, set as blank and redirect.
if (!isset($_COOKIE['currentUser']))
{
    foreach ($_COOKIE as $key => $value)
    {
        unset($_COOKIE[$key]);
        setcookie($key, "", time() - 1, "/");
    }
    header('Location: login.php');
} else
{
    $currentUser = new User();
    $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));
}

// Create Setlist controller to send data upstream
// If this page make a POST, extract the fields from the POST
// make a Setlist obj, set the fields, send upstream to DB
$setlistController = new SetlistController();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = $_POST['setlist-name'];
    $city = $_POST['setlist-city'];
    $state = $_POST['setlist-state'];
    $setlistDate = date('Y-m-d', strtotime($_POST['setlist-date']));
    $setlistType = $_POST['setlist-type'];

    $setlist = new Setlist();
    $setlist->setuserId($currentUser->getId());
    $setlist->setName($name);
    $setlist->setCity($city);
    $setlist->setState($state);
    $setlist->setDate($setlistDate);
    $setlist->setType($setlistType);

    // var_dump($song);
    $setlistId = $setlistController->create($setlist);

    // If the song is created, 
    $setlistCreated = false;
    if ($setlistId)
    {
        $setlistCreated = true;
    } else
    {
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/main.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - New Song</title>
</head>

<body>
    <?php include 'nav-bar.html'; ?>
    <div class="add-song-container">
        <div class="form-container">
            <h2 class="centered-text form-title">Add Setlist</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group full-width">
                    <label for="song-title">Name</label>
                    <input type="text" id="setlist-name" name="setlist-name" required="true">
                </div>

                <div class="form-group-inline">
                    <div class="form-group third-width">
                        <label for="City">City</label>
                        <input type="text" id="setlist-city" name="setlist-city" required="true">
                    </div>
                    <div class="form-group third-width">
                        <label for="City">State</label>
                        <select id="setlist-state" name="setlist-state">
                            <option value="AL" selected>Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                            <option value="NA">Not a US City</option>
                        </select>
                    </div>
                    <div class="form-group third-width">
                        <label for="location">Date</label>
                        <input type="date" id="setlist-date" name="setlist-date">
                    </div>
                </div>

                <div class="form-group-inline">
                    <div class="form-group quarter-width">
                        <label for="setlist-type">Type</label>
                        <select id="setlist-type" name="setlist-type">
                            <option value="Wedding">Wedding</option>
                            <option value="Private Party">Private Party</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-inline centered-text">
                    <?= isset($songId) ? $songCreated ? $songTitleArtistString . " added." : "Song not created." : "" ?>
                </div>

                <div class="form-group full-width create-setlist-button">
                    <button type="submit">Create New Setlist</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>