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

    public function read($id)
    {
        // TODO
    }

    public function authUser(User $user)
    {
        $userId = $user->authUser(
            $user->getUsername(),
            $user->getPassword());

        return $userId;
    }
}
