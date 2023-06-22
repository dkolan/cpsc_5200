<?php 
namespace App\Controllers;

use App\Models\Song;

class SongController
{   
    public function create(Song $song)
    {
        $songId = $song->createSong(
            $song->getUserId(),
            $song->getSongTitle(),
            $song->getArtists(),
            $song->getTempo(),
            $song->getSongKey(),
            $song->getOriginalKey(),
            $song->getLink(),
            $song->getNotes()
        );
        return $songId;
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
