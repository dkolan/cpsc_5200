<?php
namespace App\Models;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/sql_lib.php';

class Song
{
    private $id;
    private $userId;
    private $songTitle;
    private $artists;
    private $tempo; // Nullable
    private $songKey;
    private $mode;
    private $originalKey;
    private $link; // Nullable
    private $notes; // Nullable

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

    public function getSongTitle()
    {
        return $this->songTitle;
    }

    public function setSongTitle($songTitle)
    {
        $this->songTitle = $songTitle;
    }

    public function getArtist()
    {
        return $this->artists;
    }

    public function setArtist($artists)
    {
        $this->artists = $artists;
    }

    public function getTempo()
    {
        return $this->tempo;
    }

    // Allow for empty tempo field in new-song.php
    public function setTempo($tempo)
    {
        if (is_numeric($tempo))
        {
            $this->tempo = $tempo;
        } else
        {
            $this->tempo = null;
        }
    }

    public function getSongKey()
    {
        return $this->songKey;
    }

    public function setSongKey($songKey)
    {
        $this->songKey = $songKey;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function getOriginalKey()
    {
        return $this->originalKey;
    }

    public function setOriginalKey($originalKey)
    {
        $this->originalKey = $originalKey;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        if (!empty($link))
        {
            $this->link = $link;
        } else
        {
            $this->link = null;
        }
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        if (!empty($notes))
        {
            $this->notes = $notes;
        } else
        {
            $this->notes = null;
        }
    }

    function createSong($user_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes)
    {
        $conn = createConnection();

        $sql = "INSERT INTO st_songs (user_id, song_title, artist, tempo, song_key, mode, original_key, link, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 'issisiiss', $user_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes);
        if (mysqli_stmt_execute($stmt))
        {
            $songId = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_close($stmt);
            $conn->close();
            return $songId;
        } else
        {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }

    function updateSong($song_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes)
    {
        $conn = createConnection();
    
        $sql = "UPDATE st_songs 
                SET song_title = ?, artist = ?, tempo = ?, song_key = ?, mode = ?, original_key = ?, link = ?, notes = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt, 'ssisiissi', $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes, $song_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            $conn->close();
            return true;
        } else {
            die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }

    function deleteSong($song_id)
    {
        $conn = createConnection();
    
        $sql = "DELETE FROM st_songs WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt, 'i', $song_id);
        if (mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_close($stmt);
            $conn->close();
            return true;
        } else
        {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }

    function getSongsByUserId($user_id) 
	{
        $conn = createConnection();

        $sql = "SELECT id, song_title, artist, tempo, song_key, mode, original_key, link, notes from st_songs WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);

        if (mysqli_stmt_execute($stmt)) 
		{
            mysqli_stmt_bind_result($stmt, $song_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes);

			$songs = array();

			while(mysqli_stmt_fetch($stmt))
			{
				$song = new Song();
				$song->setId($song_id);
				$song->setSongTitle($song_title);
				$song->setArtist($artist);
				$song->setTempo($tempo);
				$song->setSongKey($song_key);
				$song->setMode($mode);
				$song->setOriginalKey($original_key);
				$song->setLink($link);
				$song->setNotes($notes);

				$songs[] = $song;
			}

            mysqli_stmt_close($stmt);
            $conn->close();

			return $songs;

        } else
        {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }

    function getSongsBySongIds($songsIdsInSetlist) 
	{
        $songs = array();
        $conn = createConnection();

        $sql = "SELECT id, song_title, artist, tempo, song_key, mode, original_key, link, notes from st_songs WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        // I know this is bad, but I got stuck on WHERE id IN $songsIdsInSetlist
        foreach($songsIdsInSetlist as $songId)
        {
            mysqli_stmt_bind_param($stmt, 'i', $songId);
    
            if (mysqli_stmt_execute($stmt)) 
            {
                mysqli_stmt_bind_result($stmt, $song_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes);
                mysqli_stmt_fetch($stmt);

                $song = new Song();
                $song->setId($song_id);
                $song->setSongTitle($song_title);
                $song->setArtist($artist);
                $song->setTempo($tempo);
                $song->setSongKey($song_key);
                $song->setMode($mode);
                $song->setOriginalKey($original_key);
                $song->setLink($link);
                $song->setNotes($notes);

                $songs[] = $song;
            }
         
        }

        mysqli_stmt_close($stmt);
        $conn->close();

        return $songs;
    }

    function getSongById($song_id) 
	{
        $conn = createConnection();

        $sql = "SELECT id, song_title, artist, tempo, song_key, mode, original_key, link, notes from st_songs WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $song_id);

        if (mysqli_stmt_execute($stmt)) 
		{
            mysqli_stmt_bind_result($stmt, $song_id, $song_title, $artist, $tempo, $song_key, $mode, $original_key, $link, $notes);

            mysqli_stmt_fetch($stmt);
            $song = new Song();
            $song->setId($song_id);
            $song->setSongTitle($song_title);
            $song->setArtist($artist);
            $song->setTempo($tempo);
            $song->setSongKey($song_key);
            $song->setMode($mode);
            $song->setOriginalKey($original_key);
            $song->setLink($link);
            $song->setNotes($notes);
    
            mysqli_stmt_close($stmt);
            $conn->close();

            return $song;
        } else
        {
            // die('Query error: ' . mysqli_error($conn)); // Debug statement
            return false;
        }
    }
}
