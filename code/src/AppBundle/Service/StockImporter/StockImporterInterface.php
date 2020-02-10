<?php

namespace AppBundle\Service\StockImporter;

use AppBundle\Model\IndexDocument\Stock;

interface StockImporterInterface
{
    public function import(Stock $sock);
}