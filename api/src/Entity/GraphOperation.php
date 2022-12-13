<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Inputs\PrieMoyInput;
use App\State\GraphOperationProcessor;
use App\State\GraphOperationProvider;
use App\State\GraphOperationProvider2;
use ArrayObject;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Console\Input\ArrayInput;

#[ApiResource(operations: [
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
])]
class GraphOperation
{
    #[ApiProperty(identifier: true)]
    public int $id;
}
