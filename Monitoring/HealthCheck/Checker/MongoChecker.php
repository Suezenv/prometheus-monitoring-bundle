<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker;

use MongoDB\Client;
use MongoDB\Database;
use Psr\Log\LoggerInterface;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface;

/**
 * Class MongoChecker
 * Default implementation of a mongo checker
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker
 */
class MongoChecker implements HealthCheckInterface
{
    /**
     * @var Database
     */
    protected $db;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MongoChecker constructor.
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
            $this->logger->error('Health route : MongoDB service @mongo_database is missing');
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
    public function setConnectionSettings(string $host = null, int $port = 27017, string $dbName = null)
    {
        if ($this->db !== null) {
            return;
        }

        if ($host === null) {
            $this->logger->error('Health route : MongoDB connection settings %mongo_host% is missing');
            return;
        }

        if ($port === null) {
            $this->logger->error('Health route : MongoDB connection settings %mongo_port% is missing');
            return;
        }

        if ($dbName === null) {
            $this->logger->error('Health route : MongoDB connection settings %mongo_db% is missing');
            return;
        }

        try {
            $this->setDatabase((new Client("mongodb://$host:$port/$dbName"))->{$dbName});
        } catch (\Exception $e) {
            $this->logger->error($e);
        }
    }

    /**
     * Set connection Uri
     *
     * @param string $uri
     * @param string $dbName
     */
    public function setConnectionUri(string $uri = null, string $dbName = null)
    {
        if ($this->db !== null) {
            return;
        }

        if ($uri === null) {
            $this->logger->error('Health route : MongoDB connection settings %mongo_uri% is missing');
            return;
        }

        try {
            $this->setDatabase((new Client("$uri"))->{$dbName});
        } catch (\Exception $e) {
            $this->logger->error($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mongo';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        if (!$this->db) {
            $this->logger->error('Health route : MongoDB no connection configured');
            return false;
        }

        try {
            $cursor = $this->db->command(['ping' => 1]);
            $isUp = $cursor->toArray()[0]['ok'];
        } catch (\Exception $e) {
            $this->logger->error($e);
            $isUp = false;
        }

        return $isUp;
    }
}
