<?php

namespace AppBundle\Model\IndexDocument;

class Earnings extends IndexDocument
{
    /** @var string */
    protected $stockSymbol;

    /** @var string */
    protected $type;

    /** @var array */
    protected $list;

    /**
     * @return string
     */
    public function getStockSymbol(): string
    {
        return $this->stockSymbol;
    }

    /**
     * @param string $stockSymbol
     */
    public function setStockSymbol(string $stockSymbol): void
    {
        $this->stockSymbol = $stockSymbol;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }
}