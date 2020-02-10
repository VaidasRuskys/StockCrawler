<?php

namespace AppBundle\Repository;

use AppBundle\Model\IndexDocument\Stock;
use Doctrine\Common\Collections\ArrayCollection;

class StockRepository
{
    public function getStocksToImport()
    {
        $list = new ArrayCollection();

        $stockFB = new Stock();
        $stockFB->setSymbol('FB');
        $stockFB->setName('Facebook');
        $list->add($stockFB);

        $stockNFLX = new Stock();
        $stockNFLX->setSymbol('NFLX');
        $stockNFLX->setName('Netflix');
        $list->add($stockNFLX);

        $stockMSFT = new Stock();
        $stockMSFT->setSymbol('MSFT');
        $stockMSFT->setName('Microsoft');
        $list->add($stockMSFT);

        return $list;
    }
}