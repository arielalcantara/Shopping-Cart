<?php
namespace Cart\Service;

class CartItemService
{
    public function computeCartItemSum($cartItem, $oldCartItemArray)
    {
        $result->weight = $cartItem->weight + $oldCartItemArray['weight'];
        $result->qty = $cartItem->qty + $oldCartItemArray['qty'];
        $result->price = $cartItem->price + $oldCartItemArray['price'];

        return $result;
    }
}