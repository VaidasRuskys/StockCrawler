<?php

namespace AppBundle\Service\Parser;

class EmailReportParser
{
    public function parse($emailBody)
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($emailBody);

        $tableRows = $doc->getElementsByTagName("tr");

        var_dump($tableRows);

    }
}