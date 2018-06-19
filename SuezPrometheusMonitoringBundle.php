<?php

namespace Suez\Bundle\PrometheusMonitoringBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Collector\AbstractCollector;
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
    }
}