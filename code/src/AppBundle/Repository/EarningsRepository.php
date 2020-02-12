<?php

namespace AppBundle\Repository;

class EarningsRepository extends DocumentRepository
{
    protected function getIndex(): string
    {
        return 'earnings';
    }
}