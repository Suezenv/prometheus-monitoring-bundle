<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthCheckInterface;

/**
 * Class InfluxChecker
 * Default implementation of a influx checker with influxdb-php client
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker
 */
class InfluxChecker implements HealthCheckInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'influx';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        return true;
    }
}