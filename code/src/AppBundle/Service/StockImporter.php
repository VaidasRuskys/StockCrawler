<?php

namespace AppBundle\Service;

use AppBundle\Model\Stock;
use AppBundle\Repository\StockRepository;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class StockImporter
{
    /** @var OutputInterface */
    private $output;

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
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function import()
    {
        $this->output->writeln('Importer Service started');

        $list = $this->stockRepository->getStocksToImport();

        /** @var Stock $stock */
        foreach ($list as $stock) {
            $this->output->writeln(sprintf('Start importing %s (%s)', $stock->getSymbol(), $stock->getName()));
        }
    }
}