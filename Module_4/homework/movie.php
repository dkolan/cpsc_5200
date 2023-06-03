<!DOCTYPE html>
<html>
	<!-- Get the film info from the query param's corresponding info.txt -->
	<?php
		$filmQueryParam = $_GET["film"];
		$filmInfoList = getFilmInfo($filmQueryParam);			
		$filmName = trim($filmInfoList[0]);
		$filmYear = trim($filmInfoList[1]);
		$filmScore = trim($filmInfoList[2]);
	?>
	<head>
		<title><?= $filmName ?> - Rancid Tomatoes</title>

		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
		<link rel="icon" type="image/x-icon" href="rotten.gif">
	</head>

	<body>
		<div id="banner-top">
			<img src="banner.png" alt="Rancid Tomatoes" />
		</div>
	
		<h1 class="movie-title"><?= $filmName ?> (<?= $filmYear?>) </h1>
		
		<div class="overall-content-container">
			<div id="overview-container">
				<div>
					<!-- Assign image based on filmQueryParam -->
					<img id="overview-img" src=<?= "$filmQueryParam/overview.png" ?> alt="general overview" />
				</div>

				<!-- General Overview info, build a key:value map of term:definition. -->
				<?php
					$generalOverviewInfoMap = buildFilmGeneralOverviewMap($filmQueryParam);
				?>
				<dl>
				<!-- Iterate over general overview data and render terms/definitions -->
				<?php
					foreach ($generalOverviewInfoMap as $infoKey => $infoVal) {
				?>
						<dt><?= $infoKey ?></dt>
						<dd><?= $generalOverviewInfoMap[$infoKey] ?></dd>
				<?php
					}
				?>
				</dl>
			</div>

			<div class="score-review-container">
				<div class="score-container">
					<!-- Assign the score logo depending on whether the score is Rotten (<60) or Fresh (>= 60) -->
					<img id="rotten-logo" src=<?= ($filmScore < 60) ? "rottenbig.png" : "freshbig.png" ?> alt="Rotten" />
					<span id="avg-rating"><?= $filmScore ?>%</span>
				</div>
				
				<?php					
					// Get list of review files
					$reviewFileList = glob($filmQueryParam . "/review*");

					// Calculate # of reviews in left column (-1 to account for 0 indexing)
					$leftColReviewCount = ceil(count($reviewFileList)/2) - 1;

					?>
					<div class="review-container">
						<div class="review-column">
					<?php

					// Loop through review file list
					// If $i > $leftColReviewCount, belongs in right col, else left
					for($i = 0; $i < count($reviewFileList); $i++) {

						// Reviews have exactly 4 lines: review, fresh/rotten, name, publication
						$reviewFileLines = file($reviewFileList[$i]);
						$reviewText = trim($reviewFileLines[0]);
						$freshOrRotten = trim($reviewFileLines[1]);
						$criticName = trim($reviewFileLines[2]);
						$criticPublication = trim($reviewFileLines[3]);
						?>

							<div class="review">
								<p class="review-paragraph">
									<!-- Set review fresh/rotten image and review text, critic, and publication -->
									<img src=<?= (strcasecmp($freshOrRotten, "FRESH") == 0) ? "fresh.gif" : "rotten.gif" ?> 
										alt=<?= (strcasecmp($freshOrRotten, "FRESH") == 0) ? "Fresh" : "Rotten" ?> />  
									<q><?= $reviewText ?></q>
								</p>
								<p class="review-author">
									<img src="critic.gif" alt="Critic" />
									<?= $criticName ?> <br />
									<?= $criticPublication ?>
								</p>
							</div>
						
						<?php
						// If left column amount reached, make next column div
						if($i == $leftColReviewCount) {
							?>
						</div>
						<div class="review-column">
							<?php
						}
					}
					?>
						</div>
					</div>
					<?php
				?>
			</div>
			<div class="page-count-container">
				<p class="page-count-text">(1-10) of 88</p>
			</div>
		</div>

	</body>
</html>

<?php

/**
 * getFilmInfo
 * 
 * Returns the info.txt for the corresponding filmName.
 * 
 * @param  mixed $filmName = name of the film/url film query param
 * @return array
 */
function getFilmInfo($filmName) {
	$fileInfoList = file("$filmName/info.txt");
	return $fileInfoList;
}

/**
 * buildFilmGeneralOverviewMap
 * 
 * Returns a key value map of the headers and info from overview.txt
 *
 * @param  mixed $filmName = name of the film/url film query parame
 * @return array A k:v map of the headers (key) and info (values) in the general overview section
 */
 function buildFilmGeneralOverviewMap($filmName) {
	$overviewInfoList = file("$filmName/overview.txt");
	$overviewMap = array();
	foreach ($overviewInfoList as $info) {
		$splitInfo = explode(":", $info);
		$term = $splitInfo[0];
		$definition = $splitInfo[1];
		$overviewMap[$term] = $definition;
	}
	return $overviewMap;
}
?>