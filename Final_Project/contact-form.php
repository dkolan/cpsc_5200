<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Includes
include 'App/Controllers/ContactController.php';
include 'App/Models/Contact.php';
include 'App/Models/User.php';
use \App\Models\User;
use \App\Controllers\ContactController;
use \App\Models\Contact;

// Check for currentUser data to use for song creation
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

// Create song controller to send data upstream
// If this page make a POST, extract the fields from the POST
// make a Song obj, set the fields, send upstream to DB
$contactController = new ContactController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactUserId = $currentUser->getId();
    $contactMsg = $_POST['message'];

    $contact = new Contact();
    $contact->setUserId($contactUserId);
    $contact->setMessage($contactMsg);

    if (strcasecmp($_POST['action'], 'submit') == 0) {
        $contactId = $contactController->createMessage($contact);
    }

    $contactCreated = false;
    if ($contactId) {
        $contactCreated = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/main.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - Contact</title>
</head>

<body>
    <?php include 'nav-bar.html'; ?>

    <div class="form-container">
        <h2 class="centered-text form-title">
            Contact Us
        </h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group-inline">
                <div class="form-group half-width">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required="true"
                        value="<?= isset($currentUser) ? $currentUser->getUsername() : '' ?>">
                </div>

                <div class="form-group half-width">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required="true"
                        value="<?= isset($currentUser) ? $currentUser->getEmail() : '' ?>">
                </div>
            </div>
            
            <div class="form-group full-width">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="10"></textarea>
            </div>

            <div class="form-group-inline centered-text">
                <?php
                if (isset($contactCreated)) {
                echo ($contactCreated) ? "User feedback submitted." : "User feedback not submitted.";
                }
                // if (isset($songId) && isset($contactCreated)) {
                //     echo ($songCreated) ? stripslashes($songTitleArtistString) . " added." : "Song not created.";
                // } elseif (isset($songEdited)) {
                //     echo ($songEdited) ? stripslashes($songTitleArtistString) . " edited." : "Song not edited.";
                // }
                ?>
            </div>

            <div class="form-group full-width add-song-button">
                <input type="hidden" name="action" value="submit">
                <!-- <input type="hidden" name="song_id" value="<?= isset($song) ? $song->getId() : '' ?>"> -->
                <button type="submit">Submit Feedback</button>
            </div>
        </form>
    </div>
</body>

</html>