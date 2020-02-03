<?php

namespace AppBundle\Model\IndexDocument;

class Log extends IndexDocument
{
    /** @var string */
    protected $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}