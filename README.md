# Suez Prometheus Monitoring Bundle

**This bundle is no longer maintained. It has been replaced by :**

* [VdmHealthcheckBundle](https://github.com/3slab/VdmHealthcheckBundle) for the healthcheck part
* [VdmPrometheusBundle](https://github.com/3slab/VdmPrometheusBundle) for the metrics part

## Introduction

This bundle provides 2 routes to monitor :

* metrics : by wrapping [Tweedegolf Prometheus Bundle](https://github.com/tweedegolf/prometheus-bundle) in order to expose a metric endpoint with Prometheus formatted metrics.
* health : a route to be used with [Prometheus Blackbox Exporter](https://github.com/prometheus/blackbox_exporter) to monitor app health.

## Documentation

* [Installation](./Resources/doc/install.md)
* [Metrics](./Resources/doc/metrics.md)
* [Health](./Resources/doc/health.md)



