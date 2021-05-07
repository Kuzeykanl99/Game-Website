<?php
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/all_games.php";

	session_save_path("sess");
	session_start();

	$dbconn = db_connect();

	$errors=array();
	$view="";

	/* controller code */

	/* local actions, these are state transforms */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
		case "login":
			// the view we display by defaulte
			$view="login.php";
			
			include_once('view/checkGetRequest.php');

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user']))$errors[]='user is required';
			if(empty($_REQUEST['password']))$errors[]='password is required';
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1 and password=$2;";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array($_REQUEST['user'], hash('sha256', $_REQUEST['password'])));
			if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$_SESSION['user']=$_REQUEST['user'];
				$_SESSION['GuessGame']=new GuessGame();
				$_SESSION['RockPaperScissors']=new RockPaperScissors();
				$_SESSION['Frogs']=new Frogs();
				$_SESSION['profile'] = array($row["firstname"], $row["lastname"], $row["userid"], $row["gender"]);
				$_SESSION['state']='allStats';
				$view="allStats.php";
			} else {
				$errors[]="invalid login";
			}

			$query2 = "SELECT * FROM userStats WHERE userid=$1;";
			$result2 = pg_prepare($dbconn, "", $query2);
			$result2 = pg_execute($dbconn, "", array($_REQUEST['user']));
			if($row2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC)){
				$_SESSION['allStats']=array($row2['userid'], $row2['guessgame'], $row2['rockpaperscissors'], $row2['frogs']);
			}
			break;

		case "register":
			$view="register.php";

			include_once('view/checkGetRequest.php');

			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="Register"){
				break;
			}

			// validate and set errors
			if($_REQUEST['psw'] != $_REQUEST['psw-repeat'])$errors[]='Passwords do not match';
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			// connected to database
			$query = "SELECT * FROM appuser WHERE userid=$1;";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array($_REQUEST['username']));
			if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$errors[]="Username already exists";
			} else {
				$query = "INSERT into appuser (userid, password, firstname, lastname, gender) values ($1, $2, $3, $4, $5);";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_REQUEST['username'], hash('sha256', $_REQUEST['psw']), $_REQUEST['name'], $_REQUEST['lastname'], $_REQUEST['gender']));
				$_SESSION['user']=$_REQUEST['username'];
				$_SESSION['state']='login';
				$view="login.php";
			}

			$query2 = "INSERT into userStats (userid, guessGame, rockPaperScissors, frogs) values ($1, $2, $3, $4);";
			$result2 = pg_prepare($dbconn, "", $query2);
			$result2 = pg_execute($dbconn, "", array($_SESSION['user'], (int)0, (int)0, (int)0));
			$_SESSION['allStats']=array($_SESSION['user'], (int)0, (int)0, (int)0);

			break;

		case "allStats":
			$view="allStats.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			break;

		case "guessGame":
			$view="guessGame.php";
			
			// check for logout
			include_once('view/checkGetRequest.php');

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
				break;
			}

			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			if($_SESSION["GuessGame"]->getState()=="correct"){
				$_SESSION['allStats'][1]++;
				$query = "UPDATE userStats SET guessgame=guessgame+1 WHERE userid=$1;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_SESSION['user']));
				$_SESSION['state']="won_guessGame";
				$view="won_guessGame.php";
			}
			$_REQUEST['guess']="";

			break;
		
		case "won_guessGame":
			// the view we display by default
			$view="guessGame.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			// check if submit or not
			if(empty($_REQUEST['submit'])&&empty($_REQUEST['page'])){
				$errors[]="Invalid request";
				$view="won_guessGame.php";
			}

			// validate and set errors
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if($_REQUEST['page'] == "logout"){
				$_SESSION['state']="login";
				$view="login.php";
			} else if(empty($_REQUEST['submit']) && $_REQUEST['page'] != "logout") {
				$_SESSION["GuessGame"]=new GuessGame();
				$view=$_REQUEST['page'] . ".php";
			} else if($_REQUEST['submit']="start again"){
				$_SESSION["GuessGame"]=new GuessGame();
				$_SESSION['state']="guessGame";
				$view="guessGame.php";
			}

			break;

		case "rockPaperScissors":
			$view="rockPaperScissors.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="Play"){
				break;
			}

			// validate and set errors
			if($_REQUEST["rps"] != "Rock" && $_REQUEST["rps"] != "Paper" && $_REQUEST["rps"] != "Scissors") $errors[]="Invalid Input";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if($_REQUEST['rps']=="Rock") {
				$_SESSION["RockPaperScissors"]->makeGuess(1);
			} else if ($_REQUEST['rps']=="Paper") {
				$_SESSION["RockPaperScissors"]->makeGuess(2);
			} else if ($_REQUEST['rps']=="Scissors") {
                $_SESSION["RockPaperScissors"]->makeGuess(3);
            }
			
			if($_SESSION["RockPaperScissors"]->getState()=="You win"){
				$_SESSION['allStats'][2]++;
				$query = "UPDATE userStats SET rockpaperscissors=rockpaperscissors+1 WHERE userid=$1;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_SESSION['user']));
			}
			
			$_REQUEST['rps']="";

			break;

		case "frogs":
			$view="frogs.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			if(empty($_REQUEST['0']) && empty($_REQUEST['1']) && empty($_REQUEST['2']) && empty($_REQUEST['3']) 
			&& empty($_REQUEST['4']) && empty($_REQUEST['5']) && empty($_REQUEST['6']) && empty($_REQUEST['submit'])){
				break;
			}

			// perform operation, switching state and view if necessary
			if(isset($_REQUEST['0'])){
				$_SESSION["Frogs"]->clickOnFrog("0");
			} else if (isset($_REQUEST['1'])){
				$_SESSION["Frogs"]->clickOnFrog("1");
			} else if (isset($_REQUEST['2'])){
				$_SESSION["Frogs"]->clickOnFrog("2");
			} else if (isset($_REQUEST['3'])){
				$_SESSION["Frogs"]->clickOnFrog("3");
			} else if (isset($_REQUEST['4'])){
				$_SESSION["Frogs"]->clickOnFrog("4");
			} else if (isset($_REQUEST['5'])){
				$_SESSION["Frogs"]->clickOnFrog("5");
			} else if (isset($_REQUEST['6'])){
				$_SESSION["Frogs"]->clickOnFrog("6");
			} else if($_REQUEST['submit']="start again"){
				$_SESSION["Frogs"]=new Frogs();
				$_SESSION['state']="frogs";
				$view="frogs.php";
			}

			if($_SESSION["Frogs"]->getState()=="correct"){
				$_SESSION['allStats'][3]++;
				$query = "UPDATE userStats SET frogs=frogs+1 WHERE userid=$1;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_SESSION['user']));
				$_SESSION['state']="won_frogs";
				$view="won_frogs.php";
			}

			break;

		case "won_frogs":
			// the view we display by default
			$view="frogs.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			// check if submit or not
			if(empty($_REQUEST['0']) && empty($_REQUEST['1']) && empty($_REQUEST['2']) && empty($_REQUEST['3']) 
			&& empty($_REQUEST['4']) && empty($_REQUEST['5']) && empty($_REQUEST['6']) && empty($_REQUEST['page'])){
				$errors[]="Invalid request";
				$view="won_frogs.php";
			}

			// validate and set errors
			if(!empty($errors))break;


			// perform operation, switching state and view if necessary
			if($_REQUEST['page'] == "logout"){
				$_SESSION['state']="login";
				$view="login.php";
			} else if(empty($_REQUEST['0']) && empty($_REQUEST['1']) && empty($_REQUEST['2']) && empty($_REQUEST['3']) 
			&& empty($_REQUEST['4']) && empty($_REQUEST['5']) && empty($_REQUEST['6'])) {
				$_SESSION["Frogs"]=new Frogs();
				$view=$_REQUEST['page'] . ".php";
			} else if($_REQUEST['submit']="start again"){
				$_SESSION["Frogs"]=new Frogs();
				$_SESSION['state']="frogs";
				$view="frogs.php";
			}

			break;	

		case "profile":
			$view="profile.php";

			// check for logout
			include_once('view/checkGetRequest.php');

			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			// connected to database
			$_SESSION['newpsw'] = false;
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="Change Password"){
				break;
			}

			if($_REQUEST['new-psw'] != $_REQUEST['new-psw-2']){
				$errors[]='Passwords do not match';
			} else {
				$query = "UPDATE appuser SET password=$1 WHERE userid=$2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array(hash('sha256', $_REQUEST['new-psw']), $_SESSION['user']));
				$_SESSION['newpsw'] = true;
			}	

			break;
	}
	require_once "view/$view";
?>