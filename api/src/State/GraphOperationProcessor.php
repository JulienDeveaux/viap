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
        $test = new StdClass;

        $test->test = "coucou from processor";

        return $test;
    }
}
