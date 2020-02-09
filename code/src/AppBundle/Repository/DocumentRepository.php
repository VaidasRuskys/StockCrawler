<?php

namespace AppBundle\Repository;

use AppBundle\Model\IndexDocument\IndexDocument;
use Elasticsearch\Client;

abstract class DocumentRepository
{
    /** @var Client */
    private $client;

    /** @var string */
    private $documentClass;

    public function __construct(Client $client, string $documentClass)
    {
        $this->client = $client;
        $this->documentClass = $documentClass;
    }

    abstract protected function getIndex(): string;

    protected function getClient(): Client
    {
        return $this->client;
    }

    public function addDocument(IndexDocument $document)
    {
        return $this->getClient()->index([
            'index' => $this->getIndex(),
            'body'  => $document->getBody()
        ]);
    }

    public function getDocument(string $id): IndexDocument
    {
        /** @var IndexDocument $doc */
        $doc = new $this->documentClass;
        $result = $this->getClient()->get( [
            'index' => $this->getIndex(),
            'id'    => $id
        ]);

        return $doc->assignData($result['_source']);
    }
}