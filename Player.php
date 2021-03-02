<?php

//require 'Deck.php';
//require 'Card.php';

class Player
{
    const BEST_VALUE = 21;
    private const MIN_START_CARDS = 2;
    private array $cards = [];
    protected bool $lost = false;

    public function hit(Deck $deck): void
    {
        $this->cards[] = $deck->drawCard();
        $this->lost = $this->getScore() > self::BEST_VALUE;
       /* $deck->drawCard();
        $this->getScore();
        if ($this->getScore() > self::BEST_VALUE) {
            $this->lost = true;
        }*/
    }


    public function surrender(): void
    {
        $this->lost = true;
    }

    public function getScore(): int
    {
        $total_score = 0;
        foreach ($this->cards as $card) {
            $total_score += $card->getValue();
        }
        return $total_score;
        //array_sum($this->cards[]);
    }

    /**
     * @return bool
     */
    public function isLost(): bool
    {
        return $this->lost;
    }


    public function hasLost(): bool
    {
        return $this->lost;
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    public function __construct(Deck $deck)
    {
        for ($i = 0; $i < self::MIN_START_CARDS; $i++) {
            $this->cards[] = $deck->drawCard();
        }
    }
}

class Dealer extends Player
{
    private const MIN_DEALER_VALUE = 15;

    public function hit($deck): void
    {
        while ($this->getScore() < self::MIN_DEALER_VALUE) {
            parent::hit($deck);

        }
        $this->lost = $this->getScore() > self::BEST_VALUE;
    }

}
