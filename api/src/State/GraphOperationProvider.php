<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\GraphOperation;
use stdClass;

class GraphOperationProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere

        $test = new StdClass;

        $test->test = "coucou " . $uriVariables['year'];

        return $test;
    }
}
