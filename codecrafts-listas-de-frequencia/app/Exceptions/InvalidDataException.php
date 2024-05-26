<?php

namespace CodeCrafts\ListasDeFrequencia\App\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
