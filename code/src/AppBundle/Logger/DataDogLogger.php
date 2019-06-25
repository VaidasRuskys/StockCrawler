<?php

namespace AppBundle\Logger;

use Okvpn\Bundle\DatadogBundle\Client\DatadogClient;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class DataDogLogger extends AbstractLogger implements LoggerInterface
{
    /** @var DatadogClient */
    private $dataDogClient;

    /**
     * DataDogLogger constructor.
     * @param DatadogClient $dataDogClient
     */
    public function __construct(DatadogClient $dataDogClient)
    {
        $this->dataDogClient = $dataDogClient;
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        $this->dataDogClient->event($level, $message, $context, [$level]);
    }
}