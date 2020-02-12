<?php

namespace AppBundle\Service;

use AppBundle\Model\IndexDocument\Stock;
use AppBundle\Repository\StockRepository;
use AppBundle\Service\StockImporter\StockImporterInterface;
use Doctrine\Common\Collections\ArrayCollection;
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

    /** @var ArrayCollection */
    private $importersList;

    /**
     * StockImporter constructor.
     * @param StockRepository $stockRepository
     */
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
        $this->importersList = new ArrayCollection();
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
        $this->output->writeln('StockImporter Service started');

        $list = $this->stockRepository->getStocksToImport();

        /** @var StockImporterInterface $importer */
        foreach($this->importersList as $importer)
            /** @var Stock $stock */
            foreach ($list as $stock) {
            {
                $importer->setOutput($this->output);
                $importer->import($stock);
            }
        }
    }

    public function addImporter(StockImporterInterface $importer)
    {
        $this->importersList->add($importer);
    }
}