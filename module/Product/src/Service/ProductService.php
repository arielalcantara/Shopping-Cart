<?php
namespace Product\Service;

class ProductService
{
    public function computeProductWeightAndPrice($product, $qty)
    {
        $resultArray['weight'] = $product['weight'] * $qty;
        $resultArray['price'] = $product['price'] * $qty;

        return $resultArray;
    }
}