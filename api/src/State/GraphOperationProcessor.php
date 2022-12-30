<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\ValFoncierRepository;
use App\Services\GraphOperationService;
use stdClass;

class GraphOperationProcessor implements ProcessorInterface
{
    private readonly GraphOperationService $service;

    public function __construct(ValFoncierRepository $repository)
    {
        $this->service = new GraphOperationService($repository);
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return match ($operation->getName())
        {
            "count_period_post" => $this->service->countPeriodFor($data->period, $data->startPeriod, $data->endPeriod),
            "prix_moyen_post" => $this->service->prixM2ForYears($data->years),
            "repartition_region_post" => $this->service->repartitionRegionForYear($data->year, $data->mode),
            default => null,
        };

    }
}
