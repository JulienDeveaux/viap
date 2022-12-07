<?php

namespace App\Resolvers;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Entity\ValFoncier;

class TestResolver implements QueryItemResolverInterface
{
    public function __invoke(?object $item, array $context): object
    {
        // Query arguments are in $context['args'].

        // Do something with the book.
        // Or fetch the book if it has not been retrieved.

        $v = new ValFoncier();

        $v->setCodePostal("76199");

        return $v;
    }
}
