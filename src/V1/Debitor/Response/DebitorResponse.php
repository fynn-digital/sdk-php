<?php

namespace Fynn\Sdk\V1\Debitor\Response;

class DebitorResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
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

    public function getCustomerNumber(): string
    {
        return $this->data['customerNumber'];
    }

    public function getLanguage(): string
    {
        return $this->data['language'];
    }

    public function getCurrencyCode(): string
    {
        return $this->data['currencyCode'];
    }

    public function getVatId(): ?string
    {
        return $this->data['vatId'] ?? null;
    }

    public function getDatevNumber(): ?string
    {
        return $this->data['datevDebitorId'] ?? null;
    }

    public function getStatus(): string
    {
        return $this->data['status'];
    }

    public function getMobilephoneNumber(): ?string
    {
        return $this->data['mobilephoneNumber'] ?? null;
    }

    public function getCountryCode(): string
    {
        return $this->data['countryCode'];
    }

    public function getIsVatIdValid(): bool
    {
        return $this->data['isVatIdValid'];
    }

    public function getCommercialRegisterName(): ?string
    {
        return $this->data['commercialRegister']['name'] ?? null;
    }

    public function getCommercialRegisterNumber(): ?string
    {
        return $this->data['commercialRegister']['id'] ?? null;
    }
}
