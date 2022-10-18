<?php

namespace Fynn\Sdk\V1\Api\Response;

class ViolationItemResponse
{
    public function __construct(private readonly array $data)
    {
    }

    public function getPropertyPath(): string
    {
        return $this->data['propertyPath'];
    }

    public function getMessage(): string
    {
        return $this->data['message'];
    }

    public function getCode(): string
    {
        return $this->data['code'];
    }
}
