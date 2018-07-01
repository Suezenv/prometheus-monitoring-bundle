<?php

namespace Suez\Bundle\PrometheusMonitoringBundle;

use Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler\CheckerCollectorPass;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Metric\Collector\AbstractCollector;
use Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler\MonitoringCollectorPass;

/**
 * SuezPrometheusMonitoringBundle
 */
class SuezPrometheusMonitoringBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(AbstractCollector::class)
            ->addTag('suez.prometheus_monitoring_collector')
        ;

        $container->addCompilerPass(new MonitoringCollectorPass());

        $container
            ->registerForAutoconfiguration(HealthCheckInterface::class)
            ->addTag('suez.prometheus_monitoring_checker')
        ;

        $container->addCompilerPass(new CheckerCollectorPass());
    }
}