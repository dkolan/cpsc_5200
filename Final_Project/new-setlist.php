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
if (!isset($_COOKIE['currentUser'])) {
    foreach ($_COOKIE as $key => $value) {
        unset($_COOKIE[$key]);
        setcookie($key, "", time() - 1, "/");
    }
    header('Location: login.php');
} else {
    $currentUser = new User();
    $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));
}

// Create Setlist controller to send data upstream
// If this page make a POST, extract the fields from the POST
// make a Setlist obj, set the fields, send upstream to DB
$setlistController = new SetlistController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (strcasecmp($_POST['action'], 'add') == 0) {
        $setlistId = $setlistController->create($setlist);

        // If the setlist is created, or edited, display a message.
        $setlistCreated = false;
        if ($setlistId) {
            $setlistCreated = true;
            header('Location: setlists.php');
        }
    } elseif (strcasecmp($_POST['action'], 'edit') == 0) {
        $setlist->setId($_POST['setlist_id']);
        $setlistUpdated = $setlistController->editSetlist($setlist);
        header('Location: setlists.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['setlist_id'])) {
        $setlist = $setlistController->getSetlistById($_GET['setlist_id']);
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

<!-- Populate the setlist form with existing information if editing a setlist. -->

<body>
    <?php include 'nav-bar.html'; ?>
    <div class="add-song-container">
        <div class="form-container">
            <h2 class="centered-text form-title">Add Setlist</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group full-width">
                    <label for="song-title">Name</label>
                    <input type="text" id="setlist-name" name="setlist-name" required="true"
                        value="<?= isset($setlist) ? $setlist->getName() : '' ?>">
                </div>

                <div class="form-group-inline">
                    <div class="form-group third-width">
                        <label for="City">City</label>
                        <input type="text" id="setlist-city" name="setlist-city" required="true"
                            value="<?= isset($setlist) ? $setlist->getCity() : '' ?>">
                    </div>
                    <div class="form-group third-width">
                        <label for="City">State</label>
                        <select id="setlist-state" name="setlist-state">
                            <option value="AL" <?= isset($setlist) && strcasecmp($setlist->getState(), 'AL') == 0 ? 'selected' : '' ?>>Alabama</option>
                            <option value="AK" <?= isset($setlist) && strcasecmp($setlist->getState(), 'AK') == 0 ? 'selected' : '' ?>>Alaska</option>
                            <option value="AZ" <?= isset($setlist) && strcasecmp($setlist->getState(), 'AZ') == 0 ? 'selected' : '' ?>>Arizona</option>
                            <option value="AR" <?= isset($setlist) && strcasecmp($setlist->getState(), 'AR') == 0 ? 'selected' : '' ?>>Arkansas</option>
                            <option value="CA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'CA') == 0 ? 'selected' : '' ?>>California</option>
                            <option value="CO" <?= isset($setlist) && strcasecmp($setlist->getState(), 'CO') == 0 ? 'selected' : '' ?>>Colorado</option>
                            <option value="CT" <?= isset($setlist) && strcasecmp($setlist->getState(), 'CT') == 0 ? 'selected' : '' ?>>Connecticut</option>
                            <option value="DE" <?= isset($setlist) && strcasecmp($setlist->getState(), 'DE') == 0 ? 'selected' : '' ?>>Delaware</option>
                            <option value="DC" <?= isset($setlist) && strcasecmp($setlist->getState(), 'DC') == 0 ? 'selected' : '' ?>>District of Columbia</option>
                            <option value="FL" <?= isset($setlist) && strcasecmp($setlist->getState(), 'FL') == 0 ? 'selected' : '' ?>>Florida</option>
                            <option value="GA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'GA') == 0 ? 'selected' : '' ?>>Georgia</option>
                            <option value="HI" <?= isset($setlist) && strcasecmp($setlist->getState(), 'HI') == 0 ? 'selected' : '' ?>>Hawaii</option>
                            <option value="ID" <?= isset($setlist) && strcasecmp($setlist->getState(), 'ID') == 0 ? 'selected' : '' ?>>Idaho</option>
                            <option value="IL" <?= isset($setlist) && strcasecmp($setlist->getState(), 'IL') == 0 ? 'selected' : '' ?>>Illinois</option>
                            <option value="IN" <?= isset($setlist) && strcasecmp($setlist->getState(), 'IN') == 0 ? 'selected' : '' ?>>Indiana</option>
                            <option value="IA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'IA') == 0 ? 'selected' : '' ?>>Iowa</option>
                            <option value="KS" <?= isset($setlist) && strcasecmp($setlist->getState(), 'KS') == 0 ? 'selected' : '' ?>>Kansas</option>
                            <option value="KY" <?= isset($setlist) && strcasecmp($setlist->getState(), 'KY') == 0 ? 'selected' : '' ?>>Kentucky</option>
                            <option value="LA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'LA') == 0 ? 'selected' : '' ?>>Louisiana</option>
                            <option value="ME" <?= isset($setlist) && strcasecmp($setlist->getState(), 'ME') == 0 ? 'selected' : '' ?>>Maine</option>
                            <option value="MD" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MD') == 0 ? 'selected' : '' ?>>Maryland</option>
                            <option value="MA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MA') == 0 ? 'selected' : '' ?>>Massachusetts</option>
                            <option value="MI" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MI') == 0 ? 'selected' : '' ?>>Michigan</option>
                            <option value="MN" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MN') == 0 ? 'selected' : '' ?>>Minnesota</option>
                            <option value="MS" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MS') == 0 ? 'selected' : '' ?>>Mississippi</option>
                            <option value="MO" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MO') == 0 ? 'selected' : '' ?>>Missouri</option>
                            <option value="MT" <?= isset($setlist) && strcasecmp($setlist->getState(), 'MT') == 0 ? 'selected' : '' ?>>Montana</option>
                            <option value="NE" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NE') == 0 ? 'selected' : '' ?>>Nebraska</option>
                            <option value="NV" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NV') == 0 ? 'selected' : '' ?>>Nevada</option>
                            <option value="NH" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NH') == 0 ? 'selected' : '' ?>>New Hampshire</option>
                            <option value="NJ" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NJ') == 0 ? 'selected' : '' ?>>New Jersey</option>
                            <option value="NM" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NM') == 0 ? 'selected' : '' ?>>New Mexico</option>
                            <option value="NY" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NY') == 0 ? 'selected' : '' ?>>New York</option>
                            <option value="NC" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NC') == 0 ? 'selected' : '' ?>>North Carolina</option>
                            <option value="ND" <?= isset($setlist) && strcasecmp($setlist->getState(), 'ND') == 0 ? 'selected' : '' ?>>North Dakota</option>
                            <option value="OH" <?= isset($setlist) && strcasecmp($setlist->getState(), 'OH') == 0 ? 'selected' : '' ?>>Ohio</option>
                            <option value="OK" <?= isset($setlist) && strcasecmp($setlist->getState(), 'OK') == 0 ? 'selected' : '' ?>>Oklahoma</option>
                            <option value="OR" <?= isset($setlist) && strcasecmp($setlist->getState(), 'OR') == 0 ? 'selected' : '' ?>>Oregon</option>
                            <option value="PA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'PA') == 0 ? 'selected' : '' ?>>Pennsylvania</option>
                            <option value="RI" <?= isset($setlist) && strcasecmp($setlist->getState(), 'RI') == 0 ? 'selected' : '' ?>>Rhode Island</option>
                            <option value="SC" <?= isset($setlist) && strcasecmp($setlist->getState(), 'SC') == 0 ? 'selected' : '' ?>>South Carolina</option>
                            <option value="SD" <?= isset($setlist) && strcasecmp($setlist->getState(), 'SD') == 0 ? 'selected' : '' ?>>South Dakota</option>
                            <option value="TN" <?= isset($setlist) && strcasecmp($setlist->getState(), 'TN') == 0 ? 'selected' : '' ?>>Tennessee</option>
                            <option value="TX" <?= isset($setlist) && strcasecmp($setlist->getState(), 'TX') == 0 ? 'selected' : '' ?>>Texas</option>
                            <option value="UT" <?= isset($setlist) && strcasecmp($setlist->getState(), 'UT') == 0 ? 'selected' : '' ?>>Utah</option>
                            <option value="VT" <?= isset($setlist) && strcasecmp($setlist->getState(), 'VT') == 0 ? 'selected' : '' ?>>Vermont</option>
                            <option value="VA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'VA') == 0 ? 'selected' : '' ?>>Virginia</option>
                            <option value="WA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'WA') == 0 ? 'selected' : '' ?>>Washington</option>
                            <option value="WV" <?= isset($setlist) && strcasecmp($setlist->getState(), 'WV') == 0 ? 'selected' : '' ?>>West Virginia</option>
                            <option value="WI" <?= isset($setlist) && strcasecmp($setlist->getState(), 'WI') == 0 ? 'selected' : '' ?>>Wisconsin</option>
                            <option value="WY" <?= isset($setlist) && strcasecmp($setlist->getState(), 'WY') == 0 ? 'selected' : '' ?>>Wyoming</option>
                            <option value="NA" <?= isset($setlist) && strcasecmp($setlist->getState(), 'NA') == 0 ? 'selected' : '' ?>>Not a US City</option>
                        </select>
                    </div>
                    <div class="form-group third-width">
                        <label for="location">Date</label>
                        <input type="date" id="setlist-date" name="setlist-date"
                            value="<?= isset($setlist) ? $setlist->getDate() : '' ?>">
                    </div>
                </div>

                <div class="form-group-inline">
                    <div class="form-group quarter-width">
                        <label for="setlist-type">Type</label>
                        <select id="setlist-type" name="setlist-type">
                            <option value="Wedding" <?= isset($setlist) && strcasecmp($setlist->getType(), 'Wedding') == 0 ? 'selected' : '' ?>>Wedding</option>
                            <option value="Private Party" <?= isset($setlist) && strcasecmp($setlist->getType(), 'Private Party') == 0 ? 'selected' : '' ?>>Private Party</option>
                            <option value="Corporate" <?= isset($setlist) && strcasecmp($setlist->getType(), 'Corporate') == 0 ? 'selected' : '' ?>>Corporate</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-inline centered-text">
                    <?php
                    // Display success or failure message
                    if (isset($setlistId) && isset($setlistCreated)) {
                        echo ($setlistCreated) ? $setlist->getName() . " added." : "Setlist not created.";
                    } elseif (isset($setlistUpdated)) {
                        echo ($setlistUpdated) ? $setlist->getName() . " updated." : "Setlist not updated.";
                    }
                    ?>
                </div>

                <div class="form-group full-width create-setlist-button">
                    <!-- Not sure if this is the best way to determine if I'm adding or editing or tracking setlist id... -->
                    <input type="hidden" name="action" value="<?= isset($setlist) ? 'edit' : 'add' ?>">
                    <input type="hidden" name="setlist_id" value="<?= isset($setlist) ? $setlist->getId() : '' ?>">
                    <?= isset($setlist) ? '<button type="submit">Edit Setlist</button>' : '<button type="submit">Create New Setlist</button>' ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>