<?php
    $_REQUEST['new-psw']=!empty($_REQUEST['new-psw']) ? $_REQUEST['new-psw'] : '';
    $_REQUEST['new-psw-2']=!empty($_REQUEST['new-psw-2']) ? $_REQUEST['new-psw-2'] : '';
    $_REQUEST['profile']=!empty($_REQUEST['profile']) ? $_REQUEST['profile'] : '';
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
				<h1 class='profile'>Profile</h1>
				<div class="card">
                    <h3><?php echo($_SESSION['profile'][0] . " " . $_SESSION['profile'][1])?></h3>
                    <p>Username: <?php echo($_SESSION['profile'][2]) ?></p>
                    <p>Gender: <?php echo($_SESSION['profile'][3]) ?></p>
                    
                    <form method="post">
                        <input type="password" placeholder="Enter New Password" name="new-psw" value="<?php echo($_REQUEST['new-psw']);?>" required/>
                        <input type="password" placeholder="Repeat New Password" name="new-psw-2" value="<?php echo($_REQUEST['new-psw-2']);?>" required/><br>
                        <input type="submit" name="submit" value="Change Password" />
                        <?php if(isset($_SESSION['newpsw'])){if($_SESSION['newpsw'])echo("Password Changed");} ?>
                        <?php echo(view_errors($errors)); ?><br>
                    </form>
                </div>
			</section>
		</main>
		<footer>
			<br>A project by Kuzey Kanlikilicer
		</footer>
	</body>
</html>