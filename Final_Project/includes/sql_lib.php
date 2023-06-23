<?php
function createConnection()
{
    $servername = "sysmysql8.auburn.edu";
    $username = "dzk0077";
    $password = "Petty2-Gallon-Audibly";
    $db = "dzk0077db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
