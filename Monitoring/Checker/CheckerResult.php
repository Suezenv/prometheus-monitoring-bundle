<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker;

/**
 * Class CheckerResult
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Checker
 */
class CheckerResult
{
    /**
     * Array of check results
     * service code => bool
     *
     * @var array
     */
    public $checked = [];

    /**
     * CheckerResult constructor.
     *
     * @param array $checked
     */
    public function __construct(array $checked)
    {
        $this->checked = $checked;
    }

    /**
     * Check if all the services are up
     *
     * @return bool
     */
    public function isUp(): bool
    {
        return !in_array(false, $this->checked);
    }
}