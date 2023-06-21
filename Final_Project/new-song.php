<?php
// Includes
include 'includes/sql_lib.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/main.css" type="text/css" rel="stylesheet">
    <title>Setlist Manager - New Song</title>
</head>

<body>
    <div class="menu-container">
        <nav class="menu">
            <ul class="menu-nav">
                <li class="menu-item">
                    <a class="menu-link" href="#">Setlists Home</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="#">New Setlist</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="new-song.php">New Song</a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="#">All Songs</a>
                </li>
            </ul>
            <a class="menu-link ml-auto" href="#">Log Out</a>
        </nav>
    </div>

    <div class="add-song-container">
        <div class="form-container">
            <h2 class="centered-text form-title">Add/Edit Song</h2>
            <form>
                <div class="form-group full-width">
                    <label for="song-title">Song Title</label>
                    <input type="text" id="song-title" name="song-title">
                </div>

                <div class="form-group full-width">
                    <label for="artist">Artist</label>
                    <input type="text" id="artist" name="artist">
                </div>

                <div class="form-group-inline">
                    <div class="form-group half-width">
                        <label for="tempo">Tempo</label>
                        <input type="text" id="tempo" name="tempo">
                    </div>

                    <div class="form-group quarter-width">
                        <label for="key">Key</label>
                        <select id="key" name="key">
                            <option value="C">C</option>
                            <option value="C#">C#</option>
                            <option value="D">D</option>
                            <option value="D#">D#</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="F#">F#</option>
                            <option value="G">G</option>
                            <option value="G#">G#</option>
                            <option value="A">A</option>
                            <option value="A#">A#</option>
                            <option value="B">B</option>
                        </select>
                    </div>

                    <div class="form-group quarter-width">
                        <label for="original-key">Original Key</label>
                        <input type="checkbox" id="original-key" name="original-key">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="link">Link</label>
                    <input type="text" id="link" name="link">
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="10"></textarea>
                </div>

                <div class="form-group-inline centered-text">
                    <label class="centered-text" for="add-to-my-songs">Add to my songs</label>
                    <input type="checkbox" id="add-to-my-songs" name="add-to-my-songs">
                </div>


                <div class="form-group full-width add-song-button">
                    <button type="submit">Add Song</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>