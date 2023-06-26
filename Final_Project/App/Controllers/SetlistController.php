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
        // Not working because the cookie stays set why can't we use SESSION?
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
}
