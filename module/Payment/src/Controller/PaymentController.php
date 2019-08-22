<?php
namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Cart\Model\CartItemTable;
use Cart\Model\CartTable;
use Job\Model\JobOrder;
use Job\Model\JobOrderTable;
use Job\Model\JobItemTable;
use Shipping\Service\ShippingService;
use Cart\Service\CartService;

class PaymentController extends AbstractActionController
{
    private $container;
    private $customerSession;
    private $cartSession;
    private $jobSession;
    private $cartItemTable;
    private $jobOrder;
    private $jobOrderTable;
    private $jobItemTable;
    private $shippingService;
    private $cartService;

    public function __construct(
        ContainerInterface $container,
        Container $customerSession,
        Container $cartSession,
        Container $jobSession,
        CartItemTable $cartItemTable,
        CartTable $cartTable,
        JobOrder $jobOrder,
        JobOrderTable $jobOrderTable,
        JobItemTable $jobItemTable,
        ShippingService $shippingService,
        CartService $cartService
    ) {
        $this->container = $container;
        $this->customerSession = $customerSession;
        $this->cartSession = $cartSession;
        $this->jobSession = $jobSession;
        $this->cartItemTable = $cartItemTable;
        $this->cartTable = $cartTable;
        $this->jobOrder = $jobOrder;
        $this->jobOrderTable = $jobOrderTable;
        $this->jobItemTable = $jobItemTable;
        $this->shippingService = $shippingService;
        $this->cartService = $cartService;
    }

    public function showPaymentPageAction()
    {
        $customer_id = $this->customerSession->offsetGet('customer_id');

        if (!$customer_id) {
            return $this->redirect()->toRoute('customer', [
                'from' => $this->getEvent()->getRouteMatch()->getMatchedRouteName()
            ]);
        }

        $cart_id = $this->cartSession->offsetGet('cart_id');

        $cartItems = $this->cartItemTable->fetchAllCartItems($cart_id);  
        $cartTotals = $this->cartTable->fetchCartTotals($cart_id);

        $viewModel = new ViewModel([
            'cartItems'  => $cartItems,
            'cartTotals' => $cartTotals
        ]);
        $viewModel->setTemplate('payment/show-payment-page');

        return $viewModel;
    }

    public function confirmPaymentAction()
    {
        $cart_id = $this->cartSession->offsetGet('cart_id');

        if (!$cart_id) {
            return $this->redirect()->toRoute('product', [], [
                'query' => [
                    'error' => 'No items inside cart. Invalid payment.'
                ]
            ]);
        }

        $cart = $this->cartTable->fetchCartTotalsAndShippingMethod($cart_id);

        $cart->shipping_total = $this->shippingService->calculateShippingTotal(
            $cart->total_weight,
            $cart->shipping_method
        );
        
        $cart->total_amount = $this->cartService->computeTotalAmount(
            $cart->sub_total,
            $cart->shipping_total
        );
        
        $this->cartTable->updateCartTotals($cart_id, $cart);
        
        $this->jobOrder = $this->cartTable->fetchCart($cart_id);
        $this->jobOrderTable->insertJobOrder($this->jobOrder);

        $customer_id = $this->customerSession->offsetGet('customer_id');
        $jobOrderArray = $this->jobOrderTable->fetchJobOrderIdByCustomerAndDateTime(
            $customer_id,
            $this->jobOrder->order_datetime
        );
        
        $jobItemsArray = $this->cartItemTable->fetchCartItemsByCart($cart_id);

        foreach ($jobItemsArray as $jobItemArray) {
            $jobItemArray['job_order_id'] = $jobOrderArray['job_order_id'];
            $this->jobItemTable->insertJobItem($jobItemArray);
        }

        $this->cartItemTable->deleteCartItemByCart($cart_id);
        $this->cartTable->deleteCart($cart_id);

        $this->cartSession->offsetUnset('cart_id');
        $this->jobSession->offsetSet('job_order_id', $jobOrderArray['job_order_id']);

        return $this->redirect()->toRoute('job');    
    }
}