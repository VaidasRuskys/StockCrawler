<?php


namespace AppBundle\Repository;

use AppBundle\Model\Stock;
use Doctrine\Common\Collections\ArrayCollection;

class StockRepository
{
    public function getStocksToImport()
    {
        $list = new ArrayCollection();
        $list->add(new Stock('FB', 'Facebook'));
        $list->add(new Stock('NFLX', 'Netflix'));

        return $list;
    }
}