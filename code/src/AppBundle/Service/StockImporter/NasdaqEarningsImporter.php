<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Earnings;
use AppBundle\Model\IndexDocument\Stock;
use AppBundle\Repository\EarningsRepository;
use GuzzleHttp\Client;

class NasdaqEarningsImporter extends AbstractStockImporter implements StockImporterInterface
{
    /** @var EarningsRepository */
    private $earningsRepository;

    public function __construct(EarningsRepository $earningsRepository)
    {
        parent::__construct();
        $this->earningsRepository = $earningsRepository;
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