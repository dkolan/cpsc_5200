<?php 
namespace App\Controllers;

use App\Models\User;

// Controller class for Users
class UserController
{   
    // Creates a user object given the object provided by the view.
    public function createUser(User $user)
    {
        $userId = $user->createUser(
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword());
            
        return $userId;
    }

    // Gets a user object given the users ID
    public function getUserById($id)
    {
        $userObj = new User();
        $userJSON = $userObj->getUserById($id);
        return $userJSON;
    }

    // Authenticates the user.
    public function authUser(User $user)
    {
        $userId = $user->authUser(
            $user->getUsername(),
            $user->getPassword());

        return intval($userId);
    }
}
