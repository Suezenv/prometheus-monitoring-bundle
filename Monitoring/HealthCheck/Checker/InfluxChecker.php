<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker;

use InfluxDB\Client;
use Psr\Log\LoggerInterface;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface;
use InfluxDB\Database;

/**
 * Class InfluxChecker
 * Default implementation of a influx checker with influxdb-php client
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker
 */
class InfluxChecker implements HealthCheckInterface
{
    /**
     * @var Database
     */
    protected $db = null;

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
     * @param Database $db
     */
    public function setDatabase(Database $db = null)
    {
        if ($this->db !== null) {
            return;
        }

        if ($db === null) {
            $this->logger->error('Health route : InfluxDB service @influxdb_database is missing');
            return;
        }

        $this->db = $db;
    }

    /**
     * Set connection Settings
     *
     * @param string $host
     * @param int $port
     * @param string $dbName
     */
    public function setConnectionSettings(string $host = null, int $port = 8086, string $dbName = null)
    {
        if ($this->db !== null) {
            return;
        }

        if ($host === null) {
            $this->logger->error('Health route : InfluxDB connection settings %influxdb_host% is missing');
            return;
        }

        if ($port === null) {
            $this->logger->error('Health route : InfluxDB connection settings %influxdb_port% is missing');
            return;
        }

        if ($dbName === null) {
            $this->logger->error('Health route : InfluxDB connection settings %influxdb_db% is missing');
            return;
        }

        $this->setDatabase(new Database($dbName, new Client($host, $port)));
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'influx';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        if (!$this->db) {
            $this->logger->error('Health route : InfluxDB no connection configured');
            return false;
        }

        try {
            $isUp = $this->db->exists();
        } catch (\Exception $e) {
            $this->logger->error($e);
            $isUp = false;
        }

        return $isUp;
    }
}