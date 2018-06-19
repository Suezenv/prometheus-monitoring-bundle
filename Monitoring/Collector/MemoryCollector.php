<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MemoryCollector
 *
 * Handles peak memory usage
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector
 */
class MemoryCollector extends AbstractCollector
{
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response)
    {
        $this->data = memory_get_peak_usage(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectorName(): string
    {
        return 'suez_sf_app_memory_usage';
    }
}