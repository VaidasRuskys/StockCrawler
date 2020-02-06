<?php

namespace AppBundle\Logger;

use AppBundle\Model\IndexDocument\Log;
use AppBundle\Repository\LogRepository;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class IndexLogger extends AbstractLogger implements LoggerInterface
{
    /** @var LogRepository */
    protected $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function log($level, $message, array $context = array())
    {
        $logEntry = new Log();
        $logEntry->setLevel($level);
        $logEntry->setMessage($message);
        $logEntry->setContext(json_encode($context));

        $this->logRepository->addDocument($logEntry);
    }
}