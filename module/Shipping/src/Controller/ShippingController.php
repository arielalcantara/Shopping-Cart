<?php
namespace Shipping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Shipping\Filter\ShippingFilter;
use Shipping\Model\ShippingTable;
use Cart\Model\CartTable;
use Cart\Model\Cart;
use Shipping\Service\ShippingService;
use Cart\Service\CartService;


class ShippingController extends AbstractActionController
{
    private $container;
    private $shippingFilter;
    private $customerSession;
    private $cartSession;
    private $shippingTable;
    private $cartTable;
    private $cart;
    private $shippingService;
    private $cartService;

    public function __construct(
        ContainerInterface $container,
        ShippingFilter $shippingFilter,
        Container $customerSession,
        Container $cartSession,
        ShippingTable $shippingTable,
        CartTable $cartTable,
        Cart $cart,
        ShippingService $shippingService,
        CartService $cartService
    ) {
        $this->container = $container;
        $this->shippingFilter = $shippingFilter;
        $this->cartSession = $cartSession;
        $this->shippingTable = $shippingTable;
        $this->cartTable = $cartTable;
        $this->cart = $cart;
        $this->shippingService = $shippingService;
        $this->cartService = $cartService;
    }

    public function showShippingPageAction()
    {    
        $customerSession = $this->container->get('Customer\Storage\CustomerSessionContainer');
        $customer_id = $customerSession->offsetGet('customer_id');

        if (!$customer_id) {
            return $this->redirect()->toRoute('customer', [
                'from' => $this->getEvent()->getRouteMatch()->getMatchedRouteName()
            ]);
        }
        
        $cartSession = $this->container->get('Cart\Storage\CartSessionContainer');
        $cart_id = $cartSession->offsetGet('cart_id');

        $cart = $this->cartTable->fetchCartTotalWeight($cart_id);

        $shippingOptions = $this->shippingTable->fetchShippingMethods();

        foreach ($shippingOptions as $shippingOption) {
            $shippingTotals[$shippingOption['shipping_method']] = $this->shippingService->calculateShippingTotal(
                $cart['total_weight'],
                $shippingOption['shipping_method']
            );
        }

        $viewModel = new ViewModel([
            'shippingTotals' => $shippingTotals,
            'params' => $this->params()->fromQuery()
        ]);
        $viewModel->setTemplate('shipping/shipping-page');

        return $viewModel;
    }

    public function submitShippingDetailsAction()
    {
        $cartSession = $this->container->get('Cart\Storage\CartSessionContainer');
        $cart_id = $cartSession->offsetGet('cart_id');

        if (!$cart_id) {
            return $this->redirect()->toRoute('product', [], [
                'query' => [
                    'error' => 'No items inside cart. Invalid shipment.'
                ]
            ]);
        }

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('shipping');
        }

        $inputArray = $this->params()->fromPost();
        $inputArray = $this->shippingFilter->validateAndSanitizeInput($inputArray);
        
        if (!$this->shippingFilter->isValid()) {
            return $this->redirect()->toRoute('shipping', [], [
                'query' => [
                    'error' => $this->shippingFilter->getMessages()
                ]
            ]);
        }

        $this->cart->exchangeArray($inputArray);

        $cart = $this->cartTable->fetchCartTotalWeightAndSubTotal($cart_id);

        $this->cart->shipping_total = $this->shippingService->calculateShippingTotal(
            $cart['total_weight'],
            $this->cart->shipping_method
        );

        $this->cart->total_amount = $this->cartService->computeTotalAmount(
            $cart['sub_total'],
            $this->cart->shipping_total
        );
        
        $this->cartTable->updateCartShippingDetails($cart_id, $this->cart);
        
        return $this->redirect()->toRoute('payment');    
    }
}