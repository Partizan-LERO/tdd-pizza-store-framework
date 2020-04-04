<?php


namespace Tests;


use App\Cart;
use App\CartItem;
use App\PercentRule;
use App\Product;
use App\PromoCode;
use App\PromoCodeObserver;

class CartTest extends TestCase
{
    public function testAdd()
    {
        $cart = new Cart();
        $product = new Product('Pizza', 20);

        $cartItem = new CartItem($product);

        $cart->add($cartItem);
        $cart->add($cartItem);


        $product = new Product('Wok', 30);
        $cart->add(new CartItem($product));

        $this->assertCount(2, $cart->get());
    }

    public function testGetItems()
    {
        $cart = new Cart();

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product);

        $cart->add($cartItem);

        $product = new Product('Wok', 30);
        $cartItem = new CartItem($product);

        $cart->add($cartItem);

        $this->assertCount(2, $cart->get());
    }

    public function testDecrement()
    {
        $cart = new Cart();

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product, 2);

        $cart->add($cartItem);

        $cart->decrementByTitle('Pizza');
        $this->assertEquals(1, $cart->getByTitle('Pizza')->getCount());
        $this->assertCount(1, $cart->get());

        $cart->decrementByTitle('Pizza');
        $this->assertCount(0, $cart->get());
    }

    public function testIncrement()
    {
        $cart = new Cart();

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product, 2);

        $cart->add($cartItem);

        $cart->incrementByTitle('Pizza');
        $this->assertEquals(3, $cart->getByTitle('Pizza')->getCount());
    }


    public function testRemoveItemByTitle()
    {
        $cart = new Cart();

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product);
        $cart->add($cartItem);

        $product = new Product('Wok', 30);
        $cartItem = new CartItem($product);
        $cart->add($cartItem);

        $cart->removeByTitle('Pizza');

        $this->assertCount(1, $cart->get());
    }

    public function testTotalPrice()
    {
        $cart = new Cart();

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product, 5);
        $cart->add($cartItem);

        $product = new Product('Wok', 30);
        $cartItem = new CartItem($product);
        $cart->add($cartItem);

        $this->assertEquals(130, $cart->totalPrice());
    }

    public function testCheckIfPromocodeExists()
    {
        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('PERCENT10');
        $promoCode->setRules(new PercentRule(10, ['*']));

        $cart = new Cart();
        $this->assertFalse($cart->checkIfPromoCodeExists('PERCENT20'));
        $this->assertTrue($cart->checkIfPromoCodeExists('PERCENT10'));
    }


    public function testAddPromoCode()
    {
        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('PERCENT30');
        $promoCode->setRules(new PercentRule(30, ['*']));

        $cart = new Cart();
        $cart->addPromoCode('PERCENT30');
        $this->assertEquals('PERCENT30', $cart->getPromoCode());

        $cart = new Cart();
        $cart->addPromoCode('PERCENT20');
        $this->assertNull($cart->getPromoCode());
    }


    public function testGetRecalculatedTotalPrice()
    {
        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promoCode = new PromoCode();
        $promoCode->attach($observer);

        $promoCode->setPromoCode('PERCENT10');
        $promoCode->setRules(new PercentRule(10, ['*']));

        $cart = new Cart();
        $cart->addPromoCode('PERCENT10');

        $product = new Product('Pizza', 20);
        $cartItem = new CartItem($product, 5);
        $cart->add($cartItem);

        $product = new Product('Wok', 10);
        $cartItem = new CartItem($product);
        $cart->add($cartItem);

        $this->assertEquals(99, $cart->totalPrice());
    }




}
