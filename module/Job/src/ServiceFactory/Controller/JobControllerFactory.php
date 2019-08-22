<?php
namespace Job\ServiceFactory\Controller;

use Psr\Container\ContainerInterface;
use Job\Controller\JobController;
use Job\Model\JobItemTable;
use Job\Model\JobOrderTable;

class JobControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $customerSession = $container->get('Customer\Storage\CustomerSessionContainer');
        $jobSession = $container->get('Job\Storage\JobSessionContainer');
        $jobItemTable = $container->get(JobItemTable::class);
        $jobOrderTable = $container->get(JobOrderTable::class);

        return new JobController(
            $container,
            $customerSession,
            $jobSession,
            $jobItemTable,
            $jobOrderTable
        );
    }
}