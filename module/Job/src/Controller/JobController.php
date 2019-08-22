<?php
namespace Job\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Job\Model\JobItemTable;
use Job\Model\JobOrderTable;

class JobController extends AbstractActionController
{
    private $container;
    private $customerSession;
    private $jobSession;
    private $jobItemTable;
    private $jobOrderTable;

    public function __construct(
        ContainerInterface $container,
        Container $customerSession,
        Container $jobSession,
        JobItemTable $jobItemTable,
        JobOrderTable $jobOrderTable
    ) {
        $this->container = $container;
        $this->customerSession = $customerSession;
        $this->jobSession = $jobSession;
        $this->jobItemTable = $jobItemTable;
        $this->jobOrderTable = $jobOrderTable;
    }

    public function showOrderConfirmationAction()
    {
        $customer_id = $this->customerSession->offsetGet('customer_id');

        if (!$customer_id) {
            return $this->redirect()->toRoute('customer', [
                'from' => $this->getEvent()->getRouteMatch()->getMatchedRouteName()
            ]);
        }

        $job_order_id = $this->jobSession->offsetGet('job_order_id');

        $jobItems = $this->jobItemTable->fetchAllJobItemsByJobOrder($job_order_id);
        $jobOrder = $this->jobOrderTable->fetchJobOrder($job_order_id);

        $viewModel = new ViewModel([
            'jobItems'   => $jobItems,
            'jobOrder'   => $jobOrder,
            'jobOrderId' => $job_order_id
        ]);
        $viewModel->setTemplate('job/show-order-confirmation');

        return $viewModel;
    }
}