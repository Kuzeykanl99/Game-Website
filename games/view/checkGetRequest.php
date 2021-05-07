<?php
if (isset($_REQUEST['page'])) {
    if ($_REQUEST['page'] == "logout") {
        session_destroy();
        $_SESSION['state']="login";
        $view="login.php";
    } else if ($_REQUEST['page'] == "allStats") {
        $_SESSION['state']="allStats";
        $view="allStats.php";
    } else if ($_REQUEST['page'] == "guessGame") {
        $_SESSION['state']="guessGame";
        $view="guessGame.php";
    } else if ($_REQUEST['page'] == "rockPaperScissors") {
        $_SESSION['state']="rockPaperScissors";
        $view="rockPaperScissors.php";
    } else if ($_REQUEST['page'] == "frogs") {
        $_SESSION['state']="frogs";
        $view="frogs.php";
    } else if ($_REQUEST['page'] == "profile") {
        $_SESSION['state']="profile";
        $view="profile.php";
    } else if ($_REQUEST['page'] == "register") {
        $_SESSION['state']="register";
        $view="register.php";
    } else if ($_REQUEST['page'] == "login") {
        $_SESSION['state']="login";
        $view="login.php";
    }
}
?>