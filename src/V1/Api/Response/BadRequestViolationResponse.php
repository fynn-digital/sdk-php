<?php

namespace Fynn\Sdk\V1\Api\Response;

class BadRequestViolationResponse
{
    public function __construct(private readonly array $data)
    {
    }

    public function getTitle(): string
    {
        return $this->data['title'];
    }

    public function getDetail(): string
    {
        return $this->data['detail'];
    }

    /**
     * @return ViolationItemResponse[]
     */
    public function getViolations(): array
    {
        return array_map(
            fn (array $violation) => new ViolationItemResponse($violation),
            $this->data['violations']
        );
    }
}
