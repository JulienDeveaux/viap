<?php

namespace App\Graphql\Resolvers;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Graphql\Outputs\GraphOperationOutput;
use App\Repository\ValFoncierRepository;
use App\Services\GraphOperationService;
use Doctrine\DBAL\Exception;
use stdClass;

class GraphOperationResolver implements QueryItemResolverInterface
{
    private readonly GraphOperationService $service;

    public function __construct(ValFoncierRepository $repository)
    {
        $this->service = new GraphOperationService($repository);
    }

    /**
     * @throws Exception
     */
    public function __invoke(?object $item, array $context): object
    {
        $args = $context['args'];

        return match ($context['info']->operation->selectionSet->selections[0]->name->value)
        {
            "for_yearGraphOperation" => $this->service->prixM2($args['year']),
            "for_yearsGraphOperation" => $this->service->prixM2ForYears($args['years']),
            "period_countOperation" => $this->service->countPeriodFor($args["period"], $args["startPeriod"], $args["endPeriod"]),

            default => throw new Exception("Unknown operation"),
        };
    }
}
