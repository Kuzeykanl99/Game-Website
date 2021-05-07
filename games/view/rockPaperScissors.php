<?php
	// So I don't have to deal with uninitialized $_REQUEST['rps']
	$_REQUEST['rps']=!empty($_REQUEST['rps']) ? $_REQUEST['rps'] : '';
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
				<h1>Welcome to Rock Paper Scissors</h1>
				<?php if($_SESSION["RockPaperScissors"]->getState()!="correct"){ ?>
					<form method="post">
						<input type="text" name="rps" value="<?php echo($_REQUEST['rps']); ?>" autofocus/> <input type="submit" name="submit" value="Play" />
						<p>Type Rock, Paper or Scissors</p>
					</form>
				<?php } ?>
				
				<?php echo(view_errors($errors)); ?> 

				<?php 
					foreach($_SESSION["RockPaperScissors"]->history as $key=>$value){
						echo("<br/> $value");
					}
					if($_SESSION["RockPaperScissors"]->getState()=="correct"){ 
				?>
					<form method="post">
						<input type="submit" name="submit" value="start again" />
					</form>
				<?php 
					} 
				?>
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				<p>Rock Paper Scissors Score: <?php echo($_SESSION['allStats'][2])?></p>
			</section>
		</main>
		<footer>
			<br>A project by Kuzey Kanlikilicer
		</footer>
	</body>
</html>