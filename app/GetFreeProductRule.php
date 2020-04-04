<?php


namespace App;


class GetFreeProductRule implements Rule
{
    /**
     * @var int
     */
    private $requiredCount;

    /**
     * @var Product[]
     */
    private $itemsInCampaign;

    /**
     * @var Product
     */
    private $giftInCampaign;


    public function __construct($requiredCount, $itemsInCampaign, $giftInCampaign)
    {
        $this->requiredCount = $requiredCount;
        $this->itemsInCampaign = $itemsInCampaign;
        $this->giftInCampaign = $giftInCampaign;
    }

    /**
     * @return int
     */
    public function getRequiredCount(): int
    {
        return $this->requiredCount;
    }

    /**
     * @param  int  $requiredCount
     */
    public function setRequiredCount(int $requiredCount): void
    {
        $this->requiredCount = $requiredCount;
    }

    /**
     * @return Product[]
     */
    public function getItemsInCampaign(): array
    {
        return $this->itemsInCampaign;
    }

    /**
     * @param  Product[]  $itemsInCampaign
     */
    public function setItemsInCampaign(array $itemsInCampaign): void
    {
        $this->itemsInCampaign = $itemsInCampaign;
    }

    /**
     * @return Product
     */
    public function getGiftInCampaign(): Product
    {
        return $this->giftInCampaign;
    }

    /**
     * @param  Product  $giftInCampaign
     */
    public function setGiftInCampaign(Product $giftInCampaign): void
    {
        $this->giftInCampaign = $giftInCampaign;
    }


    public function recalculate(Cart $cart)
    {
        $productsCounter = 0;

        foreach ($cart->get() as $item) {
            $product = $item->getProduct();
            foreach ($this->itemsInCampaign as $itemInCampaign) {
                if ($itemInCampaign === $product) {
                    $productsCounter++;
                    if ($productsCounter === $this->requiredCount) {
                        $this->giftInCampaign->setPrice(0);
                        $gift = new CartItem($this->giftInCampaign);
                        $cart->add($gift);
                        break;
                    }
                }
            }
        }

        return Calculator::getSummedPrice($cart);
    }
}
