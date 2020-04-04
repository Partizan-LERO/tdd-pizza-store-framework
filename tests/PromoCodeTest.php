<?php


namespace Tests;


use App\PromoCode;

class PromoCodeTest extends TestCase
{
    public function testGetPromoCode()
    {
        $promoCode = new PromoCode();
        $promoCode->setPromoCode('ABCDE');
        $this->assertEquals('ABCDE', $promoCode->getPromoCode());

        $promoCode = new PromoCode();
        $promoCode->setPromoCode('FGHJK');
        $this->assertEquals('FGHJK', $promoCode->getPromoCode());
    }

}
