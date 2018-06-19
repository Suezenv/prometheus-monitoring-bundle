<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ResponseTimeCollector
 *
 * Handles response time
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector
 */
class ResponseTimeCollector extends AbstractCollector
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * ResponseTimeDataCollector constructor.
     *
     * @param KernelInterface|null $kernel
     */
    public function __construct(KernelInterface $kernel = null)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response)
    {
        if (null !== $this->kernel) {
            $startTime = $this->kernel->getStartTime();
        } else {
            $startTime = $request->server->get('REQUEST_TIME_FLOAT');
        }

        $this->data = (microtime(true) - $startTime) * 1000;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectorName(): string
    {
        return 'suez_sf_app_response_time';
    }
}