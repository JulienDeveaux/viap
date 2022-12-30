<?php
namespace App\DataFixtures;

use App\Entity\RegionNames;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionNamesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        gc_enable();

        $regionNames = array(
            'Ain' => 'Auvergne-Rhône-Alpes',
            'Aisne' => 'Hauts-de-France',
            'Allier' => 'Auvergne-Rhône-Alpes',
            'Alpes-de-Haute-Provence' => 'Provence-Alpes-Côte d\'Azur',
            'Hautes-Alpes' => 'Provence-Alpes-Côte d\'Azur',
            'Alpes-Maritimes' => 'Provence-Alpes-Côte d\'Azur',
            'Ardèche' => 'Auvergne-Rhône-Alpes',
            'Ardennes' => 'Grand Est',
            'Ariège' => 'Occitanie',
            'Aube' => 'Grand Est',
            'Aude' => 'Occitanie',
            'Aveyron' => 'Occitanie',
            'Bouches-du-Rhône' => 'Provence-Alpes-Côte d\'Azur',
            'Calvados' => 'Normandie',
            'Cantal' => 'Auvergne-Rhône-Alpes',
            'Charente' => 'Nouvelle-Aquitaine',
            'Charente-Maritime' => 'Nouvelle-Aquitaine',
            'Cher' => 'Centre-Val de Loire',
            'Corrèze' => 'Nouvelle-Aquitaine',
            'Corse-du-Sud' => 'Corse',
            'Haute-Corse' => 'Corse',
            'Côte-d\'Or' => 'Bourgogne-Franche-Comté',
            'Côtes-d\'Armor' => 'Bretagne',
            'Creuse' => 'Nouvelle-Aquitaine',
            'Dordogne' => 'Nouvelle-Aquitaine',
            'Doubs' => 'Bourgogne-Franche-Comté',
            'Drôme' => 'Auvergne-Rhône-Alpes',
            'Eure' => 'Normandie',
            'Eure-et-Loir' => 'Centre-Val de Loire',
            'Finistère' => 'Bretagne',
            'Gard' => 'Occitanie',
            'Haute-Garonne' => 'Occitanie',
            'Gers' => 'Occitanie',
            'Gironde' => 'Nouvelle-Aquitaine',
            'Hérault' => 'Occitanie',
            'Ille-et-Vilaine' => 'Bretagne',
            'Indre' => 'Centre-Val de Loire',
            'Indre-et-Loire' => 'Centre-Val de Loire',
            'Isère' => 'Auvergne-Rhône-Alpes',
            'Jura' => 'Bourgogne-Franche-Comté',
            'Landes' => 'Nouvelle-Aquitaine',
            'Loir-et-Cher' => 'Centre-Val de Loire',
            'Loire' => 'Auvergne-Rhône-Alpes',
            'Haute-Loire' => 'Auvergne-Rhône-Alpes',
            'Loire-Atlantique' => 'Pays de la Loire',
            'Loiret' => 'Centre-Val de Loire',
            'Lot' => 'Occitanie',
            'Lot-et-Garonne' => 'Nouvelle-Aquitaine',
            'Lozère' => 'Occitanie',
            'Maine-et-Loire' => 'Pays de la Loire',
            'Manche' => 'Normandie',
            'Marne' => 'Grand Est',
            'Haute-Marne' => 'Grand Est',
            'Mayenne' => 'Pays de la Loire',
            'Meurthe-et-Moselle' => 'Grand Est',
            'Meuse' => 'Grand Est',
            'Morbihan' => 'Bretagne',
            'Moselle' => 'Grand Est',
            'Nièvre' => 'Bourgogne-Franche-Comté',
            'Nord' => 'Hauts-de-France',
            'Oise' => 'Hauts-de-France',
            'Orne' => 'Normandie',
            'Pas-de-Calais' => 'Hauts-de-France',
            'Puy-de-Dôme' => 'Auvergne-Rhône-Alpes',
            'Pyrénées-Atlantiques' => 'Nouvelle-Aquitaine',
            'Hautes-Pyrénées' => 'Occitanie',
            'Pyrénées-Orientales' => 'Occitanie',
            'Bas-Rhin' => 'Grand Est',
            'Haut-Rhin' => 'Grand Est',
            'Rhône' => 'Auvergne-Rhône-Alpes',
            'Haute-Saône' => 'Bourgogne-Franche-Comté',
            'Saône-et-Loire' => 'Bourgogne-Franche-Comté',
            'Sarthe' => 'Pays de la Loire',
            'Savoie' => 'Auvergne-Rhône-Alpes',
            'Haute-Savoie' => 'Auvergne-Rhône-Alpes',
            'Paris' => 'Île-de-France',
            'Seine-Maritime' => 'Normandie',
            'Seine-et-Marne' => 'Île-de-France',
            'Yvelines' => 'Île-de-France',
            'Deux-Sèvres' => 'Nouvelle-Aquitaine',
            'Somme' => 'Hauts-de-France',
            'Tarn' => 'Occitanie',
            'Tarn-et-Garonne' => 'Occitanie',
            'Var' => 'Provence-Alpes-Côte d\'Azur',
            'Vaucluse' => 'Provence-Alpes-Côte d\'Azur',
            'Vendée' => 'Pays de la Loire',
            'Vienne' => 'Nouvelle-Aquitaine',
            'Haute-Vienne' => 'Nouvelle-Aquitaine',
            'Vosges' => 'Grand Est',
            'Yonne' => 'Bourgogne-Franche-Comté',
            'Territoire de Belfort' => 'Bourgogne-Franche-Comté',
            'Essonne' => 'Île-de-France',
            'Hauts-de-Seine' => 'Île-de-France',
            'Seine-Saint-Denis' => 'Île-de-France',
            'Val-de-Marne' => 'Île-de-France',
            'Val-d\'Oise' => 'Île-de-France',
            'Guadeloupe' => 'Guadeloupe',
            'Martinique' => 'Martinique',
            'Guyane' => 'Guyane',
            'La Réunion' => 'La Réunion',
            'Mayotte' => 'Mayotte',
            'DOM' => 'DOM'
        );
        foreach ($regionNames as $key => $value) {
            print("key : " . $key . " value : " . $value . "\n");
            $region = new RegionNames();
            $region->setDepartement($key);
            $region->setRegion($value);
            $manager->persist($region);
        }

        $manager->flush();
        $manager->clear();
    }
}
?>
