# Suez Prometheus Monitoring Bundle

## Introduction

This bundle wraps [Tweedegolf Prometheus Bundle](https://github.com/tweedegolf/prometheus-bundle) in order to expose a metric endpoint with Prometheus formatted metrics.

## Installation

Add to your `composer.json` :

```json
{
  "require": {
    "suez/prometheus-monitoring-bundle": "dev-master"
  },
  "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/Suezenv/prometheus-monitoring-bundle"
      }
    ]
}
```

And run `composer install`

Then enable the bundle into your Symfony project **with its dependency to the Tweedegolf bundle**, in `config/bundles.php` :

```php
return [
    TweedeGolf\PrometheusBundle\TweedeGolfPrometheusBundle::class =>  ['all' => true],
    Suez\Bundle\PrometheusMonitoringBundle\SuezPrometheusMonitoringBundle::class =>  ['all' => true],
];
```

Enable the metric route in `config/routes.yaml` :

```yaml
tweede_golf_prometheus:
    resource: "@TweedeGolfPrometheusBundle/Resources/config/routing.yml"
    prefix: /
```

And gives an identifier to label your app metrics in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  app_code: 'my-app-label'
```

**Now every SF route will be monitored and you can view the resulting metrics on the /metric url**

## Configuration

**The default configuration used APCU to store the metrics. You can change this to use another storage thanks to the tweedegolf settings**

In `config/packages/tweede_golf_prometheus.yaml` :

```yaml
tweede_golf_prometheus:
    storage_adapter_service: TweedeGolf\PrometheusClient\Storage\ApcuAdapter
```

