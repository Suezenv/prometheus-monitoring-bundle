<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\Metric\CollectorRegistry;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MonitoringCollectorPass
 *
 * Container compiler pass to load collectors into the registry service
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler
 */
class MonitoringCollectorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(CollectorRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(CollectorRegistry::class);

        $taggedServices = $container
            ->findTaggedServiceIds('suez.prometheus_monitoring_collector')
        ;

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addCollector', array(new Reference($id)));
        }
    }
}