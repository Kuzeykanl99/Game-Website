<?php
	// So I don't have to deal with uninitialized $_REQUEST['guess']
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
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
				<h1>Welcome to Frogs Puzzle</h1>
				<?php echo(view_errors($errors)); ?>
				<?php 
					foreach($_SESSION['Frogs']->history as $key=>$value){
						echo("<br/> $value");
					}
				?>
				<form method="post">
					<input type="submit" name="submit" value="start again"/>
				</form>
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				<p>Frogs Score: <?php echo($_SESSION['allStats'][3])?></p>
			</section>
		</main>
		<footer>
			<br>A project by Kuzey Kanlikilicer
		</footer>
	</body>
</html>