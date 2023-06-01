<?php include("top.html"); 
$userName = $_GET["name"];
?>

<h1>Matches for <?= $userName ?></h1>

<?php
    // Get users, create map for each user in CSV
    $rows = array_map("str_getcsv", file("singles.txt"));
    $csv = array();
    $headers = array("name", "gender", "age", "personalityType", "os", "minAge", "maxAge");
    foreach($rows as $row) {
        $csv[] = array_combine($headers, $row);
    }

    // Get profile info of returning user
    $returningUserProfile = array();
    foreach($csv as $user) {
        if (strcasecmp($userName, $user["name"]) == 0) {
            $returningUserProfile = $user;
        }
    }

    // Store matches in list, use flag to exit
    $matches = array();

    // Don't need to access and cast returning user ages in the loop
    $returningUserAge = intval($returningUserProfile["age"]);
    $returningUserMinAge = intval($returningUserProfile["minAge"]);
    $returningUserMaxAge = intval($returningUserProfile["maxAge"]);
    $returningUserPersonality = str_split($returningUserProfile["personalityType"]);

    // Iterate through all users
    foreach($csv as $user) {
        if (strcasecmp($user["gender"], $returningUserProfile["gender"]) == 0) {
            continue;
        }

        $potentialMatchAge = intval($user["age"]);
        $potentialMatchMinAge = intval($user["minAge"]);
        $potentialMatchMaxAge = intval($user["maxAge"]);
        if ($returningUserAge < $potentialMatchMinAge ||
            $returningUserAge > $potentialMatchMaxAge ||
            $potentialMatchAge < $returningUserMinAge ||
            $potentialMatchAge > $returningUserMaxAge) {
            continue;
        }

        if (strcasecmp($user["os"], $returningUserProfile["os"]) != 0) {
            continue; 
        }

        $potentialMatchPersonality = str_split($user["personalityType"]);
        if (array_intersect($returningUserPersonality, $potentialMatchPersonality) == 0) {
            continue;
        }

        $matches[] = $user;
    }

    foreach($matches as $match) {
        ?>
        <div class="match">
            <p>
                <img src="user.jpg" alt="User sliced in half">
                <?= $match["name"] ?> 
            </p>
            <ul>
                <strong>gender:</strong>
                <?= $match["gender"] ?><br />
                <strong>age:</strong>
                <?= $match["age"] ?><br />
                <strong>type:</strong>
                <?= $match["personalityType"] ?><br />
                <strong>OS:</strong>
                <?= $match["os"] ?><br />
            </ul>

        </div>
    <?php
    }
    ?>
<!-- <?php
    echo '<pre>'; print_r($csv); echo '</pre>';
    echo '<pre>'; print_r($returningUserProfile); echo '</pre>';
    echo '<pre>'; print_r($matches); echo '</pre>';
?> -->

<?php include("bottom.html"); ?>
<!-- 
[name] => Marty Stepp
            [gender] => male
            [age] => 30
            [personalityType] => ISTJ
            [os] => Linux
            [minAge] => 1
            [maxAge] => 99 -->