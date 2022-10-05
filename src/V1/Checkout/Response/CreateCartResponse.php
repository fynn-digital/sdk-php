<?php

namespace Fynn\Sdk\V1\Checkout\Response;

class CreateCartResponse
{
    protected string $cartId;
    protected string $cartAuthenticationToken;

    public function __construct(array $data)
    {
        $this->cartId = $data['cartId'];
        $this->cartAuthenticationToken = $data['cartAuthenticationToken'];
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getCartAuthenticationToken(): string
    {
        return $this->cartAuthenticationToken;
    }
}
