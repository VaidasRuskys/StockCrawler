<?php

namespace AppBundle\Service\Factory;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class IndexClientFactory
{
    public function create(array $hosts): Client
    {
        return $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }
}