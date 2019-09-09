<?php

namespace AppBundle\Command;

use AppBundle\Service\EmailReportImporter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportEmailReportsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('stock_crawler:import_email_reports');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EmailReportImporter $importer */
        $importer = $this->getContainer()->get('stock_importer.email_report_importer');
        $importer->setOutput($output);
        $importer->import();
    }
}
