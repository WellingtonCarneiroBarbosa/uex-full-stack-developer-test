<?php

namespace App\Exceptions;

use Exception;

class CepProviderUnavailable extends Exception
{
    public function __construct(string $provider, int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct("The provider {$provider} is unavailable", $code, $previous);
    }
}
