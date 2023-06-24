<?php 
namespace App\Controllers;

use App\Models\Song;

class SongController
{   
    public function create(Song $song)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        // Not working because the cookie stays set why can't we use SESSION?
        if (isset($_COOKIE['user_id']) && is_numeric($_COOKIE['user_id']))
        { 
            $songId = $song->createSong(
                $song->getUserId(),
                $song->getSongTitle(),
                $song->getArtists(),
                $song->getTempo(),
                $song->getSongKey(),
                $song->getOriginalKey(),
                $song->getLink(),
                $song->getNotes()
            );
            return $songId;
        } else {
            header("Location: login.php");
            return;
        }

    }

    public function update($id)
    {
        // TODO
    }

    public function delete($id)
    {
        // TODO
    }

    public function read($id)
    {
        // TODO
    }
}
