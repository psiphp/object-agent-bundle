<?php

namespace Psi\Bundle\ObjectAgent\Tests\Functional;

use Psi\Bundle\ObjectAgent\Example\app\AppKernel;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    /**
     * It should retrieve all of the registered services.
     */
    public function testGetServices()
    {
        foreach ($this->container->getServiceIds() as $serviceId) {
            if (0 !== strpos($serviceId, 'psi_object_agent')) {
                continue;
            }

            $service = $this->container->get($serviceId);
        }
    }
}
