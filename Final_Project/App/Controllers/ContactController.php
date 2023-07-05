<?php 
namespace App\Controllers;

use App\Models\User;
use App\Models\Contact;

// Controller class for contact submissions
class ContactController
{   
    public function createMessage(Contact $contact)
    {
        // Basic check for set cookie -- probably need to verify with DB
        // Checking to prevent potential malicious writes to DB
        // Not working because the cookie stays set why can't we use SESSION?
        if (isset($_COOKIE['currentUser']))
        { 
            $currentUser = new User();
            $currentUser->unserialize((stripslashes($_COOKIE['currentUser'])));
            $contactId = $contact->createMessage(
                $contact->getUserId(),
                $contact->getMessage()
            );
            return $contactId;
        } else {
            return false;
        }

    }
}
