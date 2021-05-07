<?php
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games</title>
	</head>
	<body>
		<header>
            <?php include_once('nav.php'); ?>
		</header>
		<main>
			<section class='game'>
				<h1 class='profile'>Stats By Game</h1>
					<p>Username: <?php echo($_SESSION['allStats'][0])?></p>
					<p>Guess Game Score: <?php echo($_SESSION['allStats'][1])?></p>
					<p>Rock Paper Scissors Score: <?php echo($_SESSION['allStats'][2])?></p>
					<p>Frogs Score: <?php echo($_SESSION['allStats'][3])?></p>
			</section>
		</main>
		<footer>
			<br>A project by Kuzey Kanlikilicer
		</footer>
	</body>
</html>