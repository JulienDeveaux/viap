<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use stdClass;

class GraphOperationProcessor implements ProcessorInterface
{

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $test = new StdClass;

        $test->test = "coucou from processor";

        return $test;
    }
}
