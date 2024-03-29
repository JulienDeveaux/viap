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

    public function testRepartitionRegionMode0(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/repartitionRegion", [
            'json' => [
                'year' => 2019,
                'mode' => 0
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "values" => [
                "Ain"=> 12905,
                "Savoie" => 12753
            ]
          ]
        );
    }

    public function testRepartitionRegionMode1(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/repartitionRegion", [
            'json' => [
                'year' => 2019,
                'mode' => 1
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "values" => [
                "DOM"=> 19141,
                "Pays de la Loire" => 86713
            ]
          ]
        );
    }

    public function testCountPeriodDay(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/count_period", [
            'json' => [
                'period' => 0,            // jours
                'startPeriod' => "2018-01-01",
                'endPeriod' => "2018-01-02"
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "periods" => [
                "1/1/2018"=> 6,
                "2/1/2018" => 692
            ]
          ]
        );
    }

    public function testCountPeriodMonth(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/count_period", [
            'json' => [
                'period' => 1,            // mois
                'startPeriod' => "2018-01-01",
                'endPeriod' => "2018-02-01"
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "periods" => [
                "1/2018"=> 9409,
                "3/2018" => 19328
            ]
          ]
        );
    }

    public function testCountPeriodYear(): void
    {
        $this->client = static::createClient();

        $this->client->request('POST', "/graphOperation/count_period", [
            'json' => [
                'period' => 2,            // années
                'startPeriod' => "2018-01-01",
                'endPeriod' => "2019-01-01"
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "periods" => [
                "10/2018"=> 116044,
                "1/2018" => 81627
            ]
          ]
        );
    }
}
