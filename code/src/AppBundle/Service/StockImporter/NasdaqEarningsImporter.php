<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Stock;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NasdaqEarningsImporter implements StockImporterInterface
{
    /** @var OutputInterface */
    private $output;

    /** @var LoggerInterface */
    private $logger;

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

    public function import(Stock $stock)
    {
        $client = $this->buildClient();
        $response = $client->request('GET', sprintf('https://api.nasdaq.com/api/quote/%s/eps', $stock->getSymbol()));

        if($response->getStatusCode() == 200) {
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $latest = [];
            foreach($responseBody['data']['earningsPerShare'] as $earnings) {
                $earnings['type'] == "PreviousQuarter" && $latest = $earnings;
            }

            if (!empty($latest)) {
                $this->output->writeln(
                    sprintf(
                        "<info>NasdaqEarnings: %s %s estimaded %s reported %s</info>",
                        $stock->getSymbol(),
                        $latest['period'],
                        $latest['consensus'],
                        $latest['earnings']
                    )
                );
            }
        }
    }

    private function buildClient(): Client
    {
        return new Client();
    }
}