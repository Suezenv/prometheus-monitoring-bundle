# Health

## Description

The health part provides a `/health` route where you can monitor the health of your app. The goal is to test that SF answers correctly and that all dependencies are up.

It provides out of the box an implementation to check these dependencies :

* Elasticsearch
* Mongo
* SQL (via Doctrine)
* InfluxDB

The `/health` route answer either with code 200 (app ok) or 503 (service unavailable) with a JSON response :

```json
{
    "elastic": true,
    "influx": true,
    "mysql": false,
    "mongo": true
}
```

## Dependencies' Health

### Elasticsearch

To enable it, in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      checkers:
          elastic: true
```

You have 2 ways to auto wire your elasticsearch configuration.

Either define these variable :

```yaml
parameters:
    elastic_host: elasticsearch
    elastic_port: 9200
    elastic_index: myindex
```

Or have a [FOSElasticaBundle](https://github.com/FriendsOfSymfony/FOSElasticaBundle) default connection :

```yaml
fos_elastica:
    clients:
        default: { host: elasticsearch, port: 9200 }
    indexes:
        myindex: ~
```

### Mongo

To enable it, in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      checkers:
          mongo: true
```

You have 2 ways to auto wire your mongo configuration.

Either define these variable :

```yaml
parameters:
    mongo_host: mongo
    mongo_port: 27017
    mongo_db: dbname
```

Or have a `\MongoDB\Database` service with the name `@mongo_database`


### SQL (via Doctrine)

To enable it, in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      checkers:
          mysql: true
```

You need to have a default doctrine connection setup (It should be enough to define the variable `DATABASE_URL` in the `.env` file)

### InfluxDB

To enable it, in `config/packages/suez_prometheus_monitoring.yml` :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      checkers:
          influx: true
```

You have 2 ways to auto wire your influx configuration.

Either define these variable :

```yaml
parameters:
    influxdb_host: influx
    influxdb_port: 8086
    influxdb_db: dbname
```


Or have a `\InfluxDB\Database` service with the name `@influxdb_database` or `@algatux_influx_db.connection.http` (if you use [Algatux Influxdb Bundle](https://github.com/Algatux/influxdb-bundle))

## Configuration

You can change the `/health` route path with this settings :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      path: '/health'
```

You can add your own custom health check by adding custom services that implements the interface `\Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface` :

```yaml
suez_prometheus_monitoring:
  healthcheck:
      checkers:
          custom:
              - my_custom_healthcheck_service
```
    