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

    /** @var EmailRepository */
    private $emailRepository;

    /** @var EmailReportParser */
    private $emailParser;

    public function __construct(EmailRepository $emailRepository, EmailReportParser $emailParser)
    {
        $this->emailRepository = $emailRepository;
        $this->emailParser = $emailParser;
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
    }

    public function import()
    {
        try {
            $this->output->writeln('<info>Importer started</info>');
            $emails = $this->emailRepository->getEmails();
            foreach($emails as $email) {
                //$parsed = $this->emailParser->parse($email['body']);
            }
            $this->output->writeln(sprintf('get %d emails', $emails->count()));
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