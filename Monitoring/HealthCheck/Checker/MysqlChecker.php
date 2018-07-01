<?php

namespace Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker;

use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\HealthCheckInterface;

/**
 * Class MysqlChecker
 * Default implementation of a mysql checker
 *
 * @package Suez\Bundle\PrometheusMonitoringBundle\Monitoring\HealthCheck\Checker
 */
class MysqlChecker implements HealthCheckInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MysqlChecker constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mysql';
    }

    /**
     * {@inheritdoc}
     */
    public function check(): bool
    {
        try {
            $isUp = $this->connection->ping();
        } catch (\Exception $e) {
            $this->logger->error($e);
            $isUp = false;
        }

        return $isUp;
    }
}