<?php


namespace Tests;


use App\Cart;
use App\CartItem;
use App\GetFreeProductRule;
use App\Product;
use App\PromoCode;
use App\PromoCodeObserver;

class GetFreeProductRuleTest extends TestCase
{
    public function testSuccessCart()
    {
        $pizza = new Product('Pizza', 20);
        $pizzaItem = new CartItem($pizza, 1);
        $peperonchino = new Product('Peperonchino', 30);
        $peperonchinoItem = new CartItem($peperonchino, 1);
        $wok = new Product('Wok', 10);
        $wokItem = new CartItem($wok);

        $margarita = new Product('Margarita', 1);

        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('MARGO');
        $promoCode->setRules(new GetFreeProductRule(2, [$pizza, $wok, $peperonchino], $margarita));

        $cart = new Cart();
        $cart->addPromoCode('MARGO');

        $cart->add($pizzaItem);
        $cart->add($wokItem);
        $cart->add($peperonchinoItem);

        $this->assertEquals(60, $cart->totalPrice());
        $this->assertCount(4, $cart->get());
    }


    public function testFailedCart()
    {
        $pizza = new Product('Pizza', 20);
        $pizzaItem = new CartItem($pizza, 1);
        $wok = new Product('Wok', 10);
        $wokItem = new CartItem($wok);
        $peperonchino = new Product('Peperonchino', 30);
        $margarita = new Product('Margarita', 1);


        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('MARGO');
        $promoCode->setRules(new GetFreeProductRule(3, [$pizza, $wok, $peperonchino], $margarita));

        $cart = new Cart();
        $cart->addPromoCode('MARGO');

        $cart->add($pizzaItem);
        $cart->add($wokItem);

        $this->assertEquals(30, $cart->totalPrice());
        $this->assertCount(2, $cart->get());
    }
}
