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

    public function testPriMoyenPost()
    {
        $this->client = static::createClient();

        $this->client->request('POST', '/graphOperation/prix_moyen', [
            'json' => [
                "years" => ["2019", "2020"]
            ]
        ]);

        $this->assertJsonContains([
            "prixM2" => [
                ["2019" => 1686.778928420297],
                ["2020" => 1259.3101591669683]
            ]
        ]);
    }

    public function testRepartitionRegion(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/repartitionRegion", [
            'headers' => ['Content-type' => 'application/json',
                            'Accept' => 'application/json'],
            'json' => [
                'year' => 2019,
                'mode' => 0
            ]
        ]);

        $this->assertResponseIsSuccessful();

        print($this->client->getResponse()->getContent());

        $this->assertJsonContains([
            "values" => [
                "Ain"=> 12905,
                "Savoie" => 12753
            ]
          ]
        );
    }
}
