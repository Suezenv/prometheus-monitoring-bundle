<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler;

use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckerRegistry;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CheckerCollectorPass
 *
 * Container compiler pass to load checkers into the registry service
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection\Compiler
 */
class CheckerCollectorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HealthCheckerRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(HealthCheckerRegistry::class);

        $taggedServices = $container
            ->findTaggedServiceIds('suez.prometheus_monitoring_checker')
        ;

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addChecker', array(new Reference($id)));
        }
    }
}