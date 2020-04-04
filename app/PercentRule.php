<?php


namespace App;


class PercentRule implements Rule
{
    /**
     * @var int
     */
    private $percent;

    /**
     * @var array
     */
    private $items;


    public function __construct($percent, $items)
    {
        $this->percent = $percent;
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return $this->percent;
    }

    /**
     * @param  int  $percent
     */
    public function setPercent(int $percent): void
    {
        $this->percent = $percent;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param  array  $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function recalculate(Cart $cart)
    {
        $price = 0.0;

        if ($this->items === ['*']) {
            $cartPrice = Calculator::getSummedPrice($cart);
            $price = $cartPrice - $cartPrice * ($this->percent / 100);
        } else {
            foreach ($cart->get() as $item) {
                foreach ($this->items as $campaignItem) {
                    $itemPrice = $item->getProduct()->getPrice();
                    if ($item->getProduct() === $campaignItem) {
                        $price +=  $itemPrice * $item->getCount() - $itemPrice * $item->getCount() * $this->percent / 100;
                    } else {
                        $price += $itemPrice * $item->getCount();
                    }
                }

            }
        }

        return $price;
    }
}
