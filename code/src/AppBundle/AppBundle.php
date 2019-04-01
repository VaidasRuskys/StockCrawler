<?php

namespace AppBundle;

use AppBundle\DependencyInjection\StockCrawlerExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new StockCrawlerExtension();
    }
}
