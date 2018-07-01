<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker;

use Elastica\Index;
use Elastica\Client;
use Psr\Log\LoggerInterface;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface;

/**
 * Class ElasticChecker
 * Default implementation of a elastic checker with fos elastica
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker
 */
class ElasticChecker implements HealthCheckInterface
{
    /**
     * @var Index
     */
    protected $index = null;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * InfluxChecker constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Index $index
     */
    public function setIndex(Index $index = null)
    {
        if ($this->index !== null) {
            return;
        }

        if ($index === null) {
            $this->logger->error('Health route : Elasticsearch service is missing');
            return;
        }

        $this->index = $index;
    }

    /**
     * Set connection Settings
     *
     * @param string $host
     * @param int $port
     * @param string $index
     */
    public function setConnectionSettings(string $host = null, int $port = 9200, string $indexName = null)
    {
        if ($this->index !== null) {
            return;
        }

        if ($host === null) {
            $this->logger->error('Health route : Elasticsearch connection settings %elastic_host% is missing');
            return;
        }

        if ($port === null) {
            $this->logger->error('Health route : Elasticsearch connection settings %elastic_port% is missing');
            return;
        }

        if ($indexName === null) {
            $this->logger->error('Health route : Elasticsearch connection settings %elastic_index% is missing');
            return;
        }

        $this->setIndex(new Index(new Client(['host' => $host, 'port' => $port]), $indexName));

    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'elastic';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        if (!$this->index) {
            $this->logger->error('Health route : Elasticsearch no connection configured');
            return false;
        }

        try {
            $isUp = $this->index->exists();
        } catch (\Exception $e) {
            $this->logger->error($e);
            $isUp = false;
        }

        return $isUp;
    }
}