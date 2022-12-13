<?php

namespace App\Graphql\Resolvers;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Graphql\Outputs\GraphOperationOutput;
use stdClass;

class GraphOperationResolver implements QueryItemResolverInterface
{

    public function __invoke(?object $item, array $context): object
    {
        $args = $context['args'];

        $test = new GraphOperationOutput();

        $test->res = "coucou from resolvers " . $args['year'];

        return $test;
    }
}
