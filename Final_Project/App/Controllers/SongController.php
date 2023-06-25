<?php 
namespace App\Controllers;

use App\Models\User;
use App\Models\Song;

class SongController
{   
    public function create(Song $song)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        // Not working because the cookie stays set why can't we use SESSION?
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $songId = $song->createSong(
                $song->getUserId(),
                $song->getSongTitle(),
                $song->getArtist(),
                $song->getTempo(),
                $song->getSongKey(),
                $song->getMode(),
                $song->getOriginalKey(),
                $song->getLink(),
                $song->getNotes()
            );
            $songId;
            return $songId;
        } else {
            return false;
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
