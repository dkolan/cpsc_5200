<!-- 
Dan Kolan
CPSC 5200 Web Development I
Project 4: NerdLuv (HTML Forms and PHP)

In this page I display and process the user information submitted via the POST
from signup.php.
-->
<?php include("top.html"); ?>

<!-- Display the users name found in the POST array. -->
<p><strong>Thank you!</strong></p>
<p>Welcome to NerdLuv, <?= $_POST["name"] ?>!</p>
<p>Now <a href="matches.php">log in to see your matches!</a></p>

<!--
Extract the users submitted information from the POST array.
Write those values to the CSV file we use for storage: singles.txt.
-->
<?php
$name = $_POST["name"];
$gender = $_POST["gender"];
$age = $_POST["age"];
$personality = $_POST["personality"];
$os = $_POST["os"];
$ageMin = $_POST["ageMin"];
$ageMax = $_POST["ageMax"];

$data = "$name,$gender,$age,$personality,$os,$ageMin,$ageMax\n";
$dataFile = fopen("singles.txt", "a+");
fwrite($dataFile, $data);
fclose($dataFile);
?>

<?php include("bottom.html"); ?>