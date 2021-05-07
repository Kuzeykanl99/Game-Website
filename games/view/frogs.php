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
				<?php if($_SESSION["Frogs"]->getState()!="correct"){ ?>
					<form method="post" class="frogs">
						<input type="submit" name="0" value="<?php echo($_SESSION['Frogs']->getPosition()[0]); ?>"/>
                        <input type="submit" name="1" value="<?php echo($_SESSION['Frogs']->getPosition()[1]); ?>"/>
                        <input type="submit" name="2" value="<?php echo($_SESSION['Frogs']->getPosition()[2]); ?>"/>
                        <input type="submit" name="3" value="<?php echo($_SESSION['Frogs']->getPosition()[3]); ?>"/>
                        <input type="submit" name="4" value="<?php echo($_SESSION['Frogs']->getPosition()[4]); ?>"/>
                        <input type="submit" name="5" value="<?php echo($_SESSION['Frogs']->getPosition()[5]); ?>"/>
                        <input type="submit" name="6" value="<?php echo($_SESSION['Frogs']->getPosition()[6]); ?>"/>
					</form>
				<?php } ?>
				
				<?php echo(view_errors($errors)); ?> 

				<?php 
					foreach($_SESSION['Frogs']->history as $key=>$value){
						echo("<br/> $value");
					}
					if($_SESSION["Frogs"]->getState()=="correct"){ 
				?>
                    <form method="post">
                        <input type="submit" name="submit" value="start again" />
                    </form>
				<?php 
					} 
				?>

				<form method="post">
					<input type="submit" name="submit" value="start again" />
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