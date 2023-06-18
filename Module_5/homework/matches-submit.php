<!-- 
Dan Kolan
CPSC 5200 Web Development I
Project 4: NerdLuv (HTML Forms and PHP)

In this page I display and process the user information submitted via the POST
from matches.php.
-->
<?php include("top.html"); 
$userName = trim($_GET["name"]);
?>

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

    // If returning user is found
    if (!empty($returningUserProfile)) {
        ?>
        <h1>Matches for <?= $userName ?></h1>
        <?php
        // Store matches in list, use flag to exit
        $matches = array();
    
        // Don't need to access and cast returning user ages in the loop
        $returningUserAge = intval($returningUserProfile["age"]);
        $returningUserMinAge = intval($returningUserProfile["minAge"]);
        $returningUserMaxAge = intval($returningUserProfile["maxAge"]);
        $returningUserPersonality = str_split($returningUserProfile["personalityType"]);
    
        // Iterate through all users and ensure they meet the requirements for compatibility
        // as outlined in the assignment.
        foreach($csv as $user) {
            // Opposite genders. ¯\_(ツ)_/¯
            if (strcasecmp($user["gender"], $returningUserProfile["gender"]) == 0) {
                continue;
            }
            
            // Falls within the right age ranges.
            $potentialMatchAge = intval($user["age"]);
            $potentialMatchMinAge = intval($user["minAge"]);
            $potentialMatchMaxAge = intval($user["maxAge"]);
            if ($returningUserAge <= $potentialMatchMinAge ||
                $returningUserAge >= $potentialMatchMaxAge ||
                $potentialMatchAge <= $returningUserMinAge ||
                $potentialMatchAge >= $returningUserMaxAge) {
                continue;
            }
    
            // Compatible OS choices.
            if (strcasecmp($user["os"], $returningUserProfile["os"]) != 0) {
                continue; 
            }
    
            // Personality type has one letter in common.
            $potentialMatchPersonality = str_split($user["personalityType"]);
            if (count(array_intersect($returningUserPersonality, $potentialMatchPersonality)) == 0) {
                continue;
            }
            
            // Add user to matches array
            $matches[] = $user;
        }
    
        // Iterate through the matches array and render the HTML elements for matches.
        foreach($matches as $match) {
            ?>
            <div class="match">
                <p>
                    <img src="user.jpg" alt="User sliced in half">
                    <?= $match["name"] ?> 
                </p>
                <ul>
                    <li>
                        <strong>gender:</strong>
                        <!-- String validation, compare genders -->
                        <?= strcasecmp($match["gender"], "female") == 0 ? "F" : "M" ?>
                    </li>
                    <li>
                        <strong>age:</strong>
                        <?= $match["age"] ?>
                    </li>
                    <li>
                        <strong>type:</strong>
                        <?= $match["personalityType"] ?>
                    </li>
                    <li>
                        <strong>OS:</strong>
                        <?= $match["os"] ?>
                    </li>
                </ul>
            </div>
        <?php
        }
    } else { // In case user is not found in file -- just nice despite it not being in the requirements.
        ?>
        <h1>User not found!</h1>
        <?php
    }
    ?>
<?php include("bottom.html"); ?>
