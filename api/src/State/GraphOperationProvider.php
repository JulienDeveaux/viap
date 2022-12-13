<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\GraphOperation;
use App\Repository\ValFoncierRepository;
use App\Services\GraphOperationService;
use stdClass;

class GraphOperationProvider implements ProviderInterface
{
    private readonly GraphOperationService $service;

    public function __construct(ValFoncierRepository $repository)
    {
        $this->service = new GraphOperationService($repository);
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere

        return $this->service->prixM2($uriVariables['year']);
    }
}
