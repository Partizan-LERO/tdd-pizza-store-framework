<?php


namespace App;


class Product
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $price;

    public function __construct(string $title, float $price)
    {
        $this->title = $title;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param  float  $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
