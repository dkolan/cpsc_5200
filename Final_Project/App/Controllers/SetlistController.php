<?php 
namespace App\Controllers;

use App\Models\User;
use App\Models\Setlist;

// Class representing a setlist
class SetlistController
{   
    // Creates a setlist record in the DB given a seltlist object
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

    // Edits a setlist given a setlist object with fields to use to edit with
    public function editSetlist(Setlist $setlist)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $setlistUpdated = $setlist->updateSetlist(
                $setlist->getId(),
                $setlist->getName(),
                $setlist->getCity(),
                $setlist->getState(),
                $setlist->getDate(),
                $setlist->getType()
            );
            return $setlistUpdated;
        } else {
            return false;
        }
    }

    // Deletes a setlist given its ID
    public function deleteSetlist($setlist_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $setlist = new Setlist();
            $setlistDeleted = $setlist->deleteSetlist($setlist_id);

            return $setlistDeleted;
        } else {
            return false;
        }
    }

    // Deletes a song from the relationship with a particular setlist given the song_id and setlist_id
    public function deleteSongFromSetlist($song_id, $setlist_id)
    {
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $setlist = new Setlist();
            $songDeletedFromSetlist = $setlist->deleteSongFromSetlist($song_id, $setlist_id);
            return $songDeletedFromSetlist;
        } else {
            return false;
        }
    }

    // Gets setlsits based on a users ID
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

    // Gets a setlist given its setlist_id
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

    // Adds a song to a letlist using it's foreign key relation
    public function addSongToSetlist($setlist_id, $song_id)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        if (isset($_COOKIE['currentUser']))
        { 
            $setlist = new Setlist();
            $setlist->setId($setlist_id);
            $setlist_song_ids = array();
            $setlist_song_id = $setlist->addSongToSetlist($setlist_id, $song_id);
            return $setlist_song_id;
        } else {
            return false;
        }
    }

    // Gets all songs in a setlist given its id.
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
