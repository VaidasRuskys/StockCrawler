<?php

namespace AppBundle\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class DataDogLogger extends AbstractLogger implements LoggerInterface
{
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}