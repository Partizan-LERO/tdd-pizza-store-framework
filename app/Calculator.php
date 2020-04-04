<?php


namespace app;


class Calculator
{
    /**
     * @param  Cart  $cart
     * @return float
     */
    public static function getSummedPrice(Cart $cart): float
    {
        $price = 0.0;
        foreach ($cart->get() as $index => $item) {
            $price += $item->getProduct()->getPrice() * $item->getCount();
        }

        return $price;
    }
}
