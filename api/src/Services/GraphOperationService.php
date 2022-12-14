<?php

namespace App\Services;

use App\Graphql\Outputs\GraphOperationOutput;
use App\Repository\ValFoncierRepository;
use DateTime;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\Expr\Math;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class GraphOperationService
{
    private ValFoncierRepository $repository;

    /**
     * @param ValFoncierRepository $repository
     */
    public function __construct(ValFoncierRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int[] $years
     * @return GraphOperationOutput
     * @throws Exception
     */
    public function prixM2ForYears(array $years)
    {
        if(count($years) === 0)
            throw new Exception("No years provided");

        $vals = $this->repository->createQueryBuilder('n')->getEntityManager()->getConnection()
            ->executeQuery("SELECT extract(YEAR from n.date_aquisition) as year, sum(n.prix) AS sclr_0, count(n.prix) AS sclr_1
                FROM val_foncier n
                WHERE extract(YEAR from n.date_aquisition) IN (" . implode(",", $years) . ")
                group by extract(YEAR from n.date_aquisition)");

        $res = new GraphOperationOutput();
        $res->res = "rowCount " . $vals->rowCount();

        $res->prixM2 = [];

        foreach ($vals->fetchAllAssociative() as $val)
        {
            $res->prixM2[] = [
                $val['year'] => $val['sclr_0'] / $val['sclr_1']
            ];
        }

        return $res;
    }

    /**
     * @param int $years
     * @return GraphOperationOutput
     */
    public function prixM2(int $years)
    {
        $startDate = DateTime::createFromFormat('d-n-Y',  "01-01-".$years);
        $startDate->setTime(0, 0);

        $endDate = DateTime::createFromFormat('d-n-Y', "01-01-".$years+1);
        $endDate->setTime(0, 0);

        $query = $this->repository->createQueryBuilder('n')
            ->select('sum(n.prix) as total_prix, count(n.prix) as total_terrain')
            ->where('n.dateAquisition BETWEEN :start AND :end')
            ->setParameter('start', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('end', $endDate->format('Y-m-d H:i:s'))
            ->getQuery();

        $sql = $query->getSQL();
        $vals = $query->getResult()[0];

        $res = new GraphOperationOutput();
        $res->res = "coucou from service " . print_r($sql, true);

        $res->prixM2 = [$years => $vals['total_prix'] / max($vals['total_terrain'], 1)];

        return $res;
    }
}
