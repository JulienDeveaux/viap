<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use ApiPlatform\Metadata\Post;
use App\Graphql\Outputs\GraphOperationOutput;
use App\Graphql\Resolvers\GraphOperationCollectionResolver;
use App\Graphql\Resolvers\GraphOperationResolver;
use App\Inputs\PrieMoyInput;
use App\State\GraphOperationProcessor;
use App\State\GraphOperationProvider;
use App\State\GraphOperationProvider2;
use ArrayObject;
use Doctrine\DBAL\Types\IntegerType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\StringType;
use GraphQL\Type\Definition\Type;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Console\Input\ArrayInput;

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
        )
    ],
    graphQlOperations: [
        new Query(
            resolver: GraphOperationResolver::class,
            args: ["year" => ["type" => "[Int!]!"]],
            output: GraphOperationOutput::class,
            name: "for_year"
        ),
        new QueryCollection(
            args: ['years' => ['type' => "[Int]"]],
            paginationEnabled: false,
            output: GraphOperationOutput::class,
            name: "for_years",
            provider: GraphOperationCollectionResolver::class
        )
    ]
)]
class GraphOperation
{
    #[ApiProperty(identifier: true)]
    public int $id;
}
