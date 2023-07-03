<?php 
namespace App\Controllers;

use App\Models\User;
use App\Models\Setlist;

class SetlistController
{   
    public function create(Setlist $setlist)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize(stripslashes($_COOKIE['currentUser']));
            $setlistId = $setlist->createSetlist(
                $currentUser->getId(),
                $setlist->getName(),
                $setlist->getCity(),
                $setlist->getState(),
                $setlist->getDate(),
                $setlist->getType()
            );
            return $setlistId;
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

    public function getSetlists($userId)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $setlist = new Setlist();
            $setlists = array();

            $setlists = $setlist->getSetlists($userId);

            return $setlists;
        } else {
            return false;
        }

    }

    public function getSetlistById($setlist_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $setlist = new Setlist();

            $setlist = $setlist->getSetlistById($setlist_id);

            return $setlist;
        } else {
            return false;
        }

    }

    public function addSongToSetlist($setlist_id, $song_ids_arr)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        if (isset($_COOKIE['currentUser']))
        { 
            $setlist = new Setlist();
            $setlist->setId($setlist_id);
            $setlist_song_ids = array();
            foreach ($song_ids_arr as $song_id)
            {
                $setlist_song_ids[] = $setlist->addSongToSetlist($setlist_id, $song_id);
            }
            return $setlist_song_ids;
        } else {
            return false;
        }
    }

    public function getSongIdsInSetlist($setlist_id)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        if (isset($_COOKIE['currentUser']))
        { 
            $setlist = new Setlist();
            $setlist->setId($setlist_id);
            $setlistSongIds = $setlist->getSongIdsInSetlist($setlist_id);
            return $setlistSongIds;
        } else {
            return false;
        }
    }
}
