<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Stock;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface StockImporterInterface
{
    public function import(Stock $stock);

    public function setOutput(OutputInterface $output);

    public function setLogger(LoggerInterface $logger);
}