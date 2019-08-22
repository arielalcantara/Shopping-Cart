<?php
namespace CartItem\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;

class CartController extends AbstractRestfulController
{
    private $container;

public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }


}
