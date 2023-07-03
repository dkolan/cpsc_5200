<?php
include 'App/Controllers/SetlistController.php';
include 'App/Models/Setlist.php';
include 'App/Models/User.php';
include 'App/Controllers/SongController.php';
include 'App/Models/Song.php';
use \App\Controllers\SetlistController;
use \App\Models\Setlist;
use \App\Models\User;
use App\Controllers\SongController;
use \App\Models\Song;

// If there is a cookie for current user, decode the JSON into a User object
// to be used for actions in the application.
if (isset($_COOKIE['currentUser']))
{
    $currentUser = new User();
    $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
}
$setlistController = new SetlistController();
$setlists = $setlistController->getSetlists($currentUser->getId());
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Get the setlist associated with the id
    $setlist = $setlistController->getSetlistById(intval($_POST['setlist_id']));
    
    // var_dump($setlist);

    // If the setlist is successfully retrieved
    if ($setlist) 
    {
        // Get the songs in the setlist
        $songsIdsInSetlist = $setlistController->getSongIdsInSetlist($setlist_id);
        // var_dump($songsIdsInSetlist);

        // If the song IDs in the setlist have been successfully retrieved...
        if($songsIdsInSetlist)
        {
            // Get all the song objects that belond in the setlist
            $songController = new SongController();
            $songsInSetlist = $songController->getSongsBySongIds($songsIdsInSetlist);
            // var_dump($songsInSetlist);
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Setlist Manager</title>
</head>

<body>
    <?php include 'nav-bar.html'; ?>
    <h2 class="centered-text form-title"><?= $setlist->getName() ?> Setlist</h2>
    <h3 class="centered-text form-title"><?= date('F d, Y', strtotime($setlist->getDate())) ?></h3>

    <form class="songs" action="songs.php" method="post">
        <div class="add-songs-button">
            <button type="submit" name="setlist_id" value="<?= $setlist->getId() ?>">
                Add Songs to Setlist
            </button>
        </div>
    </form>
    
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
            if (isset($songsInSetlist))
            {
            foreach($songsInSetlist as $song) { 
                
            ?>
                <details class="setlist-row">
                    <summary>
                        <div class="setlist-fields">
                            <div class="setlist-field"><?= $song->getSongTitle() ?></div>
                            <div class="setlist-field"><?= $song->getArtist() ?></div>
                            <div class="setlist-field"><?= $song->getSongKey() . " " . (($song->getMode() == 0) ? "Major" : "Minor") ?></div>
                            <div class="setlist-field"><?= $song->getTempo() ?></div>
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
                        <div class="break"></div>
                        <div class="song-detail-field-content">
                            <p><?= $song->getNotes() ?></p>
                        </div>
                    </div>
                </details>
            <?php }} ?>
        </div>
    </div>
</body>
</html>
