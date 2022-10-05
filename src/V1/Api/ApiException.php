<?php

namespace Fynn\Sdk\V1\Api;

class ApiException extends \Exception
{
    public static function fromThrowable(\Throwable $throwable): self
    {
        return new self($throwable->getMessage(), $throwable->getCode(), $throwable);
    }
}
