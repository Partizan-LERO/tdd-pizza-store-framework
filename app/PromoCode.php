<?php


namespace App;


use SplObjectStorage;
use SplObserver;

class PromoCode implements \SplSubject
{
    public const PERCENT_RULE_TYPE = 1;
    public const GET_FREE_PRODUCT_TYPE = 2;

    /**
     * @var SplObserver[]
     */
    private $observers;

    /**
     * @var string
     */
    private $promoCode;

    /**
     * @var Rule
     */
    private $rules;

    public function __construct()
    {
        $this->observers = new SplObjectStorage;
    }


    /**
     * @return string
     */
    public function getPromoCode(): string
    {
        return $this->promoCode;
    }

    /**
     * @param  string  $promoCode
     */
    public function setPromoCode(string $promoCode): void
    {
        $this->promoCode = $promoCode;
        $this->notify();
    }

    /**
     * @return array
     */
    public function getRules(): Rule
    {
        return $this->rules;
    }


    /**
     * @param  Rule  $rules
     */
    public function setRules(Rule $rules): void
    {
        $this->rules = $rules;
        $this->notify();
    }


    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }


    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
