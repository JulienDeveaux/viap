<?php

namespace App\Graphql\Resolvers;


use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\ArrayPaginator;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Graphql\Outputs\GraphOperationOutput;
use App\Repository\ValFoncierRepository;
use App\Services\GraphOperationService;
use Doctrine\DBAL\Exception;

class GraphOperationCollectionResolver implements ProviderInterface
{
    private readonly GraphOperationService $service;

    public function __construct(ValFoncierRepository $repository)
    {
        $this->service = new GraphOperationService($repository);
    }


    /**
     * @throws Exception
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $filters = $context['filters'];
        $years = $filters['years'];

        $years = array_map(fn($year) => intval($year), $years);

        return [$this->service->prixM2ForYears($years)];
    }
}
