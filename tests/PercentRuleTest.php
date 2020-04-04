<?php


namespace tests;


use App\Cart;
use App\CartItem;
use App\PercentRule;
use App\Product;
use App\PromoCode;
use App\PromoCodeObserver;

class PercentRuleTest extends TestCase
{

    public function testSuccessCart()
    {
        $pizza = new Product('Pizza', 20);
        $pizzaItem = new CartItem($pizza, 5);
        $wok = new Product('Wok', 10);
        $wokItem = new CartItem($wok);

        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('PERCENT10');
        $promoCode->setRules(new PercentRule(10, [$pizza]));

        $cart = new Cart();
        $cart->addPromoCode('PERCENT10');


        $cart->add($pizzaItem);
        $cart->add($wokItem);


        $this->assertEquals(100, $cart->totalPrice());
    }
}
