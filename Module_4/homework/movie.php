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

				<!-- General Overview info, build a key:value map of term:definition. -->
				<?php
					$generalOverviewInfoMap = buildFilmGeneralOverviewMap($filmQueryParam);
				?>
				<dl>
				<?php
					foreach ($generalOverviewInfoMap as $infoKey => $infoVal) {
				?>
						<dt><?= $infoKey ?></dt>
						<dd><?= $generalOverviewInfoMap[$infoKey] ?></dd>
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
		$term = $splitInfo[0];
		$definition = $splitInfo[1];
		$overviewMap[$term] = $definition;
	}
	return $overviewMap;
}
?>