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

		<?php
			$filmInfoList = getFilmInfo($_GET["film"]);			
			$filmName = $filmInfoList[0];
			$filmYear = $filmInfoList[1];
			$filmScore = $filmInfoList[2];
		?>
		<h1 class="movie-title"><?= $filmName ?> (<?= $filmYear ?>) </h1>

		<!-- <h1 class="movie-title">TMNT (2007)</h1> -->
		
		<div class="overall-content-container">
			<div id="overview-container">
				<div>
					<img id="overview-img" src="overview.png" alt="general overview" />
				</div>
				<dl>
					<dt>STARRING</dt>
					<dd>Patrick Stewart <br /> Mako <br /> Sarah Michelle Gellar <br /> Kevin Smith</dd>
					<dt>DIRECTOR</dt>
					<dd>Kevin Munroe</dd>
					<dt>RATING</dt>
					<dd>PG</dd>
					<dt>THEATRICAL RELEASE</dt>
					<dd>Mar 23, 2007</dd>
					<dt>MOVIE SYNOPSIS</dt>
					<dd>After the defeat of their old arch nemesis, The Shredder, the Turtles have grown apart as a family.</dd>
					<dt>MPAA RATING</dt>
					<dd>PG, for animated action violence, some scary cartoon images and mild language</dd>
					<dt>RELEASE COMPANY</dt>
					<dd>Warner Bros.</dd>
					<dt>RUNTIME</dt>
					<dd>90 mins</dd>
					<dt>GENRE</dt>
					<dd>Action/Adventure, Comedies, Childrens, Martial Arts, Superheroes, Ninjas, Animated Characters</dd>
					<dt>BOX OFFICE</dt>
					<dd>$54,132,596</dd>
					<dt>LINKS</dt>
					<dd>
						<ul>
							<li><a href="https://www.teenagemutantninjaturtles.com/">TMNT Fan Site</a></li>
							<li><a href="http://www.rottentomatoes.com/m/teenage_mutant_ninja_turtles/">RT Review</a></li>
							<li><a href="http://www.rottentomatoes.com/">RT Home</a></li>
						</ul>
					</dd>
				</dl>
			</div>

			<div class="score-review-container">
				<div class="score-container">
					<img id="rotten-logo" src="rottenbig.png" alt="Rotten" />
					33%
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
 * @param  mixed $filmName
 * @return array
 */
function getFilmInfo(string $filmName): array {
	$fileInfoList = file("$filmName/info.txt");
	return $fileInfoList;
}
?>