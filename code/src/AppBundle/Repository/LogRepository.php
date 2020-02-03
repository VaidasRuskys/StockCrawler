<?php

namespace AppBundle\Repository;

class LogRepository extends DocumentRepository
{
    protected function getIndex(): string
    {
        return 'logs';
    }

}