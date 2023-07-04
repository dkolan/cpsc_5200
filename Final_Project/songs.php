<?php
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
include 'App/Models/User.php';
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
use \App\Controllers\SetlistController;
use \App\Models\Setlist;
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If POST contains both at least a song_id and setlist_id, we'll associate songs with a setlist
    if (isset($_POST['song_id']) && isset($_POST['setlist_id'])) {
        $setlistController = new SetlistController();
        $setlist_song_ids = $setlistController->addSongToSetlist($_POST['setlist_id'], $_POST['song_id']);

    } elseif (isset($_POST['song_id'])) {
        $songIdToDelete = $_POST['song_id'];
        $songController = new SongController();
        if ($songController->deleteSong($songIdToDelete)) {
            header("Location: ".$_SERVER['PHP_SELF']);
        }
    }
    // If we have a setlist ID, we will add songs to the setlist
    if (isset($_POST['setlist_id'])) {
        $setlistController = new SetlistController();
        $setlist = $setlistController->getSetlistById(intval($_POST['setlist_id']));
    } else {
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
        <?= isset($_POST['setlist_id']) ? $setlist->getName() . " (" . date('F d, Y', strtotime($setlist->getDate())) . ")" : "" ?>
    </h3>
    <h4 class="centered-text form-title">
        <?= isset($setlist_song_ids) ? "Songs added to setlist." : "" ?>
    </h4>

    <form class="songs" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <table class="songs-table">
            <tr class="songs-table-row">
                <th class="songs-table-header">Title</th>
                <th class="songs-table-header">Artist</th>
                <th class="songs-table-header">Tempo</th>
                <th class="songs-table-header">Key</th>
                <th class="songs-table-header songs-table-centered">Original Key</th>
                <th class="songs-table-header songs-table-centered">Select</th>
                <th class="songs-table-header songs-table-centered"></th>
            </tr>
            <?php
            foreach ($songs as $song) {
                ?>
                <tr class="songs-table-row">
                    <td class="songs-table-field">
                        <?= $song->getSongTitle() ?>
                    </td>
                    <td class="songs-table-field">
                        <?= $song->getArtist() ?>
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
                    <td class="songs-table-header songs-table-centered">
                        <input type="checkbox" id="song-id" name="song_id[]" value="<?= $song->getId() ?>">
                    </td>
                    <td class="songs-table-field">
                        <div class="song-edit-btn-container">
                            <div class="song-edit-btn">
                                <!-- <form action="new-song.php" method="post"> -->
                                <a href="new-song.php?song_id=<?= $song->getId() ?>">
                                    <!-- <input type="hidden" name="song_id" value="<?= $song->getId() ?>"> -->
                                    <button class="song-action-button" type="button">Edit</button>
                                </a>
                                <!-- </form> -->
                            </div>
                            <div class="song-edit-btn">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                    <input type="hidden" name="song_id" value="<?= $song->getId() ?>">
                                    <button class="song-action-button" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <!-- No idea if this is a reasonable way to track the current setlist to add to... -->
        <input type="hidden" name="setlist_id" value="<?= isset($_POST['setlist_id']) ? $_POST['setlist_id'] : '' ?>">
        <div class="add-songs-button">
            <button class="add-song-submit-btn" type="submit">Add Songs to Setlist</button>
        </div>
    </form>
</body>

</html>