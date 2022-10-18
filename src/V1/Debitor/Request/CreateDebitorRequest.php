<?php

namespace Fynn\Sdk\V1\Debitor\Request;

class CreateDebitorRequest
{
    protected string $email;
    protected string $firstName;
    protected string $lastName;
    protected ?string $company;
    protected ?string $vatId;
    protected ?string $mobilephoneNumber;
    protected ?string $commercialRegisterName;
    protected ?string $commercialRegisterNumber;
    protected ?string $datevNumber;
    protected ?string $countryCode;
    protected string $language;
    protected ?string $currencyCode;
    protected ?string $customerNumber = null;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        ?string $company = null,
        ?string $vatId = null, // will be validated by the API if set
        ?string $mobilephoneNumber = null,
        ?string $commercialRegisterName = null,
        ?string $commercialRegisterNumber = null,
        ?string $datevNumber = null,
        ?string $countryCode = 'DE',
        string $language = 'de',
        ?string $currencyCode = null, // will use default currency if not set
    ) {
        if ($email === '' || $firstName === '' || $lastName === '') {
            throw new \InvalidArgumentException('Email must not be empty');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is not valid');
        }

        if (!in_array($language, ['de', 'en'])) {
            throw new \InvalidArgumentException('Invalid language');
        }

        if (strlen($countryCode) !== 2) {
            throw new \InvalidArgumentException('Invalid country code');
        }

        if ($currencyCode !== null && strlen($currencyCode) !== 3) {
            throw new \InvalidArgumentException('Invalid currency code');
        }

        if ($company !== null && ($vatId === null || strlen($vatId) === 0)) {
            throw new \InvalidArgumentException('VatId is required if company is set');
        }

        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->vatId = $vatId;
        $this->mobilephoneNumber = $mobilephoneNumber;
        $this->commercialRegisterName = $commercialRegisterName;
        $this->commercialRegisterNumber = $commercialRegisterNumber;
        $this->datevNumber = $datevNumber;
        $this->countryCode = $countryCode;
        $this->language = $language;
        $this->currencyCode = $currencyCode;
    }

    public function setCustomCustomerNumber(string $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'company' => $this->company,
            'language' => $this->language,
            'datevDebitorId' => $this->datevNumber,
            'vatId' => $this->vatId,
            'countryCode' => $this->countryCode,
            'currencyCode' => $this->currencyCode,
            'mobilephoneNumber' => $this->mobilephoneNumber,
            'commercialRegister' => [
                'name' => $this->commercialRegisterName,
                'id' => $this->commercialRegisterNumber,
            ],
            'invoiceEmailAddresses' => [
                [
                    'email' => $this->email,
                    'receiverName' => $this->firstName . ' ' . $this->lastName,
                    'default' => true,
                ],
            ],
            'defaultEmailAddresses' => [
                [
                    'email' => $this->email,
                    'receiverName' => $this->firstName . ' ' . $this->lastName,
                    'default' => true,
                ],
            ],
        ];
    }
}
