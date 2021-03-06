<?php

namespace AppBundle\Command;

use AppBundle\Service\StockImporter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportStocksCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('stock_crawler:import_stocks')
            ->setDescription('Importing Stocks');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var StockImporter $importer */
        $importer = $this->getContainer()->get('stock_importer.stock_impoter');
        $importer->setOutput($output);
        $importer->import();
    }
}
