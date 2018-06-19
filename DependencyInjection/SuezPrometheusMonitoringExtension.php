<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

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

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');
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