<?php
namespace Cart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Product\Model\ProductTable;
use Product\Service\ProductService;
use Cart\Model\CartTable;
use Cart\Filter\CartFilter;
use Cart\Service\CartService;
use Cart\Model\Cart;
use Customer\Model\CustomerTable;
use Cart\Model\CartItemTable;
use Cart\Model\CartItem;
use Cart\Service\CartItemService;

class CartController extends AbstractActionController
{
    private $container;
    private $cartFilter;
    private $productTable;
    private $cartTable;
    private $cartItemTable;
    private $cartService;
    private $cartItemService;
    private $productService;

    public function __construct(
        ContainerInterface $container,
        Container $cartSession,
        Container $customerSession,
        CartFilter $cartFilter,
        ProductTable $productTable,
        CartTable $cartTable,
        CartItemTable $cartItemTable,
        CartService $cartService,
        CartItemService $cartItemService,
        ProductService $productService
    ) {
        $this->container = $container;
        $this->cartSession = $cartSession;
        $this->customerSession = $customerSession;
        $this->cartFilter = $cartFilter;
        $this->productTable = $productTable;
        $this->cartTable = $cartTable;
        $this->cartItemTable = $cartItemTable;
        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
        $this->productService = $productService;
    }

    public function addItemToCartAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('product');
        }

        $params = $this->params()->fromPost();
        $this->cartFilter->setData($params);
        $filtered = $this->cartFilter->getValues();
        $product_id = $filtered['product_id'];
        $qty = $filtered['qty'];

        $productArray = $this->productTable->fetchProductInfo($product_id);

        if (!$productArray['stock_qty']) {
            return $this->redirect()->toRoute('product', [], [
                'query' => [
                    'error' => 'Item is currently unavailable.'
                ]
            ]);
        }

        $cartItemArray = $this->productService->computeProductWeightAndPrice($productArray, $qty);

        $cart_id = $this->cartSession->offsetGet('cart_id');

        if (isset($cart_id)) {
            $cartArray = $this->cartTable->fetchCartTotals($cart_id);
            $cart = $this->cartService->computeTotals($cartItemArray, $cartArray);
            $this->cartTable->updateCart($cart_id, $cart);
        } else {
            $customer_id = $this->customerSession->offsetGet('customer_id');
            $cart = new Cart;

            if (isset($customer_id)) {
                $customerTable = $this->container->get(CustomerTable::class);
                $customerArray = $customerTable->fetchCustomerInfo($customer_id);

                $cart->exchangeArray($customerArray);
                $cart->customer_id = $customer_id;
            } else {              
                $cart->customer_id = 0;
            }

            $cartArray = $cart->getArrayCopy();

            $cartTotals = $this->cartService->computeTotals($cartItemArray, $cartArray);

            $cart->sub_total = $cartTotals->sub_total;
            $cart->total_amount = $cartTotals->total_amount;
            $cart->total_weight = $cartTotals->total_weight;

            $this->cartTable->insertCart($cart);

            $cartArray = $this->cartTable->fetchCartIdByCustomer($customer_id);

            $this->cartSession->offsetSet('cart_id', $cartArray['cart_id']);
        }
        // Cart Item
        $cart_id = $this->cartSession->offsetGet('cart_id');

        $cartItem = new CartItem;
        $cartItem->exchangeArray($cartItemArray);
        $cartItem->cart_id = $cart_id;
        $cartItem->product_id = $product_id;
        $cartItem->qty = $qty;
        $cartItem->unit_price = $productArray['price'];

        $oldCartItemArray = $this->cartItemTable->fetchCartItemByCartAndProduct($cart_id, $product_id);

        if (empty($oldCartItemArray)) {
            $this->cartItemTable->insertCartItem($cartItem);
        } else {
            $newCartItem = $this->cartItemService->computeCartItemSum($cartItem, $oldCartItemArray);

            $cartItem->cart_item_id = $oldCartItemArray['cart_item_id'];
            $cartItem->weight = $newCartItem->weight;
            $cartItem->qty = $newCartItem->qty;
            $cartItem->price = $newCartItem->price;

            $this->cartItemTable->updateCartItem($cartItem->cart_item_id, $cartItem);
        }

        return $this->redirect()->toRoute('cart'); 
    }

    public function showCartAction()
    {
        $cart_id = $this->cartSession->offsetGet('cart_id');

        $cartItems = $this->cartItemTable->fetchAllCartItems($cart_id);   
        $cartTotals = $this->cartTable->fetchCartTotals($cart_id);

        $viewModel = new ViewModel([
            'cartItems'  => $cartItems,
            'cartTotals' => $cartTotals
        ]);
        $viewModel->setTemplate('cart/show-cart');

        return $viewModel;
    }
}