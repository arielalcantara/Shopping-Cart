<?php
namespace Payment\ServiceFactory\Controller;

use Psr\Container\ContainerInterface;
use Payment\Controller\PaymentController;
use Cart\Model\CartItemTable;
use Cart\Model\CartTable;
use Cart\Model\Cart;
use Job\Model\JobOrder;
use Job\Model\JobOrderTable;
use Job\Model\JobItemTable;
use Shipping\Service\ShippingService;
use Cart\Service\CartService;

class PaymentControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $customerSession = $container->get('Customer\Storage\CustomerSessionContainer');
        $cartSession = $container->get('Cart\Storage\CartSessionContainer');
        $jobSession = $container->get('Job\Storage\JobSessionContainer');
        $cartItemTable = $container->get(CartItemTable::class);
        $cartTable = $container->get(CartTable::class);
        $jobOrder = new JobOrder;
        $jobOrderTable = $container->get(JobOrderTable::class);
        $jobItemTable = $container->get(JobItemTable::class);
        $shippingService = $container->get(ShippingService::class);
        $cartService = $container->get(CartService::class);

        return new PaymentController(
            $container,
            $customerSession,
            $cartSession,
            $jobSession,
            $cartItemTable,
            $cartTable,
            $jobOrder,
            $jobOrderTable,
            $jobItemTable,
            $shippingService,
            $cartService
        );
    }
}