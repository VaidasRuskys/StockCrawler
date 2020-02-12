<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Stock;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class TipranksAnalystConsensusImporter implements StockImporterInterface
{
    /** @var OutputInterface */
    private $output;

    /** @var LoggerInterface */
    private $logger;

    public function __construct()
    {
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
    }

    public function import(Stock $stock)
    {
        $client = $this->buildClient();
        $response = $client->request('GET', sprintf('https://www.tipranks.com/api/stocks/getData/?name=%s&benchmark=1&period=3&break=1581534079722', $stock->getSymbol()));

        if($response->getStatusCode() == 200) {
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $this->output->writeln(
                sprintf(
                    "<info>Tipranks Analyst Consensus: %s %s(%s)</info>",
                    $stock->getSymbol(),
                    $responseBody['portfolioHoldingData']['analystConsensus']['consensus'],
                    $responseBody['portfolioHoldingData']['analystConsensus']['rawConsensus']
                )
            );

        }
    }

    private function buildClient(): Client
    {
        return new Client();
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}