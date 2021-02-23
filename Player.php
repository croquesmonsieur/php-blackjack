<?php

//require 'Deck.php';
//require 'Card.php';

class Player
{
    private const BEST_VALUE = 21;
    private array $cards = [];
    private bool $lost = false;

    public function hit(Deck $deck): void
    {
        $deck->drawCard();
        $this->getScore();
        if ($this->getScore() > self::BEST_VALUE) {
            $this->lost = true;
        }
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

    public function hasLost(): bool
    {
        return $this->lost;
    }

    public function __construct(Deck $deck)
    {
        for ($i = 0; $i < 2; $i++) {
            $this->cards[] = $deck->drawCard();
        }
    }
}
