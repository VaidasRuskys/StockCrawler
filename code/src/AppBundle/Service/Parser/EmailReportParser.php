<?php

namespace AppBundle\Service\Parser;

use AppBundle\Model\EmailReport;
use \DOMElement;
use \DOMNodeList;
use \DOMXPath;
use \DOMDocument;

class EmailReportParser
{
    public function parse($emailBody)
    {
        $report = new EmailReport();

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($emailBody);

        $xpath = new DOMXPath($doc);

        $accountNumberResults = $xpath->query('//*[contains(text(),\'A/C No:\')]');
        /** @var DOMElement $row */
        foreach($accountNumberResults as $row) {
            $accountNumber = trim(str_replace('A/C No:', '', $row->nodeValue));
            if(strpos($accountNumber, ' (DEMO)') !== false) {
                $report->setDemoAccount(true);
                $accountNumber = str_replace(' (DEMO)', '', $accountNumber);
            }
            $report->setAccountNumber($accountNumber);
        }

        /** @var DOMNodeList $equityResult */
        $equityResult = $xpath->query('//*[contains(text(),\'Equity\')]');

        /** @var DOMElement $row */
        foreach($equityResult as $row) {
            if($row->nodeValue == ' Equity:') {
                $report->setEquity($this->stringToFloat($row->parentNode->childNodes[6]->nodeValue));
            }
        }
        return $report;
    }

    private function stringToFloat($string)
    {
        return floatval(str_replace([' '],[''], trim($string)));
    }
}