<?php
namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ValFoncier;

class ValFoncierFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csv = fopen("/srv/app/data/valeursfoncieres-2018.txt", "r");
        $i = 0;
        fgetcsv($csv, 0, '|');
        while(!feof($csv)) {
            $line = fgetcsv($csv, 0, '|');
            if(is_array($line) && sizeof($line) == 43) {
                $type = $line[36];
                if (in_array($type, ValFoncier::TYPES)) {
                    $valFoncier = new ValFoncier();
                    $valFoncier->setCodePostal($line[16]);
                    $valFoncier->setPrix((float)$line[10]);
                    $valFoncier->setDateAquisition(DateTime::createFromFormat('d/m/Y', $line[8]));
                    $valFoncier->setType($type);
                    $valFoncier->setSurface((float)$line[42]);
                    $manager->persist($valFoncier);
                    if ($i % 1000 == 0) {
                        $manager->flush();
                    }
                    $i = $i + 1;
                }
            }
        }
        $manager->flush();
    }
}
?>
