<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Card.php';
require 'Player.php';
require 'Blackjack.php';
require 'Deck.php';
require 'Suit.php';
session_start();

const TWENTY_ONE = 21;

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

/*
function whoWins($player, $dealer)
{
    if (($player->getScore() == TWENTY_ONE && $dealer->getScore() == TWENTY_ONE) || $dealer->getScore() == TWENTY_ONE) {
        $player->surrender();
        echo "You lost!";
    } elseif ($player->getScore() > $dealer->getScore() || $player->getScore() == TWENTY_ONE) {
        $dealer->hasLost();
        echo "You won!";
    } else {
        $player->surrender();
        echo "You lost!";
    }
}*/


if (!isset($_SESSION['Blackjack'])) {
    $_SESSION['Blackjack'] = new Blackjack();
}

$blacky = $_SESSION['Blackjack'];
$player = $_SESSION['Blackjack']->getPlayer();
$dealer = $_SESSION['Blackjack']->getDealer();

if (isset($_POST['action'])){
    switch ($_POST['action']){
        case 'hit':
            $player->hit($blacky->getDeck());
            if ($player->hasLost()){
                $winner = 'Dealer!';
            }
            break;
        case 'stand':
            $dealer->hit($blacky->getDeck());
            if ($player->hasLost()){
                $winner = 'Dealer!';
            } elseif ($dealer->hasLost()){
                $winner = "Player!";
            } elseif ($dealer->getScore() >= $player->getScore()){
                $winner = "Dealer!";
            } else {
                $winner = "Player!";
            }
            break;
        case 'surrender':
            $player->surrender();
            $winner = "Dealer";
            break;
        case 'start':
            session_destroy();
            header('location: index.php');
            exit;
        default:
            die(sprintf('Something happened, unknown action %s', $_POST['action']));
    }

}
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
<?php
if (isset($winner)):{
    echo "<h2>" . "The winner is " . $winner . "</h2>";
}

/* if (isset($_POST['start']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    echo "You start with " . $player->getScore() . " " . $blacky->showHandPlayer();
    echo "The dealer starts with " . $dealer->getScore() . " " . $blacky->showHandDealer();

    if (isset($_POST['hit'])) {
        $player->hit($blacky->getDeck());
        echo "You have " . $player->getScore();
        if ($player->isLost() == true) {
            whoWins($player, $dealer);
        }
    }

    if (isset($_POST['stand'])) {
        $dealer->hit($blacky->getDeck());
        echo "The dealer has " . $dealer->getScore();
        whoWins($player, $dealer);
    }

    if (isset($_POST['surrender'])) {
        $dealer->hasLost();
        echo "You lose with " . $blacky->showHandPlayer() . "! The dealer has " . $blacky->showHandDealer();

    }

}*/
?>
<?php endif ?>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <div class="player">
        <h3>Player's Cards</h3>
        <?php echo $blacky->showHandPlayer();  ?>
    </div>
    <div class="dealer">
        <h3>Dealer's Cards</h3>
        <?php echo $blacky->showHandDealer(); ?>
    </div>
    <fieldset>
        <button type="submit" name="action" value="hit">Hit me!</button>
        <button type="submit" name="action" value="stand">Stand!</button>
        <button type="submit" name="action" value="surrender">Surrender!</button>
        <button type="submit" name="action" value="start">Start Game</button>
    </fieldset>
    <div>
        <h3>The Score</h3>
        <h4>Player's:<?php echo $player->getScore(); ?></h4>
        <h4>Dealer's:<?php echo $dealer->getScore(); ?></h4>
    </div>
</form>
</body>
</html>

