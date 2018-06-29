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
                ->arrayNode('healthcheck')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('path')->defaultValue('/health')->end()
                        ->arrayNode('checkers')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('elastic')->defaultFalse()->end()
                                ->booleanNode('influx')->defaultFalse()->end()
                                ->booleanNode('mysql')->defaultFalse()->end()
                                ->booleanNode('mongo')->defaultFalse()->end()
                                ->arrayNode('custom')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}