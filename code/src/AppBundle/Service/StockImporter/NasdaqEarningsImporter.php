<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Earnings;
use AppBundle\Model\IndexDocument\Stock;
use AppBundle\Repository\EarningsRepository;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class NasdaqEarningsImporter implements StockImporterInterface
{
    /** @var OutputInterface */
    private $output;

    /** @var LoggerInterface */
    private $logger;

    /** @var EarningsRepository */
    private $earningsRepository;

    public function __construct(EarningsRepository $earningsRepository)
    {
        $this->output = new NullOutput();
        $this->logger = new NullLogger();
        $this->earningsRepository = $earningsRepository;
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

                $earnings = new Earnings();
                $earnings->setStockSymbol($stock->getSymbol());
                $earnings->setType('Quarter');
                $earnings->setList(
                    [
                        'period' => $latest['period'],
                        'estimaded' => $latest['consensus'],
                        'reported' => $latest['earnings']
                    ]
                );

                $this->earningsRepository->addDocument($earnings);
            }
        }
    }

    private function buildClient(): Client
    {
        return new Client();
    }
}