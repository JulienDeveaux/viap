<?php

namespace App\Controller;

use ApiPlatform\Metadata\Get;
use App\Entity\ValFoncier;
use App\Repository\ValFoncierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CustomValFoncierController extends AbstractController
{
    private ValFoncierRepository $repository;

    public function __construct()
    {

    }

    public function __invoke(): ValFoncier
    {
        return new ValFoncier();
    }

    #[Route(
        path: '/val_fonciers/test',
        name: 'book_post_publication',
        methods: ['GET'],
    )]
    public function test(): ValFoncier
    {
        $v = new ValFoncier();

        $v->setCodePostal("76199");
        $v->setId(777);

        return $v;
    }
}
