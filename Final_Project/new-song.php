<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Includes
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
include 'App/Models/User.php';
use \App\Models\User;
use \App\Controllers\SongController;
use \App\Models\Song;

// Check for currentUser data to use for song creation
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

// Create song controller to send data upstream
// If this page make a POST, extract the fields from the POST
// make a Song obj, set the fields, send upstream to DB
$songController = new SongController();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $songTitle = $_POST['song-title'];
    $artists = $_POST['artist'];
    $tempo = $_POST['tempo'];
    $songKey = $_POST['key'];
    $songMode = strcasecmp($_POST['mode'], "major") == 0 ? 0 : 1;
    $originalKey = isset($_POST['original-key']) ? true : false;
    $link = $_POST['link'];
    $notes = $_POST['notes'];

    $song = new Song();
    $song->setUserId($currentUser->getId());
    $song->setSongTitle($songTitle);
    $song->setArtist($artists);
    $song->setTempo($tempo);
    $song->setSongKey($songKey);
    $song->setMode($songMode);
    $song->setOriginalKey($originalKey);
    $song->setLink($link);
    $song->setNotes($notes);

    // var_dump($song);
    $songId = $songController->create($song);

    // If the song is created, 
    $songCreated = false;
    if ($songId)
    {
        $songTitleArtistString = $song->getSongTitle() . " by " . $song->getArtist();
        $songCreated = true;
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

        <div class="form-container">
            <h2 class="centered-text form-title">Add/Edit Song</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group full-width">
                    <label for="song-title">Song Title</label>
                    <input type="text" id="song-title" name="song-title" required="true">
                </div>

                <div class="form-group full-width">
                    <label for="artist">Artist</label>
                    <input type="text" id="artist" name="artist" required="true">
                </div>

                <div class="form-group-inline">
                    <div class="form-group quarter-width">
                        <label for="tempo">Tempo</label>
                        <input type="number" id="tempo" name="tempo">
                    </div>

                    <div class="form-group quarter-width">
                        <label for="key">Key</label>
                        <select id="key" name="key">
                            <option value="C">C</option>
                            <option value="C#">C#/Db</option>
                            <option value="D">D</option>
                            <option value="D#">D#/Eb</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="F#">F#/Gb</option>
                            <option value="G">G</option>
                            <option value="G#">G#/Ab</option>
                            <option value="A">A</option>
                            <option value="A#">A#/Bb</option>
                            <option value="B">B</option>
                        </select>
                    </div>

                    <div class="form-group quarter-width">
                        <label for="original-key">Mode</label>
                        <select id="mode" name="mode">
                            <option value="major">Major</option>
                            <option value="minor">Minor</option>
                        </select>
                    </div>
                    
                    <div class="form-group quarter-width">
                        <label for="original-key">Original Key?</label>
                        <input type="checkbox" id="original-key" name="original-key">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="link">Link</label>
                    <input type="text" id="link" name="link">
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="10"></textarea>
                </div>

                <div class="form-group-inline centered-text">
                    <?= isset($songId) ? $songCreated ? $songTitleArtistString . " added." : "Song not created." : "" ?>
                </div>

                <div class="form-group full-width add-song-button">
                    <button type="submit">Add Song</button>
                </div>
            </form>
        </div>

</body>

</html>