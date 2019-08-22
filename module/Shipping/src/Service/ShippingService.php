<?php
namespace Shipping\Service;

use Shipping\Model\ShippingTable;

class ShippingService
{
    private $shippingTable;

    public function __construct(ShippingTable $shippingTable)
    {
        $this->shippingTable = $shippingTable;
    }

    public function calculateShippingTotal($total_weight, $shipping_method)
    {
        $shippings = $this->shippingTable->fetchAllShippingRecords();          

        // Perform when total weight is within allowed weight per shipment
        foreach ($shippings as $shipping) {
            if ($shipping['shipping_method'] === $shipping_method) {
                if ($total_weight >= $shipping['min_weight'] && $total_weight <= $shipping['max_weight']) {
                    $runningPrice = $shipping['shipping_rate']; 
                    break;             
                }
                $maxWeightPerShipment = $shipping['max_weight'];
                $maxRatePerShipment = $shipping['shipping_rate'];
            }
        }

        // Perform when total weight exceeds allowed max weight per shipment
        if (!$runningPrice) {
            $numOfShipments = floor($total_weight / $maxWeightPerShipment);
            $runningPrice = $numOfShipments * $maxRatePerShipment;
            $remainingWeight = $total_weight % $maxWeightPerShipment;
            
            if ($remainingWeight) {
                foreach ($shippings as $shipping) {
                    if ($shipping['shipping_method'] === $shipping_method) {
                        if ($remainingWeight >= $shipping['min_weight'] && $remainingWeight <= $shipping['max_weight']) {
                            $runningPrice += $shipping['shipping_rate'];
                            break; 
                        }
                    }
                }
            }
        }
        
        return $runningPrice; 
    }
}