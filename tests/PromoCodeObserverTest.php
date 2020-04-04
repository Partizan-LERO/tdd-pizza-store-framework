<?php


namespace Tests;


use App\PromoCode;
use App\PromoCodeObserver;


class PromoCodeObserverTest extends TestCase
{

    public function testNotify()
    {
        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promo = new PromoCode();
        $promo->attach($observer);
        $promo->setPromoCode('ABCDE');

        $this->assertEquals(['ABCDE'], $observer->getPromoCodeKeys());
    }

    public function testFindByPromoCode()
    {
        $observer = PromoCodeObserver::getInstance();
        $observer->reset();

        $promo = new PromoCode();
        $promo->attach($observer);
        $promo->setPromoCode('ABCDE');

        $pr = new PromoCode();
        $pr->attach($observer);
        $pr->setPromoCode('12312');

        $this->assertEquals('ABCDE', $observer->findByPromoCode('ABCDE')->getPromoCode());
        $this->assertEquals(false, $observer->findByPromoCode('ABCDEas'));
    }
}
