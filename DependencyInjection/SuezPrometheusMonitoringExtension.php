<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\FileLocator;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheckerRegistry;

/**
 * SuezPrometheusMonitoringExtension
 */
class SuezPrometheusMonitoringExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter(
            'suez_prometheus_monitoring.app_code',
            $mergedConfig['app_code']
        );

        $container->setParameter('suez_prometheus_bundle.health_path', $mergedConfig['healthcheck']['path']);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $this->loadCheckers($loader, $container, $mergedConfig['healthcheck']['checkers']);
    }

    protected function loadCheckers(LoaderInterface $loader, ContainerBuilder $container, array $mergedConfig)
    {
        if ($mergedConfig['elastic']) {
            $loader->load('checkers/elastic.yml');
        }

        if ($mergedConfig['influx']) {
            $loader->load('checkers/influx.yml');
        }

        if ($mergedConfig['mysql']) {
            $loader->load('checkers/mysql.yml');
        }

        if ($mergedConfig['mongo']) {
            $loader->load('checkers/mongo.yml');
        }

        if (!$container->has(HealthCheckerRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(HealthCheckerRegistry::class);

        foreach ($mergedConfig['custom'] as $customChecker) {
            $definition->addMethodCall('addChecker', array(new Reference($customChecker)));
        }
    }

    const DEFAULT_TWEEDEGOLF_CONFIG = [
        'storage_adapter_service' => 'TweedeGolf\\PrometheusClient\\Storage\\ApcuAdapter',
        'metrics_path' => '/metrics',
        'collectors' => [
            'suez_sf_app_call_count' => [
                'counter' => [
                    'labels' => ['app', 'route'],
                    'help' => 'number of call to the API'
                ]
            ],
            'suez_sf_app_response_code' => [
                'counter' => [
                    'labels' => ['app', 'route', 'status_code'],
                    'help' => 'number of call to the API per response status'
                ]
            ],
            'suez_sf_app_memory_usage' => [
                'gauge' => [
                    'labels' => ['app', 'route'],
                    'help' => 'Memory in byte per route',
                    'initializer' => 0
                ]
            ],
            'suez_sf_app_response_time' => [
                'gauge' => [
                    'labels' => ['app', 'route'],
                    'help' => 'Request execution time in seconds',
                    'initializer' => 0.0
                ]
            ],
            'suez_sf_app_response_size' => [
                'gauge' => [
                    'labels' => ['app', 'route'],
                    'help' => 'Request execution time in seconds',
                    'initializer' => 0
                ]
            ],
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = $this::DEFAULT_TWEEDEGOLF_CONFIG;
        foreach ($container->getExtensions() as $name => $extension) {
            if ($name === 'tweede_golf_prometheus') {
                $container->prependExtensionConfig($name, $config);
                break;
            }
        }
    }
}