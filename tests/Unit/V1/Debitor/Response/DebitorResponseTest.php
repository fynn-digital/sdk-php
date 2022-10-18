<?php

namespace Unit\V1\Debitor\Response;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Debitor\Response\DebitorResponse;

class DebitorResponseTest extends AbstractUnitTest
{
    public function testBuildFromArray(): void
    {
        $debitor = new DebitorResponse(json_decode(file_get_contents(__DIR__ . '/../_responses/get_debitor.json'), true)['data']);

        $this->assertSame('f1d7d286-b88b-4849-9cb3-e30dc22f9747', $debitor->getDebitorId());
        $this->assertSame('Finn', $debitor->getFirstName());
        $this->assertSame('TestKunde', $debitor->getLastName());
        $this->assertSame('de', $debitor->getLanguage());
        $this->assertSame('EUR', $debitor->getCurrencyCode());
        $this->assertSame('00010001', $debitor->getDatevNumber());
        $this->assertSame('DE123456789', $debitor->getVatId());
        $this->assertSame('STATUS_ACTIVE', $debitor->getStatus());
        $this->assertNull($debitor->getCommercialRegisterName());
        $this->assertNull($debitor->getCommercialRegisterNumber());
        $this->assertNull($debitor->getMobilephoneNumber());
        $this->assertSame('Finn GmbH', $debitor->getCompany());
        $this->assertSame('K0000000000010002', $debitor->getCustomerNumber());
        $this->assertSame('DE', $debitor->getCountryCode());
        $this->assertTrue($debitor->getIsVatIdValid());
    }
}
