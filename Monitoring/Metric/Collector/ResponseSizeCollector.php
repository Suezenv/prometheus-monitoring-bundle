<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Metric\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseSizeCollector
 *
 * Handles response size
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector
 */
class ResponseSizeCollector extends AbstractCollector
{
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response)
    {
        $this->data = strlen($response->getContent());
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectorName(): string
    {
        return 'suez_sf_app_response_size';
    }
}