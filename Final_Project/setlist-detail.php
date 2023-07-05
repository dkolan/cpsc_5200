<?php
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
include 'App/Models/User.php';
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
use \App\Controllers\SetlistController;
use \App\Models\User;
use App\Controllers\SongController;

// If there is a cookie for current user, decode the JSON into a User object
// to be used for actions in the application.
if (isset($_COOKIE['currentUser'])) {
    $currentUser = new User();
    $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
}
$setlistController = new SetlistController();
$setlists = $setlistController->getSetlists($currentUser->getId());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['song_id'])) {
        $song_id = $_GET['song_id'];
    } else {
        $song_id = null;
    }
    if (isset($_GET['setlist_id'])) {
        $setlist_id = $_GET['setlist_id'];
        $setlist = $setlistController->getSetlistById($setlist_id);
    } else {
        $setlist_id = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unpack POST query parameters
    if (isset($_POST['setlist_id'])) {
        $setlist_id = $_POST['setlist_id'];
        $setlist = $setlistController->getSetlistById($setlist_id);
    } else {
        $setlist_id = null;
    }

    if (isset($_POST['delete_setlist'])) {
        $delete_setlist = $_POST['delete_setlist'];
    } else {
        $delete_setlist = false;
    }

    if (isset($_POST['song_id'])) {
        $song_id = $_POST['song_id'];
    } else {
        $song_id = false;
    }

    if (isset($_POST['referrer'])) {
        $referrer = $_POST['referrer'];
    } else {
        $referrer = false;
    }

    // If user deletes the setlist, delete and redirect back to homepage
    if ($setlist_id && $delete_setlist) {
        $setlistDeleted = $setlistController->deleteSetlist($setlist_id);

        if ($setlistDeleted) {
            header("Location: setlists.php");
        }
    }

    // If user deletes a song from the setlist, redirect to the current setlist-detail page
    if ($setlist_id && $song_id && !$referrer) {
        $songDeletedFromSetlist = $setlistController->deleteSongFromSetlist($song_id, $setlist_id);
        if ($songDeletedFromSetlist) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?setlist_id=" . $setlist_id);
        }
    }

    // If we have the setlist_id, song_id, and we are coming from songs.php, add the song to the setlist
    if ($setlist_id && $song_id && strcasecmp($referrer, "songs.php") == 0) {
        $setlist_song_id = $setlistController->addSongToSetlist($setlist_id, $song_id);
        if ($setlist_song_id) {
            header("Location: setlist-detail.php" . "?setlist_id=" . $setlist_id);
        }
    }
}

// If the setlist is successfully retrieved
if ($setlist) {
    // Get the songs in the setlist
    $songsIdsInSetlist = $setlistController->getSongIdsInSetlist($setlist_id);

    // If the song IDs in the setlist have been successfully retrieved...
    if ($songsIdsInSetlist) {
        // Get all the song objects that belong in the setlist
        $songController = new SongController();
        $songsInSetlist = $songController->getSongsBySongIds($songsIdsInSetlist);
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
        <?= $setlist->getName() ?> Setlist
    </h2>
    <h3 class="centered-text form-title">
        <?= date('F d, Y', strtotime($setlist->getDate())) ?>
    </h3>

    <form class="songs" action="songs.php" method="get">
        <input type="hidden" name="referrer" value="setlist-detail.php">
        <input type="hidden" name="setlist_id" value="<?= $setlist->getId() ?>">
        <div class="add-songs-btn-container">
            <button class="add-songs-to-setlist-btn" type="submit">
                Add Songs to Setlist
            </button>
        </div>
    </form>
    <div class="setlist-edit-btn-container">
        <div class="setlist-edit-btn">
            <a href="new-setlist.php?setlist_id=<?= $setlist->getId() ?>">
                <button class="setlist-action-button" type="button">Edit</button>
            </a>
        </div>
        <div class="setlist-edit-btn">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="setlist_id" value="<?= $setlist->getId() ?>">
                <input type="hidden" name="delete_setlist" value="true">
                <button class="setlist-action-button" type="submit">Delete</button>
            </form>
        </div>
    </div>
    <div class="setlists">
        <div class="setlist">
            <div class="setlist-row setlist-header">
                <div class="setlist-field">Title</div>
                <div class="setlist-field">Artist</div>
                <div class="setlist-field">Key</div>
                <div class="setlist-field">Tempo</div>
                <i id="hidden" class="chevron-right fas fa-chevron-right"></i>
            </div>

            <?php
            if (isset($songsInSetlist)) {
                foreach ($songsInSetlist as $song) {

                    ?>
                    <details class="setlist-row">
                        <summary>
                            <div class="setlist-fields">
                                <div class="setlist-field">
                                    <?= stripslashes($song->getSongTitle()) ?>
                                </div>
                                <div class="setlist-field">
                                    <?= stripslashes($song->getArtist()) ?>
                                </div>
                                <div class="setlist-field">
                                    <?= $song->getSongKey() . " " . (($song->getMode() == 0) ? "Major" : "Minor") ?>
                                </div>
                                <div class="setlist-field">
                                    <?= $song->getTempo() ?>
                                </div>
                                <i class="chevron-right fas fa-chevron-right"></i>
                            </div>
                        </summary>
                        <div class="song-detail-field-container">
                            <div class="song-detail-field-title">
                                Link:
                            </div>
                            <div class="song-detail-field-content">
                                <a href="<?= $song->getLink() ?>"><?= $song->getLink() ?></a>
                            </div>
                        </div>
                        <div class="song-detail-field-container">
                            <div class="song-detail-field-title">
                                Notes:
                            </div>
                            <div class="song-detail-field-content">
                                <?= stripslashes($song->getNotes()) ?>
                            </div>
                        </div>
                        <div class="song-edit-btn-container">
                            <div class="song-edit-btn">
                                <a href="new-song.php?song_id=<?= $song->getId() ?>">
                                    <button class="song-action-button" type="button">Edit</button>
                                </a>
                            </div>
                            <div class="song-edit-btn">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                    <input type="hidden" name="song_id" value="<?= $song->getId() ?>">
                                    <input type="hidden" name="setlist_id" value="<?= $setlist->getId() ?>">
                                    <button class="song-action-button" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </details>
                <?php }
            } ?>
        </div>
    </div>
</body>

</html>