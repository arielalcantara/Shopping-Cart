<?php
namespace Customer\ServiceFactory\Controller;

use Psr\Container\ContainerInterface;
use Customer\Controller\CustomerController;
use Customer\Filter\LoginFilter;
use Customer\Filter\RegistrationFilter;
use Customer\Model\CustomerTable;
use Cart\Model\CartTable;
use Cart\Model\CartItemTable;
use Customer\Model\Customer;

class CustomerControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $loginFilter = $container->get(LoginFilter::class);
        $registrationFilter = $container->get(RegistrationFilter::class);
        $customerTable = $container->get(CustomerTable::class);
        $cartTable = $container->get(CartTable::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $customer = new Customer;

        return new CustomerController(
            $container,
            $loginFilter,
            $registrationFilter,
            $customerTable,
            $cartTable,
            $cartItemTable,
            $customer
        );
    }
}