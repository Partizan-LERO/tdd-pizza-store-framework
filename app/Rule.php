<?php


namespace App;


interface Rule
{
    public function recalculate(Cart $cart);
}
