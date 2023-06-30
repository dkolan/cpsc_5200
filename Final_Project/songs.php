<?php
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
include 'App/Models/User.php';
use App\Controllers\SongController;
use \App\Models\User;

// If there is a cookie for current user, decode the JSON into a User object
// to be used for actions in the application.
if (isset($_COOKIE['currentUser']))
{
    $currentUser = new User();
    $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
}
$songController = new SongController();
$songs = $songController->getSongsById($currentUser->getId());
// var_dump($songs);
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
    <h2 class="centered-text form-title"><?= $currentUser->getUsername() ?>'s Songs</h2>
    <div class="songs">
        <table class="songs-table">
            <tr class="songs-table-row">
                <th class="songs-table-header">Title</th>
                <th class="songs-table-header">Artist</th>
                <th class="songs-table-header">Tempo</th>
                <th class="songs-table-header">Key</th>
                <th class="songs-table-header songs-table-centered">Original Key</th>
                <th class="songs-table-header songs-table-centered">Select</th>
            </tr>
            <?php
            foreach ($songs as $song)
            {
            ?>
            <tr class="songs-table-row">
                <td class="songs-table-field"><?= $song->getSongTitle() ?></td>
                <td class="songs-table-field"><?= $song->getArtist() ?></td>
                <td class="songs-table-field"><?= $song->getTempo() ?></td>
                <td class="songs-table-field"><?= $song->getSongKey() . " " . (($song->getMode() == 0) ? "Major" : "Minor") ?></td>
                <td class="songs-table-field songs-table-centered"><?= ($song->getOriginalKey() == 1) ? "X" : "" ?></td>
                <td class="songs-table-header songs-table-centered">
                    <input type="checkbox" id="song-id" name="<?= $song->getId() ?>" value="song-id">
                </td>
            </tr>
            <?php
            }
            ?>
        </table>

        <div class="form-group full-width create-setlist-button">
            <button type="submit">Add Songs to Setlist</button>
        </div>
    </div>
</body>
</html>
