<?php
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
include 'App/Models/User.php';
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
use \App\Controllers\SetlistController;
use \App\Models\User;
use App\Controllers\SongController;

// If there is a cookie for current user, decode the JSON into a User object
// to be used for actions in the application.
if (isset($_COOKIE['currentUser'])) {
    $currentUser = new User();
    $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
}
$songController = new SongController();
$songs = $songController->getSongsByUserId($currentUser->getId());
$setlistController = new SetlistController();

// Unpack the get parameters if needed
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['setlist_id'])) {
        $setlist_id = $_GET['setlist_id'];
        $setlist = $setlistController->getSetlistById($setlist_id);
    } else {
        $setlist_id = null;
    }

    if (isset($_GET['referrer'])) {
        $referrer = $_GET['referrer'];
    } else {
        $referrer = null;
    }
}

// Unpack the post parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['song_id'])) {
        $song_id = $_POST['song_id'];
    } else {
        $song_id = null;
    }

    if (isset($_POST['setlist_id'])) {
        $setlist_id = $_POST['setlist_id'];
    } else {
        $setlist_id = null;
    }

    if (isset($_POST['delete_song'])) {
        $delete_song = $_POST['delete_song'];
    } else {
        $delete_song = false;
    }

    // If there is a setlist_id passed, get the setlist for setlist:songs relationship
    if ($setlist_id) {
        $setlistController = new SetlistController();
        $setlist = $setlistController->getSetlistById(intval($_POST['setlist_id']));
    }

    // If POST contains both at least a song_id and setlist_id, we'll associate songs with a setlist
    if ($song_id && $setlist_id) {
        $setlistController = new SetlistController();
        $setlist_song_ids = $setlistController->addSongToSetlist($setlist_id, $song_id);
        if ($setlist_song_ids) {
            header("Location: setlist-detail.php" . "?setlist_id=" . $setlist_id);
        }
    } elseif ($song_id && $delete_song) {
        $songController = new SongController();
        if ($songController->deleteSong($song_id)) {
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
}
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
    <h2 class="centered-text form-title">
        <?= $currentUser->getUsername() ?>'s Songs
    </h2>
    <h3 class="centered-text form-title">
        <?= isset($_GET['setlist_id']) ? $setlist->getName() . " (" . date('F d, Y', strtotime($setlist->getDate())) . ")" : "" ?>
    </h3>

    <!-- <form class="songs" action="<?= $_SERVER['PHP_SELF'] ?>" method="post"> -->
    <div class="songs">
        <table class="songs-table">
            <tr class="songs-table-row">
                <th class="songs-table-header">Title</th>
                <th class="songs-table-header">Artist</th>
                <th class="songs-table-header">Tempo</th>
                <th class="songs-table-header">Key</th>
                <th class="songs-table-header songs-table-centered">Original Key</th>
                <th class="songs-table-header songs-table-centered"></th>
            </tr>
            <?php
            foreach ($songs as $song) {
                ?>
                <tr class="songs-table-row">
                    <td class="songs-table-field">
                        <?= stripslashes($song->getSongTitle()) ?>
                    </td>
                    <td class="songs-table-field">
                        <?= stripslashes($song->getArtist()) ?>
                    </td>
                    <td class="songs-table-field">
                        <?= $song->getTempo() ?>
                    </td>
                    <td class="songs-table-field">
                        <?= $song->getSongKey() . " " . (($song->getMode() == 0) ? "Major" : "Minor") ?>
                    </td>
                    <td class="songs-table-field songs-table-centered">
                        <?= ($song->getOriginalKey() == 1) ? "X" : "" ?>
                    </td>
                    <td class="songs-table-field">
                        <div class="song-edit-btn-container">
                            <?php if (strcasecmp($referrer, "setlist-detail.php") == 0) { ?>
                                <form class="song-action-form" action="setlist-detail.php" method="post">
                                    <input type="hidden" name="song_id" value="<?= $song->getId() ?>">
                                    <input type="hidden" name="setlist_id" value="<?= $setlist->getId() ?>">
                                    <input type="hidden" name="referrer" value="songs.php">
                                    <div class="song-edit-btn">
                                        <button class="song-action-button" type="submit">Add</button>
                                    </div>
                                </form>
                            <?php } else { ?>

                                <form class="song-action-form" action="new-song.php" method="get">
                                    <input type="hidden" name="song_id" value="<?= $song->getId() ?>">
                                    <div class="song-edit-btn">
                                        <button class="song-action-button" type="submit">Edit</button>
                                    </div>
                                </form>

                                <form class="song-action-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                    <input type="hidden" name="song_id" value="<?= $song->getId() ?>">
                                    <input type="hidden" name="delete_song" value="true">
                                    <div class="song-edit-btn">
                                        <button class="song-action-button" type="submit">Delete</button>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>