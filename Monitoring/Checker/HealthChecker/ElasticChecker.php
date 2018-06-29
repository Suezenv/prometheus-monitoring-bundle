<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthCheckInterface;

/**
 * Class ElasticChecker
 * Default implementation of a elastic checker with fos elastica
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker
 */
class ElasticChecker implements HealthCheckInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'elastic';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        return true;
    }
}