<?php
namespace App\Models;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/sql_lib.php';

// Class representing a contact object
class Contact
{
    private $id;
    private $userId;
    private $message;

    // Accessor and mutator methods
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }


    // Takes in the fields for a contact message and creates a message record in the database
    function createMessage($user_id, $message)
    {
        $conn = createConnection();

        $sql = "INSERT INTO st_contact (user_id, message) 
                VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 'is', $user_id, $message);
        if (mysqli_stmt_execute($stmt))
        {
            $contactId = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_close($stmt);
            $conn->close();
            return $contactId;
        } else
        {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }
}
