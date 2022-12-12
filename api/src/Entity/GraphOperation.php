<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Inputs\PrieMoyInput;
use App\State\GraphOperationProvider;
use ArrayObject;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Console\Input\ArrayInput;

#[ApiResource(operations: [
    new Get(
        uriTemplate: "/graphOperation/prix_moyen/{year}",
        input: PrieMoyInput::class,
        name: "prix_moyen",
        provider: GraphOperationProvider::class
    )
])]
class GraphOperation
{

}
