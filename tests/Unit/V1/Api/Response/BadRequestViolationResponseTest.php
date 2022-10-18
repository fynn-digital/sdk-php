<?php

namespace Fynn\Sdk\Unit\V1\Api\Response;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Api\Response\BadRequestViolationResponse;

/**
 * @covers \Fynn\Sdk\V1\Api\Response\BadRequestViolationResponse
 */
class BadRequestViolationResponseTest extends AbstractUnitTest
{
    public function testGetTitle(): void
    {
        $response = new BadRequestViolationResponse([
            'title' => 'title',
            'detail' => 'detail',
            'violations' => [],
        ]);

        $this->assertSame('title', $response->getTitle());
    }

    public function testGetDetail(): void
    {
        $response = new BadRequestViolationResponse([
            'title' => 'title',
            'detail' => 'detail',
            'violations' => [],
        ]);

        $this->assertSame('detail', $response->getDetail());
    }

    public function testGetViolations(): void
    {
        $response = new BadRequestViolationResponse([
            'title' => 'title',
            'detail' => 'detail',
            'violations' => [
                [
                    'propertyPath' => 'propertyPath',
                    'message' => 'message',
                    'code' => 'code',
                ],
            ],
        ]);

        $violations = $response->getViolations();

        $this->assertCount(1, $violations);
        $this->assertInstanceOf(\Fynn\Sdk\V1\Api\Response\ViolationItemResponse::class, $violations[0]);
        $this->assertSame('propertyPath', $violations[0]->getPropertyPath());
        $this->assertSame('message', $violations[0]->getMessage());
        $this->assertSame('code', $violations[0]->getCode());
    }

    public function testCreateFromResponseJson(): void
    {
        $response = new BadRequestViolationResponse(
            json_decode(file_get_contents(__DIR__ . '/../_responses/bad_request_response.json'), true)
        );

        $this->assertSame('An error occurred', $response->getTitle());
        $this->assertSame("firstname: Dieser Wert sollte nicht leer sein.\nlastname: Dieser Wert sollte nicht leer sein.", $response->getDetail());

        $violations = $response->getViolations();
        $this->assertCount(2, $violations);

        $this->assertSame('firstname', $violations[0]->getPropertyPath());
        $this->assertSame('Dieser Wert sollte nicht leer sein.', $violations[0]->getMessage());
        $this->assertSame('c1051bb4-d103-4f74-8988-acbcafc7fdc3', $violations[0]->getCode());

        $this->assertSame('lastname', $violations[1]->getPropertyPath());
        $this->assertSame('Dieser Wert sollte nicht leer sein.', $violations[1]->getMessage());
        $this->assertSame('c1051bb4-d103-4f74-8988-acbcafc7fdc3', $violations[1]->getCode());
    }
}
