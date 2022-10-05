<?php

namespace Fynn\Sdk\V1\Debitor\Response;

class DebitorAddressResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): string
    {
        return $this->data['id'];
    }

    public function getDebitorId(): string
    {
        return $this->data['debitorId'];
    }

    public function getFirstName(): string
    {
        return $this->data['firstname'];
    }

    public function getLastName(): string
    {
        return $this->data['lastname'];
    }

    public function getCompany(): ?string
    {
        return $this->data['company'] ?? null;
    }

    public function getStreet(): string
    {
        return $this->data['street'];
    }

    public function getHousenumber(): string
    {
        return $this->data['housenumber'];
    }

    public function getZip(): string
    {
        return $this->data['zip'];
    }

    public function getCity(): string
    {
        return $this->data['city'];
    }

    public function getCountry(): string
    {
        return $this->data['country'];
    }

    /**
     * @return string TYPE_INVOICE|TYPE_DEFAULT
     */
    public function getType(): string
    {
        return $this->data['type'];
    }

    public function isDefault(): bool
    {
        return $this->data['isDefault'];
    }

    public function getSalutation(): string
    {
        return $this->data['salutation'];
    }
}
