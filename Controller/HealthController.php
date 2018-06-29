<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Controller;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheckerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * HealthController
 */
class HealthController
{
    /**
     * Default health check route
     *
     * @param HealthCheckerRegistry $registry
     * @return JsonResponse
     */
    public function check(HealthCheckerRegistry $registry)
    {
        $result = $registry->check();
        return new JsonResponse(
            $result->checked,
            $result->isUp() ? 200 : 503
        );
    }
}