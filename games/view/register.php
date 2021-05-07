<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
// You can also take a look at the new ?? operator in PHP7

$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
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
		</header>
		<main>
			<section>
                <form action="index.php" method="post">
                    <div class="container">
                        <h1>Register</h1>
                        <p>Please fill in this form to create an account.</p>
                        <hr>
                        <input type="text" placeholder="Name" name="name" id="name" required>
                        <input type="text" placeholder="Lastname" name="lastname" id="lastname" required>
                        <input type="text" placeholder="Enter Username" name="username" id="username" required>
                        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required><br>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label><br>
                        <input type="radio" id="female" name="gender" value="female" checked="checked">
                        <label for="female">Female</label><br>
                        <input type="radio" id="other" name="gender" value="other">
                        <label for="other">Other</label><br><br>

                        <hr>
                        <?php echo(view_errors($errors)); ?><br>
                        <input type="submit" name="submit" value="Register"/>
                        
                    </div>

                    <div class="container signin">
                        <p>Already have an account? <a href="index.php?page=login" class="signIn">Sign in</a>.</p>
                    </div>
                </form>
			</section>
			<section>
			</section>
		</main>
		<footer>
			A project by Kuzey Kanlikilicer
		</footer>
	</body>
</html>