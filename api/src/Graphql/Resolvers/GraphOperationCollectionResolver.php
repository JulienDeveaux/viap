<?php

namespace App\Graphql\Resolvers;


use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\ArrayPaginator;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Graphql\Outputs\GraphOperationOutput;

class GraphOperationCollectionResolver implements ProviderInterface
{


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $filters = $context['filters'];
        $years = $filters['years'];

        $test = new GraphOperationOutput();

        $test->res = "coucou from resolvers  collection " . $years[0];

        return [$test];
    }
}
