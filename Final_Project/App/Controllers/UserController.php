<?php 
namespace App\Controllers;

use App\Models\User;

class UserController
{   
    public function createUser(User $user)
    {
        $userId = $user->createUser(
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword());
            
        return $userId;
    }

    public function update($id)
    {
        // TODO
    }

    public function delete($id)
    {
        // TODO
    }

    public function getUserById($id)
    {
        $userObj = new User();
        $userJSON = $userObj->getUserById($id);
        // var_dump($userObj);
        return $userJSON;
    }

    public function authUser(User $user)
    {
        $userId = $user->authUser(
            $user->getUsername(),
            $user->getPassword());

        return intval($userId);
    }
}
