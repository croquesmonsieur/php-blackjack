<?php
declare(strict_types=1);

require 'Card.php';
require 'Player.php';
require 'Blackjack.php';
require 'Deck.php';
require 'Suit.php';
session_start();


if (!isset($_SESSION['Blackjack'])) {
    $_SESSION['Blackjack'] = new Blackjack();
}
$blacky = $_SESSION['Blackjack'];
$player = $_SESSION['Blackjack']->getPlayer();
$dealer = $_SESSION['Blackjack']->getDealer();
const TWENTY_ONE = 21;

function whoWin($player, $dealer){
    if(($player->getScore() ==  TWENTY_ONE && $dealer->getScore() == TWENTY_ONE) || $dealer->getScore() == TWENTY_ONE){
        $player->surrender();
        echo "You lost!";
    } elseif ($player->getScore() > $dealer->getScore() || $player->getScore() == TWENTY_ONE){
        $dealer->haslost(true);
        echo "You won!";
    } else {
        $player->surrender();
        echo "You lost!";
    }
}


if (isset($_POST['start']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    echo "You start with " . $player->getScore() . " " . $blacky->showHandPlayer();
    echo "The dealer starts with " . $dealer->getScore() . " " . $blacky->showHandDealer();

    if (isset($_POST['hit'])) {
        $player->hit($blacky->getDeck());
        echo "You have " . $player->getScore();
        if($player->isLost() == true){
            whoWin($player, $dealer);
        }
    }

    if (isset($_POST['stand'])) {
        $dealer->hit($blacky->getDeck());
        echo "The dealer has " . $dealer->getScore();
        whoWin($player, $dealer);
    }

    if(isset($_POST['surrender'])){
        $dealer->hasLost();
        echo "You lose with " . $blacky->showHandPlayer() . "! The dealer has " . $blacky->showHandDealer();
        unset($blacky);
    }

}


function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

whatIsHappening();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blackjack game</title>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <div class="cards">
        <?php //echo $blacky->showHandPlayer() . $blacky->showHandDealer(); ?>
    </div>
    <div>
        <label>Hit me</label>
        <input type="button" name="hit"/>
        <label>Stand</label>
        <input type="button" name="stand"/>
        <label>Surrender</label>
        <input type="button" name="surrender"/>
        <label>Start Game</label>
        <input type="button" name="start"/>
    </div>
</form>
</body>
</html>

