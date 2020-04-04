<?php


namespace App;


class Cart
{
    /**
     * @var array CartItem[]
     */
    private $items = [];

    /**
     * @var string
     */
    private $promoCode;


    public function addPromoCode(string $promoCode): void
    {
        $result = $this->checkIfPromoCodeExists($promoCode);

        if ($result) {
            $this->promoCode = $promoCode;
        }
    }

    /**
     * @param  string  $promoCode
     * @return bool
     */
    public function checkIfPromoCodeExists(string $promoCode): bool
    {
        $observer = PromoCodeObserver::getInstance();
        return $observer->findByPromoCode($promoCode) ? true: false;
    }


    /**
     * @param  CartItem  $product
     * @return array
     */
    public function add(CartItem $product): array
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product->getProduct()) {
                $product->increment();
                return $this->items;
            }
        }

        $this->items[] = $product;
        return $this->items;
    }

    /**
     * @return CartItem[]|array
     */
    public function get(): array
    {
        return $this->items;
    }


    /**
     * @param  string  $title
     * @return CartItem|array
     */
    public function getByTitle(string $title)
    {
        /**
         * @var  CartItem $item
         */
        foreach ($this->items as $index => $item) {
            if ($item->getProduct()->getTitle() === $title) {
                return $item;
            }
        }

        return [];
    }

    /**
     * @param  string  $title
     * @return CartItem
     */
    public function incrementByTitle(string $title): CartItem
    {
        /**
         * @var CartItem $item
         */
        $item = $this->getByTitle($title);

        if ($item instanceof CartItem) {
            if ($item->getCount() > 1) {
                $item->increment();
            }
        }

        return $item;
    }

    /**
     * @param  string  $title
     * @return CartItem|array
     */
    public function decrementByTitle(string $title)
    {
        /**
         * @var CartItem $item
         */
       $item = $this->getByTitle($title);

       if ($item instanceof CartItem) {
           if ($item->getCount() > 1) {
               $item->decrement();
           } else {
               $this->removeByTitle($title);
           }
       }

       return $item;
    }

    /**
     * @param  string  $title
     * @return array
     */
    public function removeByTitle(string $title): array
    {
        /**
         * @var CartItem $item
         */
        foreach ($this->items as $index => $item) {
            if ($item->getProduct()->getTitle() === $title) {
                unset($this->items[$index]);
                break;
            }
        }

        return $this->items;
    }


    /**
     * @return float
     */
    public function totalPrice() :float
    {
        if ($this->promoCode) {
            return $this->recalculateTotalPrice();
        }

        return Calculator::getSummedPrice($this);
    }

    public function recalculateTotalPrice() {
        $observer = PromoCodeObserver::getInstance();
        return $observer->findByPromoCode($this->promoCode)->getRules()->recalculate($this);
    }


    /**
     * @return string|null
     */
    public function getPromoCode():?string
    {
        return $this->promoCode;
    }

}
