<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Stock;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractStockImporter
{
    abstract public function import(Stock $stock);

    /** @var OutputInterface */
    protected $output;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct()
    {
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
    }

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}