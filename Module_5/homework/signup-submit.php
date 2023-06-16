<?php include("top.html"); ?>

<strong>Thank you!</strong><br /><br />
Welcome to NerdLuv, <?= $_POST["name"] ?>!<br /><br />
Now <a href="matches.php">log in to see your matches!</a><br /><br />

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