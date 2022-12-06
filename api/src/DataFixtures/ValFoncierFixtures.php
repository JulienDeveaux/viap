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
        gc_enable();
        $files = scandir("./data");

        print_r($files);

        foreach ($files as $file)
            if(!str_starts_with($file, "."))
                $this->csv_load_datas($manager, "./data/" . $file);
    }

    private function csv_load_datas(ObjectManager $manager, string $file)
    {
        print("load file '" . $file . "'");

        $csv = fopen($file, "r");
        $i = 0;
        fgetcsv($csv, 0, '|');

        while(!feof($csv))
        {
            $line = fgetcsv($csv, 0, '|');

            if(is_array($line) && sizeof($line) == 43)
            {
                $type = $line[36];
                if (in_array($type, ValFoncier::TYPES))
                {
                    $valFoncier = new ValFoncier();
                    $valFoncier->setCodePostal($line[16]);
                    $valFoncier->setPrix((float)$line[10]);
                    $valFoncier->setDateAquisition(DateTime::createFromFormat('d/m/Y', $line[8]));
                    $valFoncier->setType($type);
                    $valFoncier->setSurface((float)$line[42]);
                    $manager->persist($valFoncier);

                    if ($i % 10_000 == 0)
                    {
                        print($i . "\n");

                        $manager->flush();
                        $manager->clear();
                    }
                    $i = $i + 1;
                }
            }
        }

        $manager->flush();
    }
}
?>
