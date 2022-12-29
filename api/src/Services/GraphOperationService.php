<?php

namespace App\Services;

use App\Graphql\Outputs\GraphOperationOutput;
use App\Graphql\Outputs\PeriodCountOutput;
use App\Graphql\Outputs\RepartitionRegionForYearOutput;
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
            ->executeQuery("SELECT extract(YEAR from n.date_aquisition) as year, sum(n.prix) AS prix, sum(n.surface) AS surface, count(n.prix) AS nb
                FROM val_foncier n
                WHERE extract(YEAR from n.date_aquisition) IN (" . implode(",", $years) . ") AND
                      n.prix > 0 AND n.surface > 0
                group by extract(YEAR from n.date_aquisition)");

        $res = new GraphOperationOutput();
        $res->res = "rowCount " . $vals->rowCount();

        $res->prixM2 = [];

        foreach ($vals->fetchAllAssociative() as $val)
        {
            $res->prixM2[] = [
                $val['year'] => ($val['prix'] / $val['surface'])
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
            ->select('sum(n.prix) as total_prix, count(n.prix) as total_terrain, sum(n.surface) as total_surface')
            ->where('n.dateAquisition BETWEEN :start AND :end')
            ->where('n.prix > 0')
            ->where('n.surface > 0')
            ->setParameter('start', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('end', $endDate->format('Y-m-d H:i:s'))
            ->getQuery();

        $sql = $query->getSQL();
        $vals = $query->getResult()[0];

        $res = new GraphOperationOutput();
        $res->res = "coucou from service " . print_r($sql, true);

        $res->prixM2 = [$years => $vals['total_prix'] / max($vals['total_surface'], 1)];

        return $res;
    }

    /**
     * @throws Exception
     */
    public function countPeriodFor(int $period, DateTime $startDate, DateTime $endDate): PeriodCountOutput
    {
        $periodStr = match ($period)
        {
            0 => "DAY-MONTH-YEAR",
            1 => "WEEK-YEAR",
            2 => "MONTH-YEAR",
            default => "YEAR"
        };

        $extractArray = array_map(fn($p) => "extract(" . $p . " from n.date_aquisition)", explode("-", $periodStr));
        $concatStr   = join(", '/',", $extractArray);
        $groupByStr  = join(",", $extractArray);

        $vals = $this->repository->createQueryBuilder('n')->getEntityManager()->getConnection()
            ->executeQuery("SELECT count(*) as nb, concat($concatStr) as date
            FROM val_foncier n
            WHERE n.date_aquisition BETWEEN '" . $startDate->format('m/d/y') . "' AND '". $endDate->format('m/d/y') ."'
            GROUP BY $groupByStr");

        $res = new PeriodCountOutput();
        $res->periods = [];

        foreach ($vals->fetchAllAssociative() as $val)
        {
            $res->periods[$val["date"]] = $val["nb"];
        }

        return $res;
    }

    public function repartitionRegionForYear($year)
    {
        $vals = $this->repository->createQueryBuilder('n')->getEntityManager()->getConnection()
            ->executeQuery("SELECT count(*) as nb, left(code_postal, -3) as region
            FROM val_foncier n
            WHERE extract(YEAR from n.date_aquisition) = $year
            GROUP BY left(code_postal, -3)");
        $res = new RepartitionRegionForYearOutput();

        $res->values = [];

        foreach ($vals->fetchAllAssociative() as $val)
        {
            if($val["region"] === "")       // don't take data without region
                continue;
            $res->values[$val["region"]] = $val["nb"];
        }

        $departementNames = $this->repository->createQueryBuilder('n')->getEntityManager()->getConnection()
            ->executeQuery("SELECT * FROM Departement_names");
        $departementNamesArray = [];
        foreach($departementNames->fetchAllAssociative() as $name)
        {
            $departementNamesArray[(int)$name["code"]] = $name["name"];

        }
        foreach ($res->values as $code => $nb)
        {
            $res->values[$departementNamesArray[$code]] = $nb;
            unset($res->values[$code]);
        }

        return $res;
    }
}
