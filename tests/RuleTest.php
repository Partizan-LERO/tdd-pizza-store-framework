<?php


namespace Tests;


use App\GetFreeProductRule;
use App\PercentRule;
use App\Product;
use App\PromoCode;

class RuleTest extends TestCase
{
    public function testPercentRules()
    {
        $promoCode = new PromoCode();
        $promoCode->setPromoCode('ABCDE');
        $promoCode->setRules(new PercentRule(10, ['*']));
        $this->assertInstanceOf(PercentRule::class, $promoCode->getRules());
    }

    public function testGetFreeProductRules()
    {
        $pizza = new Product('Pizza', 200);
        $wok = new Product('Wok', 100);
        $rolls = new Product('Rolls', 300);


        $promoCode = new PromoCode();
        $promoCode->setPromoCode('ABCDE');
        $promoCode->setRules(new GetFreeProductRule(2, [$pizza, $wok], [$rolls]));
        $this->assertInstanceOf(GetFreeProductRule::class, $promoCode->getRules());
    }
}
