<?php
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Customer\Filter\LoginFilter;
use Customer\Filter\RegistrationFilter;
use Customer\Model\CustomerTable;
use Cart\Model\CartTable;
use Cart\Model\CartItemTable;
use Customer\Model\Customer;

class CustomerController extends AbstractActionController
{
    private $container;
    private $loginFilter;
    private $registrationFilter;
    private $customerTable;
    private $cartTable;
    private $cartItemTable;
    private $customer;

    public function __construct(
        ContainerInterface $container,
        LoginFilter $loginFilter,
        RegistrationFilter $registrationFilter,
        CustomerTable $customerTable,
        CartTable $cartTable,
        CartItemTable $cartItemTable,
        Customer $customer
    ) {
        $this->container = $container;
        $this->loginFilter = $loginFilter;
        $this->registrationFilter = $registrationFilter;
        $this->customerTable = $customerTable;
        $this->cartTable = $cartTable;
        $this->cartItemTable = $cartItemTable;
        $this->customer = $customer;
    }

    public function LoginAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('customer');
        }

        $inputArray = $this->params()->fromPost();
        $inputArray = $this->loginFilter->validateAndSanitizeInput($inputArray);

        if (!$this->loginFilter->isValid()) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'loginError' => $this->loginFilter->getMessages()
                ]
            ]);
        }

        $customerArray = $this->customerTable->fetchCustomerInfoByEmail($inputArray['email']);

        if (!$customerArray) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'loginError' => 'Account does not exist.'
                ]
            ]);    
        }
        
        if ($customerArray['password'] != $inputArray['password']) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'loginError' => 'Incorrect password.'
                ]
            ]);  
        }

        $this->LoginCustomer($customerArray);

        if ($inputArray['url']) {
            return $this->redirect()->toRoute($inputArray['url']);
        } else {
            return $this->redirect()->toRoute('product');
        }
    }

    public function RegisterAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('customer');
        }

        $inputArray = $this->params()->fromPost();
        $inputArray = $this->registrationFilter->validateAndSanitizeInput($inputArray);

        if (!$this->registrationFilter->isValid()) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'registrationError' => $this->registrationFilter->getMessages()
                ]
            ]); 
        }
        
        if ($inputArray['password'] != $inputArray['confirm_password']) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'registrationError' => 'Password and confirm password do no match.'
                ]
            ]); 
        }

        $emailExists = $this->customerTable->checkIfEmailExists($inputArray['email']);
        
        if ($emailExists) {
            return $this->redirect()->toRoute('customer', [], [
                'query' => [
                    'registrationError' => 'E-mail address is already taken.'
                ]
            ]);
        }

        $this->customer->exchangeArray($inputArray);
        $this->customerTable->insertCustomer($this->customer);

        $customerArray = $this->customerTable->fetchCustomerIdAndFirstNameByEmail($this->customer->email);
        $this->LoginCustomer($customerArray);

        if ($inputArray['url']) {
            return $this->redirect()->toRoute($inputArray['url']);
        } else {
            return $this->redirect()->toRoute('product');
        }
    }

    public function ShowLoginAndRegistrationAction()
    {
        $viewModel = new ViewModel([
            'customer' => $customer,
            'params' => $this->params()->fromQuery(),
            'from' => $this->params()->fromRoute('from')
        ]);
        $viewModel->setTemplate('customer/login-and-registration');

        return $viewModel;
    }

    public function LogoutAction()
    {
        $customerSession = $this->container->get('Customer\Storage\CustomerSessionContainer');
        $cartSession = $this->container->get('Cart\Storage\CartSessionContainer');
        $cart_id = $cartSession->offsetGet('cart_id');

        $this->cartItemTable->deleteCartItemByCart($cart_id);
        $this->cartTable->deleteCart($cart_id);

        $customerSession->offsetUnset('customer_id');
        $customerSession->offsetUnset('first_name');
        
        $cartSession->offsetUnset('cart_id');

        return $this->redirect()->toRoute('product');
    }

    private function LoginCustomer($customerArray)
    {
        $customerSession = $this->container->get('Customer\Storage\CustomerSessionContainer');
        $customerSession->offsetSet('customer_id', $customerArray['customer_id']);
        $customerSession->offsetSet('first_name', $customerArray['first_name']);
            
        $cartSession = $this->container->get('Cart\Storage\CartSessionContainer');
        $cart_id = $cartSession->offsetGet('cart_id');
        
        if ($cart_id) {
            $cartTable = $this->container->get(CartTable::class);
            $cartTable->updateCartCustomerIdByCart($customerArray['customer_id'], $cart_id);
        }
    }
}