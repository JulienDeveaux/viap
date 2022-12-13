<?php

namespace App\Inputs;

use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Api\UrlGeneratorInterface;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Operation;
use GraphQL\Type\Definition\InputType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DomCrawler\Field\InputFormField;
use Symfony\Component\PropertyInfo\Type;

final class PrieMoyInput
{
    public array $years;
}
