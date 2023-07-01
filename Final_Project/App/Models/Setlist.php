<?php
namespace App\Models;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/sql_lib.php';

class Setlist {
    private $id;
    private $userId;
    private $name;
    private $city;
    private $state;
    private $date;
    private $type;

	public function getuserId() {
		return $this->userId;
	}

	public function setUserId($userId) {
		$this->userId = $userId;
		return $this;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

    public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}
    public function getCity() {
		return $this->city;
	}

	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
    public function getState() {
		return $this->state;
	}

	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	public function getDate() {
		return $this->date;
	}
	
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

    function createSetlist($user_id, $name, $city, $state, $setlist_date, $setlist_type) {
        $conn = createConnection();

        $sql = "INSERT INTO st_setlists (user_id, name, city, state, setlist_date, setlist_type, date_created) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        $currentDate = date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, 'issssss', $user_id, $name, $city, $state, $setlist_date, $setlist_type, $currentDate);
        if (mysqli_stmt_execute($stmt)) {
            $setlistId = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_close($stmt);
            $conn->close();
            return $setlistId;
        } else {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }

    function getSetlists($user_id) 
	{
        $conn = createConnection();

        $sql = "SELECT id, user_id, name, city, state, setlist_date, setlist_type from st_setlists WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);

        if (mysqli_stmt_execute($stmt)) 
		{
            mysqli_stmt_bind_result($stmt, $setlist_id, $setlist_user, $name, $city, $state, $setlist_date, $setlist_type);

			$setlists = array();

			while(mysqli_stmt_fetch($stmt))
			{
				$retrievedSetlist = new Setlist();
				$retrievedSetlist->setId($setlist_id);
				$retrievedSetlist->setUserId($setlist_user);
				$retrievedSetlist->setName($name);
				$retrievedSetlist->setCity($city);
				$retrievedSetlist->setState($state);
				$retrievedSetlist->setDate($setlist_date);
				$retrievedSetlist->setType($setlist_type);

				$setlists[] = $retrievedSetlist;
			}

            mysqli_stmt_close($stmt);
            $conn->close();

			return $setlists;

        } else {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }
}
