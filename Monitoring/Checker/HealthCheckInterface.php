<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker;

/**
 * Interface HealthCheckInterface
 */
interface HealthCheckInterface
{
    /**
     * Get the name of the checked server
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Check if service up and returns true else false
     *
     * @return bool
     */
    public function check(): bool;
}