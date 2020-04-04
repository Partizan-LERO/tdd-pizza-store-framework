<?php


namespace Tests;


use App\Product;
use function PHPUnit\Framework\assertEquals;

class ProductTest extends TestCase
{
    public function testCreate() {
        $title = 'Pepperoni';
        $price = 20;

        $product = new Product($title, $price);
        assertEquals($price, $product->getPrice());
        assertEquals($title, $product->getTitle());
    }
}
