<?php


class Blackjack
{
    private Player $player;
    private Dealer $dealer;
    private Deck $deck;

    public function __construct()
    {
        $this->deck = new Deck;
        $this->deck->shuffle();
        $this->player = new Player($this->getDeck());
        $this->dealer = new Dealer($this->getDeck());
    }

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

    public function showHandPlayer(): void {
        foreach ($this->player->getCards() as $card) {
            echo $card->getUnicodeCharacter(true);
        }
    }
    public function showHandDealer(): void {
        foreach ($this->dealer->getCards() as $card) {
            echo $card->getUnicodeCharacter(true);
        }
    }




}