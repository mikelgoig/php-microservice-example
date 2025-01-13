<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

abstract class DomainException extends \DomainException
{
    protected function __construct(string $message)
    {
        parent::__construct($message);
    }
}
