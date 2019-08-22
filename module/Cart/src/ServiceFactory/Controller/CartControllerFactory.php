<?php
namespace Cart\ServiceFactory\Controller;

use Psr\Container\ContainerInterface;
use Cart\Filter\CartFilter;
use Cart\Controller\CartController;
use Product\Model\ProductTable;
use Cart\Model\CartTable;
use Cart\Model\CartItemTable;
use Cart\Service\CartService;
use Cart\Service\CartItemService;
use Product\Service\ProductService;
use Cart\Model\Cart;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $cartSession = $container->get('Cart\Storage\CartSessionContainer');
        $customerSession = $container->get('Customer\Storage\CustomerSessionContainer');
        $cartFilter = $container->get(CartFilter::class);
        $productTable = $container->get(ProductTable::class);
        $cartTable = $container->get(CartTable::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $cartService = $container->get(CartService::class);
        $cartItemService = $container->get(CartItemService::class);
        $productService = $container->get(ProductService::class);
        $cart = new Cart;

        return new CartController(
            $container,
            $cartSession,
            $customerSession,
            $cartFilter,
            $productTable,
            $cartTable,
            $cartItemTable,
            $cartService,
            $cartItemService,
            $productService,
            $cart
        );
    }
}