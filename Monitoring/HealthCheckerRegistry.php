<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\HealthCheckInterface;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker\CheckerResult;

/**
 * Class HealthCheckerRegistry
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring
 */
class HealthCheckerRegistry
{
    /**
     * List of health checkers
     *
     * @var HealthCheckInterface[]
     */
    protected $checkers = [];

    /**
     * Add a health checker
     *
     * @param HealthCheckInterface $checker
     */
    public function addChecker(HealthCheckInterface $checker)
    {
        $this->checkers[] = $checker;
    }

    /**
     * Executes all registered checkers and returns an array with the status
     * (true if available else false)
     *
     * @return CheckerResult
     */
    public function check()
    {
        $checked = [];

        foreach ($this->checkers as $checker) {
            try {
                $isWorking = $checker->check();
            } catch (\Exception $e) {
                $isWorking = false;
            }

            $checked[$checker->getName()] = $isWorking;
        }

        return new CheckerResult($checked);
    }
}