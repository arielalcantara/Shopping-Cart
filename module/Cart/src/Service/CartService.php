<?php
namespace Cart\Service;

class CartService
{
    public function computeTotals($cartItemArray, $cartArray)
    {
        $result->sub_total = $cartArray['sub_total'] + $cartItemArray['price'];
        $result->total_amount = $cartArray['total_amount'] + $cartArray['shipping_total'] + $cartItemArray['price'];
        $result->total_weight = $cartArray['total_weight'] + $cartItemArray['weight'];
        
        return $result;
    }

    public function computeTotalAmount($sub_total, $shipping_total)
    {
        $total_amount = $sub_total + $shipping_total;

        return $total_amount;
    }
}