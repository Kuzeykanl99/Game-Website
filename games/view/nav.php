<!DOCTYPE html>
<html lang="en">
<html>
    <body>
        <nav>
            <a href="index.php?page=allStats" class="<?php if ($_SESSION['state']=='allStats') {echo "active-page"; } else  {echo "noactive";}?>">All Stats</a>
            <a href="index.php?page=guessGame" class="<?php if ($_SESSION['state']=='guessGame' || $_SESSION['state']=='won_guessGame') {echo "active-page"; } else  {echo "noactive";}?>">Guess Game</a> 
            <a href="index.php?page=rockPaperScissors" class="<?php if ($_SESSION['state']=='rockPaperScissors') {echo "active-page"; } else  {echo "noactive";}?>">Rock Paper Scissors</a> 
            <a href="index.php?page=frogs" class="<?php if ($_SESSION['state']=='frogs' || $_SESSION['state']=='won_frogs') {echo "active-page"; } else  {echo "noactive";}?>">Frogs</a> 
            <a href="index.php?page=profile" class="<?php if ($_SESSION['state']=='profile') {echo "active-page"; } else  {echo "noactive";}?>">Profile</a> 
            <a href="index.php?page=logout">Logout</a>
        </nav>
    </body>
</html>