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
            return $songId;
        } else {
            return false;
        }

    }

    public function editSong(Song $song)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        // Not working because the cookie stays set why can't we use SESSION?
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $songUpdated = $song->updateSong(
                $song->getId(),
                $song->getSongTitle(),
                $song->getArtist(),
                $song->getTempo(),
                $song->getSongKey(),
                $song->getMode(),
                $song->getOriginalKey(),
                $song->getLink(),
                $song->getNotes()
            );
            return $songUpdated;
        } else {
            return false;
        }

    }

    public function update($id)
    {
        // TODO
    }

    public function deleteSong($song_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $song = new Song();

            // $currentUser = new User();
            // $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));

            $deleted = $song->deleteSong($song_id);

            return $deleted;
        } else {
            return false;
        }
    }

    public function getSongsByUserId($user_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $song = new Song();
            $songs = array();

            // $currentUser = new User();
            // $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));

            $songs = $song->getSongsByUserId($user_id);

            return $songs;
        } else {
            return false;
        }
    }

    public function getSongsBySongIds($songsIdsInSetlist)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $song = new Song();
            $songs = array();

            // $currentUser = new User();
            // $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));

            $songs = $song->getSongsBySongIds($songsIdsInSetlist);

            return $songs;
        } else {
            return false;
        }
    }

    public function getSongById($song_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $song = new Song();

            // $currentUser = new User();
            // $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));

            $song = $song->getSongById($song_id);

            return $song;
        } else {
            return false;
        }
    }
}
