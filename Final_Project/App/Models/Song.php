<?php
namespace App\Models;
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/sql_lib.php';

class Song {
    private $id;
    private $userId;
    private $songTitle;
    private $artists;
    private $tempo;
    private $songKey;
    private $originalKey;
    private $link;
    private $notes;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getSongTitle() {
        return $this->songTitle;
    }

    public function setSongTitle($songTitle) {
        $this->songTitle = $songTitle;
    }

    public function getArtists() {
        return $this->artists;
    }

    public function setArtists($artists) {
        $this->artists = $artists;
    }

    public function getTempo() {
        return $this->tempo;
    }

    public function setTempo($tempo) {
        $this->tempo = $tempo;
    }

    public function getSongKey() {
        return $this->songKey;
    }

    public function setSongKey($songKey) {
        $this->songKey = $songKey;
    }

    public function getOriginalKey() {
        return $this->originalKey;
    }

    public function setOriginalKey($originalKey) {
        $this->originalKey = $originalKey;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    function createSong($user_id, $song_title, $artists, $tempo, $song_key, $original_key, $link, $notes) {
        $conn = createConnection();

        $sql = "INSERT INTO st_songs (user_id, song_title, artists, tempo, song_key, original_key, link, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, 'issssiss', $user_id, $song_title, $artists, $tempo, $song_key, $original_key, $link, $notes);
        if ( mysqli_stmt_execute($stmt)) {
            $songId = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_close($stmt);
            $conn->close();
            return $songId;
        } else {
            echo "Error: " . mysqli_error($conn);
            return false;
        }
    }
}
