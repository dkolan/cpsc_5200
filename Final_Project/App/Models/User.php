<?php
namespace App\Models;
use Serializable;

require_once 'includes/sql_lib.php';

class User implements Serializable {
    private $id;
    private $email;
    private $username;
    private $password;
    private $date_created;

    public function serialize() {
        $encode = json_encode(array(
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'password' => -1,
            'date_created' => $this->date_created
        ));
        
        return $encode;
    }
    
    public function unserialize($data) {
        $values = json_decode($data, true);
        $this->id = $values['id'];
        $this->email = $values['email'];
        $this->username = $values['username'];
        $this->password = $values['password'];
        $this->date_created = $values['date_created'];
    
        return $this;
    }
    
    
    public function getId() {
        return $this->id;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getDateCreated() {
        return $this->date_created;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
    }

    public function createUser($email, $username, $password) {
        $count = $this->userExists($email, $username);
        if ($count > 0) {
            return false;
        }
    
        $conn = createConnection();
    
        $sql = "INSERT INTO st_users (email, username, password, date_created)
                VALUES (?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);

        $salt = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
        $salt = str_replace('+', '.', $salt); 

        $hashedPass = crypt($password, '$2y$10$' . $salt);
    
        $currentDate = date('Y-m-d H:i:s');
        $stmt->bind_param("ssss", $email, $username, $hashedPass, $currentDate);
    
        if ($stmt->execute()) {
            $userId = mysqli_stmt_insert_id($stmt);
            $stmt->close();
            $conn->close();
            return $userId;
        } else {
            $stmt->close();
            $conn->close();
            return -1;
        }
    }
    
    public function getUserById($id) {
        $conn = createConnection();
    
        $sql = "SELECT id, email, username, date_created FROM st_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
    
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $userId, $userEmail, $userName, $userDateCreated);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            $conn->close();
    
            $retrievedUser = new User();
            $retrievedUser->setId($userId);
            $retrievedUser->setEmail($userEmail);
            $retrievedUser->setUsername($userName);
            $retrievedUser->setDateCreated($userDateCreated);
    
            return $retrievedUser;
        } else {
            return false;
        }
    }
    
    public function updateUser() {

    }
    
    public function deleteUser() {
    }

    function authUser($username, $password)
    {
        $conn = createConnection();

        $sql = "SELECT id, password FROM st_users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);;

        $stmt->execute();
        $stmt->bind_result($id, $storedHash);
        $stmt->fetch();

        $salt = substr($storedHash, 0, 29);
        $enteredHash = crypt($password, $salt);

        if ($enteredHash === $storedHash) {
            $stmt->close();
            $conn->close();
            return intval($id);
        } else {
            $stmt->close();
            $conn->close();
            return -1;
        } 
    }

    public function userExists($emailPost, $usernamePost)
    {
        $conn = createConnection();
        $sql = "SELECT COUNT(*) FROM st_users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $emailPost, $usernamePost);

        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        $stmt->close();
        $conn->close();
        return $count;
    }
}
