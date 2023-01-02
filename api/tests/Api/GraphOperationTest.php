<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

class GraphOperationTest extends ApiTestCase
{
    private Client $client;

    public function testPrixMoyenOfOneYear(): void
    {
        $this->client = static::createClient();

        $year = 2019;

        $this->client->request('GET', "/graphOperation/prix_moyen/$year");

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains(array(
            "prixM2" => array(
                "hydra:member" => [1686.7785507987724]
            )
        ));
    }
}
