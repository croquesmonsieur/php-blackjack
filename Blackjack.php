<?php


class Blackjack
{
private Player $player;
private Player $dealer;
private Deck $deck;

    /**
     * @return string
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getDealer(): Player
    {
        return $this->dealer;
    }

    /**
     * @return string
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }

public function __construct(){
$this->player = new Player($this->getDeck());
$this->dealer = new Player($this->getDeck());
$this->deck = new Deck;

$this->deck->shuffle();

}

}