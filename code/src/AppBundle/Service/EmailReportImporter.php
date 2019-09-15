<?php

namespace AppBundle\Service;

use AppBundle\Repository\EmailRepository;
use AppBundle\Service\Parser\EmailReportParser;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class EmailReportImporter
{
    /** @var OutputInterface */
    private $output;

    /** @var LoggerInterface */
    private $logger;

    /** @var EmailReportReceiver */
    private $emailReceiver;

    /** @var EmailReportParser */
    private $emailReportParser;

    public function __construct(EmailReportReceiver $emailReceiver, EmailReportParser $emailReportParser)
    {
        $this->emailReceiver = $emailReceiver;
        $this->emailReportParser = $emailReportParser;
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
    }

    public function import()
    {
        try {
            $this->output->writeln('<info>Importer started</info>');
            $rawEmails = $this->emailReceiver->receive();
            foreach($rawEmails as $rawEmail) {
                $emailReport = $this->emailReportParser->parse($rawEmail);
                var_dump($emailReport);
            }
            $this->output->writeln(sprintf('get %d emails', $rawEmails->count()));
        } catch (\Exception $exception) {
            $this->output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
        }
        $this->output->writeln('<info>Importer ended</info>');
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
}