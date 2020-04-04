<?php


namespace App;


use SplSubject;

/**
 * Class PromoCodeObserver
 * @package App
 *
 * This class was created only for DEMONSTRATION PURPOSES.
 * Don't use this class in a real application.
 * Use PromoCodeModel and PromoCodeRepository for working with promoCode data, which is stored in your database.
 */
class PromoCodeObserver implements \SplObserver
{
    /**
     * @var array
     */
    private $promoCodes = [];

    static private $oInstance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return PromoCodeObserver
     */
    public static function getInstance(): PromoCodeObserver
    {
        if (self::$oInstance === null) {
            self::$oInstance = new PromoCodeObserver();
        }

        return self::$oInstance;
    }

    public function update(SplSubject $subject)
    {
        $this->promoCodes[$subject->getPromoCode()] = $subject;
    }

    public function reset()
    {
        $this->promoCodes = [];
    }

    /**
     * @return array
     */
    public function getPromoCodeKeys(): array
    {
        return array_keys($this->promoCodes);
    }

    /**
     * @param  string  $promoCode
     * @return bool|string
     */
    public function findByPromoCode(string $promoCode)
    {
        foreach ($this->promoCodes as $key => $value) {
            if ($promoCode === $key) {
                return $this->promoCodes[$key];
            }
        }

        return false;
    }
}
