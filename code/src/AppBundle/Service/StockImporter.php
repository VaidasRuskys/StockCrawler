<?php

namespace AppBundle\Service;

use AppBundle\Model\IndexDocument\Stock;
use AppBundle\Repository\StockRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class StockImporter
{
    /** @var OutputInterface */
    private $output;

    /** @var LoggerInterface */
    private $logger;

    /** @var StockRepository */
    private $stockRepository;

    /**
     * StockImporter constructor.
     * @param StockRepository $stockRepository
     */
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function import()
    {
        $this->output->writeln('Importer Service started');

        $list = $this->stockRepository->getStocksToImport();

        /** @var Stock $stock */
        foreach ($list as $stock) {
            $this->output->writeln(sprintf('Start importing %s (%s)', $stock->getSymbol(), $stock->getName()));
            $this->logger->info(sprintf('Start importing %s (%s)', $stock->getSymbol(), $stock->getName()));
        }
    }
}