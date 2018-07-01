# Metrics

## Description

This bundle wraps the [Tweedegolf Prometheus Bundle](https://github.com/tweedegolf/prometheus-bundle)

It provides a `/metrics` route where you can monitor (in Prometheus format) :

* `suez_sf_app_call_count` (counter) : number of call to the API
* `suez_sf_app_memory_usage` (counter) : Memory in byte per route
* `suez_sf_app_response_code` (gauge) : number of call to the API per response code
* `suez_sf_app_response_time` (gauge) : Request execution time in seconds
* `suez_sf_app_response_size` (gauge) : Response size in bytes

Exemple of response : 

```
# TYPE apcu_num_slots gauge
apcu_num_slots 4099

# TYPE apcu_ttl gauge
apcu_ttl 0

# TYPE apcu_num_hits gauge
apcu_num_hits 311

# TYPE apcu_num_misses gauge
apcu_num_misses 295

# TYPE apcu_start_time gauge
apcu_start_time 1530454581

# HELP suez_sf_app_call_count number of call to the API
# TYPE suez_sf_app_call_count counter
suez_sf_app_call_count{app="my-app-label",route=""} 1
suez_sf_app_call_count{app="my-app-label",route="tweede_golf_prometheus_metrics"} 4
suez_sf_app_call_count{app="my-app-label",route="_wdt"} 8
suez_sf_app_call_count{app="my-app-label",route="suez_prometheus_monitoring_health"} 50

# HELP suez_sf_app_response_code number of call to the API per response code
# TYPE suez_sf_app_response_code counter
suez_sf_app_response_code{app="my-app-label",route="suez_prometheus_monitoring_health",status_code="200"} 10
suez_sf_app_response_code{app="my-app-label",route="tweede_golf_prometheus_metrics",status_code="200"} 4
suez_sf_app_response_code{app="my-app-label",route="suez_prometheus_monitoring_health",status_code="500"} 7
suez_sf_app_response_code{app="my-app-label",route="_wdt",status_code="200"} 8
suez_sf_app_response_code{app="my-app-label",route="suez_prometheus_monitoring_health",status_code="503"} 33
suez_sf_app_response_code{app="my-app-label",route="",status_code="404"} 1

# HELP suez_sf_app_memory_usage Memory in byte per route
# TYPE suez_sf_app_memory_usage gauge
suez_sf_app_memory_usage{app="my-app-label",route="suez_prometheus_monitoring_health"} 19136512
suez_sf_app_memory_usage{app="my-app-label",route=""} 2097152
suez_sf_app_memory_usage{app="my-app-label",route="tweede_golf_prometheus_metrics"} 2097152
suez_sf_app_memory_usage{app="my-app-label",route="_wdt"} 14680064

# HELP suez_sf_app_response_time Request execution time in seconds
# TYPE suez_sf_app_response_time gauge
suez_sf_app_response_time{app="my-app-label",route="tweede_golf_prometheus_metrics"} 53.756952285767
suez_sf_app_response_time{app="my-app-label",route="_wdt"} 218.27602386475
suez_sf_app_response_time{app="my-app-label",route="suez_prometheus_monitoring_health"} 425.01401901245
suez_sf_app_response_time{app="my-app-label",route=""} 60.12487411499

# HELP suez_sf_app_response_size Response size in bytes
# TYPE suez_sf_app_response_size gauge
suez_sf_app_response_size{app="my-app-label",route="suez_prometheus_monitoring_health"} 56
suez_sf_app_response_size{app="my-app-label",route=""} 4721
suez_sf_app_response_size{app="my-app-label",route="tweede_golf_prometheus_metrics"} 2234
suez_sf_app_response_size{app="my-app-label",route="_wdt"} 19509
```

## Configuration

**The default configuration used APCU to store the metrics. You can change this to use another storage thanks to the tweedegolf settings**

In `config/packages/tweede_golf_prometheus.yaml` :

```yaml
tweede_golf_prometheus:
    storage_adapter_service: TweedeGolf\PrometheusClient\Storage\ApcuAdapter
```

Please refer to the [Tweedegolf Prometheus Bundle](https://github.com/tweedegolf/prometheus-bundle) documentation for all the configuration settings like :

* `tweede_golf_prometheus.metrics_path` : to change the default `/metrics` path
* `tweede_golf_prometheus.collectors` : define custom metric collector service
* `tweede_golf_prometheus.storage_adapter_service` : change metric storage