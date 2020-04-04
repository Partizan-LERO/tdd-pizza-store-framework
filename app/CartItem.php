<?php


namespace App;


class CartItem
{
    /**
     * @var int
     */
    private $count;

    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product, $count = 1)
    {
        $this->product = $product;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function increment()
    {
        $this->count++;
    }
}
