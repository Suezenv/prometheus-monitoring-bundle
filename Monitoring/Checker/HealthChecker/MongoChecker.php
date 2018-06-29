<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthCheckInterface;

/**
 * Class MongoChecker
 * Default implementation of a mongo checker
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker
 */
class MongoChecker implements HealthCheckInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mongo';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        return true;
    }
}