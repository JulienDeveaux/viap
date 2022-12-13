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
use App\Graphql\Resolvers\GraphOperationCollectionResolver;
use App\Graphql\Resolvers\GraphOperationResolver;
use App\Inputs\PrieMoyInput;
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
            uriTemplate: "/grapOperation/prix_moyen",
            input: PrieMoyInput::class,
            name: "prix_moyen_post",
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
