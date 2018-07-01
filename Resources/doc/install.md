# Installation

Note : the default configuration of the tweedegolf metric storage is APCU so you need to have this extension installed if you use the default configuration 

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

Enable the health route in `config/routes.yaml` :

```yaml
suez_prometheus_monitoring:
    resource: "@SuezPrometheusMonitoringBundle/Resources/config/routing.yml"
    prefix: /
```

And gives an identifier to label your app metrics in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  app_code: 'my-app-label'
```

**Now every SF route will be monitored and you can view the resulting metrics on the `/metric` url. Moreover, you have a `/health` url to monitor app health.**