<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\GraphQl\Mutation;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Graphql\Outputs\GraphOperationOutput;
use App\Graphql\Outputs\PeriodCountOutput;
use App\Graphql\Outputs\RepartitionRegionForYearOutput;
use App\Graphql\Resolvers\GraphOperationCollectionResolver;
use App\Graphql\Resolvers\GraphOperationResolver;
use App\Inputs\CountPeriodInput;
use App\Inputs\PrieMoyInput;
use App\Inputs\RepartitionRegionInput;
use App\State\GraphOperationProcessor;
use App\State\GraphOperationProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: "/graphOperation/prix_moyen/{year}",
            name: "prix_moyen",
            provider: GraphOperationProvider::class
        ),
        new Post(
            uriTemplate: "/graphOperation/repartitionRegion",
            input: RepartitionRegionInput::class,
            output: RepartitionRegionForYearOutput::class,
            name: "repartition_region_post",
            processor: GraphOperationProcessor::class
        ),
        new Post(
            uriTemplate: "/graphOperation/prix_moyen",
            input: PrieMoyInput::class,
            output: GraphOperationOutput::class,
            name: "prix_moyen_post",
            processor: GraphOperationProcessor::class
        ),
        new Post(
            uriTemplate: "/graphOperation/count_period",
            input: CountPeriodInput::class,
            output: PeriodCountOutput::class,
            name: "count_period_post",
            processor: GraphOperationProcessor::class
        ),
        new GetCollection(
            uriTemplate: "/graphOperation/prix_moyen",
            name: "prix_moyen_collection",
            provider: GraphOperationCollectionResolver::class
        ),
    ],
    graphQlOperations: [
        new Query(
            resolver: GraphOperationResolver::class,
            args: ["year" => ["type" => "Int"]],
            output: GraphOperationOutput::class,
            name: "for_year"
        ),
        new Query(
            resolver: GraphOperationResolver::class,
            args: ['years' => ['type' => "[Int]"]],
            output: GraphOperationOutput::class,
            name: "for_years",
        ),
        new Query(
            resolver: GraphOperationResolver::class,
            args: ["provider" => ["type" => "Int"], "startPeriod" => ["type" => "String"], "endPeriod" => ["type" => "String"]],
            output: PeriodCountOutput::class,
            name: "period_count"
        ),
        new QueryCollection(
            args: ['years' => ['type' => "[Int]"]],
            paginationEnabled: false,
            output: GraphOperationOutput::class,
            name: "for_test",
            provider: GraphOperationCollectionResolver::class
        )
    ],

)]
class GraphOperation
{

}
