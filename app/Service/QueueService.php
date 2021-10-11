<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\AsyncQueue\JobInterface;

class QueueService
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    /**
     * Push a job to queue.
     *
     * @param JobInterface $job
     * @param integer $delay
     * @return boolean
     */
    public function push(JobInterface $job, int $delay = 0): bool
    {
        return $this->driver->push($job, $delay);
    }

    /**
     * Return info for current queue.
     *
     * @return array
     */
    public function info(): array
    {
        return $this->driver->info();
    }
}
