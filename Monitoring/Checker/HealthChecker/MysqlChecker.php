<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthCheckInterface;

/**
 * Class MysqlChecker
 * Default implementation of a mysql checker
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthChecker
 */
class MysqlChecker implements HealthCheckInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mysql';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        return true;
    }
}