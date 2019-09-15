<?php

namespace AppBundle\Model;

class EmailReport
{
    /** @var string */
    private $accountNumber;

    /** @var bool */
    private $demoAccount = false;

    /** @var float */
    private $equity;

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return bool
     */
    public function isDemoAccount()
    {
        return $this->demoAccount;
    }

    /**
     * @param bool $demoAccount
     */
    public function setDemoAccount($demoAccount)
    {
        $this->demoAccount = $demoAccount;
    }

    /**
     * @return float
     */
    public function getEquity()
    {
        return $this->equity;
    }

    /**
     * @param float $equity
     */
    public function setEquity($equity)
    {
        $this->equity = $equity;
    }
}