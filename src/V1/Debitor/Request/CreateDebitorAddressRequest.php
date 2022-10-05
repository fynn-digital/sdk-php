<?php

namespace Fynn\Sdk\V1\Debitor\Request;

class CreateDebitorAddressRequest
{
    public const TYPE_INVOICE = 'TYPE_INVOICE';
    public const TYPE_DEFAULT = 'TYPE_DEFAULT';
    protected string $salutation;
    protected ?string $firstname;
    protected ?string $lastname;
    protected ?string $company;
    protected string $street;
    protected string $housenumber;
    protected string $zip;
    protected string $city;
    protected string $country;
    protected string $type;
    protected bool $isDefault;

    public function __construct(
        string $salutation,
        ?string $firstname,
        ?string $lastname,
        ?string $company,
        string $street,
        string $housenumber,
        string $zip,
        string $city,
        string $country = 'DE',
        string $type = 'TYPE_INVOICE',
        bool $isDefault = true
    ) {
        if (!in_array($type, [self::TYPE_INVOICE, self::TYPE_DEFAULT])) {
            throw new \InvalidArgumentException('Invalid type');
        }

        if (strlen($country) !== 2) {
            throw new \InvalidArgumentException('Invalid country');
        }

        if ($company === null && ($firstname === null || $lastname === null)) {
            throw new \InvalidArgumentException('Invalid name');
        }

        $this->salutation = $salutation;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->street = $street;
        $this->housenumber = $housenumber;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
        $this->type = $type;
        $this->isDefault = $isDefault;
    }

    public function toArray(): array
    {
        return [
            'salutation' => $this->salutation,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'company' => $this->company,
            'street' => $this->street,
            'housenumber' => $this->housenumber,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
            'type' => $this->type,
            'isDefault' => $this->isDefault,
        ];
    }
}
