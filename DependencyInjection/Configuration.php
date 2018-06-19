<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('suez_prometheus_monitoring');

        $rootNode
            ->children()
                ->scalarNode('app_code')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}