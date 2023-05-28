<!DOCTYPE html>
<html>
	<head>
		<title>TMNT - Rancid Tomatoes</title>

		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
		<link rel="icon" type="image/x-icon" href="rotten.gif">
	</head>

	<body>
		<div id="banner-top">
			<img id="banner-logo" src="banner.png" alt="Rancid Tomatoes" />
		</div>
	
		<!-- Get the film info from the query param's corresponding info.txt -->
		<?php
			$filmQueryParam = $_GET["film"];
			$filmInfoList = getFilmInfo($filmQueryParam);			
			$filmName = trim($filmInfoList[0]);
			$filmYear = trim($filmInfoList[1]);
			$filmScore = trim($filmInfoList[2]);
		?>

		<h1 class="movie-title"><?= $filmName ?> (<?= $filmYear?>) </h1>
		
		<div class="overall-content-container">
			<div id="overview-container">
				<div>
					<!-- Assign image based on filmQueryParam -->
					<img id="overview-img" src=<?= "$filmQueryParam/overview.png" ?> alt="general overview" />
				</div>

				<!-- General Overview info -->
				<?php
					$generalOverviewInfoMap = buildFilmGeneralOverviewMap($filmQueryParam);
				?>
				<dl>
					<?php
						foreach ($generalOverviewInfoMap as $infoKey => $infoVal) {
							$term = $infoKey;
							$description = "";
							if (is_array($generalOverviewInfoMap[$infoKey])) {
								foreach ($generalOverviewInfoMap[$infoKey] as $descValue) {
									$description = $description.trim($descValue)."<br/>";
								}
							} else {
								$description = $generalOverviewInfoMap[$infoKey];
							}
							error_log(print_r($description, TRUE)); 
					?>
							<dt><?= $term ?></dt>
							<dd><?= $description ?></dd>
					<?php
						}
					?>
					<br	/>
				</dl>
			</div>

			<div class="score-review-container">
				<div class="score-container">
					<!-- Assign the score logo depending on whether the score is Rotten (<60) or Fresh (>= 60) -->
					<img id="rotten-logo" src=<?= ($filmScore < 60) ? "rottenbig.png" : "freshbig.png" ?> alt="Rotten" />
					<?= $filmScore ?>%
				</div>
				
				<div class="review-column-left">
					<div class="review">
						<p class="review-paragraph">
							<img src="rotten.gif" alt="Rotten" />
							<q>Ditching the cheeky, self-aware wink that helped to excuse the concept's inherent corniness, the movie attempts to look polished and 'cool,' but the been-there animation can't compete with the then-cutting-edge puppetry of the 1990 live-action movie.</q>
						</p>
						<p class="review-author">
							<img src="critic.gif" alt="Critic" />
							Peter Debruge <br />
							Variety
						</p>
					</div>
					<div class="review">
						<p class="review-paragraph">
							<img src="fresh.gif" alt="Fresh" />
							<q>TMNT is a fun, action-filled adventure that will satisfy longtime fans and generate a legion of new ones.</q>
						</p>
						<p class="review-author">
							<img src="critic.gif" alt="Critic" />
							Todd Gilchrist <br />
							IGN Movies
						</p>
					</div>
					<div class="review">
						<p class="review-paragraph">
							<img src="rotten.gif" alt="Rotten" />
							<q>It stinks!</q>
						</p>
						<p class="review-author">
							<img src="critic.gif" alt="Critic" />
							Jay Sherman (unemployed)
						</p>
					</div>
					<div class="review">
						<p class="review-paragraph">
							<img src="rotten.gif" alt="Rotten" />
							<q>The rubber suits are gone and they've been redone with fancy computer technology, but that hasn't stopped them from becoming dull.</q>
						</p>
						<p class="review-author">
							<img src="critic.gif" alt="Critic" />
							Joshua Tyler <br />
							CinemaBlend.com
						</p>
					</div>
					<div class="review">
						<p class="review-paragraph">
							<img src="rotten.gif" alt="Rotten" />
							<q>Brings us all together in paralyzing boredom.</q>
						</p>
						<p class="review-author">
							<img src="critic.gif" alt="Critic" />
							Roger Ebert <br />
							Chicago Sun Times
						</p>
					</div>
				</div>
					<div class="review-column-right">
						<div class="review">
							<p class="review-paragraph">
								<img src="rotten.gif" alt="Rotten" />
								<q>The turtles themselves may look prettier, but are no smarter; torn irreparably from their countercultural roots, our superheroes on the half shell have been firmly co-opted by the industry their creators once sought to spoof.</q>
							</p>
							<p class="review-author">
								<img src="critic.gif" alt="Critic" />
								Jeannette Catsoulis <br />
								New York Times
							</p>
						</div>
						<div class="review">
							<p class="review-paragraph">
								<img src="rotten.gif" alt="Rotten" />
								<q>Impersonally animated and arbitrarily plotted, the story appears to have been made up as the filmmakers went along.</q>
							</p>
							<p class="review-author">
								<img src="critic.gif" alt="Critic" />
								Ed Gonzalez <br />
								Slant Magazine
							</p>
						</div>
						<div class="review">
							<p class="review-paragraph">
								<img src="fresh.gif" alt="Fresh" />
								<q>The striking use of image and motion allows each sequence to leave an impression. It's an accomplished restart to this franchise.</q>
							</p>
							<p class="review-author">
								<img src="critic.gif" alt="Critic" />
								Mark Palermo <br />
								Coast (Halifax, Nova Scotia)
							</p>
						</div>
						<div class="review">
							<p class="review-paragraph">
								<img src="rotten.gif" alt="Rotten" />
								<q>The script feels like it was computer generated. This mechanical presentation lacks the cheesy charm of the three live action films.</q>
							</p>
							<p class="review-author">
								<img src="critic.gif" alt="Critic" />
								Steve Rhodes <br />
								Internet Reviews
							</p>
						</div>
						<div class="review">
							<p class="review-paragraph">
								<img src="rotten.gif" alt="Rotten" />
								<q>Is this film more interesting than a documentary of the same actors having lunch?</q>
							</p>
							<p class="review-author">
								<img src="critic.gif" alt="Critic" />
								Gene Siskel <br />
								Chicago Tribune
							</p>
						</div>
					</div>
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
function getFilmInfo(string $filmName): array {
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
function buildFilmGeneralOverviewMap(string $filmName): array {
	$overviewInfoList = file("$filmName/overview.txt");
	$overviewMap = array();
	foreach ($overviewInfoList as $info) {
		$splitInfo = explode(":", $info);
		$category = $splitInfo[0];
		switch ($category) {
			case "STARRING":
				// Account for films like tmnt with line break delimiter 
				if (str_contains($splitInfo[1], "<br />")) {
					$castList = explode("<br />", $splitInfo[1]);
				} else { // Comma delimited
					$castList = explode(",", $splitInfo[1]);
				}
				$overviewMap["STARRING"] = $castList;
				break;
			case "DIRECTOR":
				$director = explode(",", $splitInfo[1]);
				$overviewMap["DIRECTOR"] = $director;
				break;
			case "PRODUCER":
				$producer = explode(",", $splitInfo[1]);
				$category = count($producer) > 1 ? "PRODUCERS" : "PRODUCER";
				$overviewMap["PRODUCER"] = $producer;
				break; 
			case "SCREENWRITER":
				$screenwriter = explode(",", $splitInfo[1]);
				$category = count($screenwriter) > 1 ? "SCREENWRITERS" : "SCREENWRITER";
				$overviewMap["SCREENWRITER"] = $screenwriter;
				break; 
			case "RATING":
				$ratingHeader = "RATING";
				$ratingsList = array("G", "PG", "PG-13", "R", "NC-17");
				$ratingText = "";
				foreach ($ratingsList as $rating) {
					if (str_contains($splitInfo[1], $rating)) {
						$ratingText = $splitInfo[1];
					}
				}
				$overviewMap[$ratingHeader] = $ratingText;
				break;
			case "MPAA RATING":
				$mpaaRatingHeader = "MPAA RATING";	
				$mpaaRatingsList = array("G", "PG", "PG-13", "R", "NC-17");
				$mpaaRating = "";
				foreach ($mpaaRatingsList as $rating) {
					if (str_contains($splitInfo[1], $rating)) {
						$mpaaRating = $splitInfo[1];
					}
				}
				$overviewMap[$mpaaRatingHeader] = $mpaaRating;
				break;
			case "ESRB RATING":
				$esrbRatingHeader = "ESRB RATING";
				$esrbRatingsList = array("RP", "E", "E10+", "T", "M", "AO");
				$esrbRating = "";
				foreach ($esrbRatingsList as $rating) {
					if (str_contains($splitInfo[1], $rating)) {
						$esrbRating = $splitInfo[1];
					}
				}
				$overviewMap[$esrbRatingHeader] = $esrbRating;
				break;
			case "THEATRICAL RELEASE":
				$theatricalReleaseHeader = "THEATRICAL RELEASE";
				$overviewMap[$theatricalReleaseHeader] = $splitInfo[1];
				break;
			case "RELEASE DATE":
				$releaseHeader = "RELEASE DATE";	
				$overviewMap[$releaseHeader] = $splitInfo[1];
				break;
			case "MOVIE SYNOPSIS":
				$movieSynopsisHeader = "MOVIE SYNOPSIS";
				$overviewMap[$movieSynopsisHeader] = $splitInfo[1];
				break;
			case "SYNOPSIS":
				$synopsisHeader = "SYNOPSIS";	
				$overviewMap[$synopsisHeader] = $splitInfo[1];
				break;
			case "SUBTITLE":
				$subtitleHeader = "SUBTITLE";	
				$overviewMap[$subtitleHeader] = $splitInfo[1];
				break;
			case "RELEASE COMPANY":
				$releaseCompanyHeader = "RELEASE COMPANY";	
				$overviewMap[$releaseCompanyHeader] = $splitInfo[1];
				break;
			case "DISTRIBUTORS":
				$distributorsHeader = "DISTRIBUTORS";	
				$overviewMap[$distributorsHeader] = $splitInfo[1];
				break;
			case "RUNTIME":
				$runtimeHeader = "RUNTIME";	
				$overviewMap[$runtimeHeader] = $splitInfo[1];
				break;
			case "GENRE":
				$genreHeader = "GENRE";	
				$overviewMap[$genreHeader] = $splitInfo[1];
				break;
			case "EXECUTIVE PRODUCER":
				$executiveProduverHeader = "EXECUTIVE PRODUCER";	
				$overviewMap[$executiveProduverHeader] = $splitInfo[1];
				break;
			case "LIGHTING AND SPECIAL EFFECTS":
				$lightingSpecialEffectsHeader = "LIGHTING AND SPECIAL EFFECTS";	
				$overviewMap[$lightingSpecialEffectsHeader] = $splitInfo[1];
				break;
			case "BOX OFFICE":
				$boxOfficeHeader = "BOX OFFICE";	
				$overviewMap[$boxOfficeHeader] = $splitInfo[1];
				break;
			case "LINKS":
				$linksHeader = "LINKS";	
				$overviewMap[$linksHeader] = $splitInfo[1];
				break;
		}
	}
	// error_log(print_r($overviewMap, TRUE)); 
	return $overviewMap;
}
?>