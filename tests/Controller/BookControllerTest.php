<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testPublicUrls(string $url, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($statusCode);
    }

    public function provideUrls(): array
    {
        return [
            ['/', 200],
            ['/book', 200],
            ['/contact', 200],
            ['/babar', 404],
        ];
    }
}
