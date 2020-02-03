<?php

namespace AppBundle\Model\IndexDocument;

class IndexDocument
{
    public function getBody(): array
    {
        $body = [];
        foreach (get_object_vars ( $this ) as $propertyName => $propertyValue) {
            $body[$propertyName] = $propertyValue;
        }

        return $body;
    }

    public function assignData(array $data): IndexDocument
    {
        foreach($data as $propertyName => $propertyValue)
        {
            $this->{'set'.$propertyName}($propertyValue);
        }

        return $this;
    }
}