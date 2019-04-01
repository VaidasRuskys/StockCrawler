<?php

namespace AppBundle\Model;

class Stock
{
    /** @var string */
    private $symbol;

    /** @var string */
    private $name;

    /**
     * Stock constructor.
     * @param string $symbol
     * @param string $name
     */
    public function __construct($symbol, $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}