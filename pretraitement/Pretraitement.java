package pretraitement;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.regex.Pattern;
import java.util.stream.IntStream;

// Infos à garder :
// - date précise  => colonne 9  "Date de mutation"
// - prix total    => colonne 11 "Valeur foncière"
// - région        => colonne 19 "Code département"
// - surface       => colonne 39 "surface réelle bâti" (ou 43 "surface terrain")

// java pretraitement/Pretraitement valeursfoncieres-2021.txt 9 11 19 39

public final class Pretraitement {
    private Pretraitement(){} // non instanciable

    public static final String SEPARATOR = "|";

    /**
     * Filtre les colonnes et les lignes d'un fichier donné.
     * @param args Le chemin/nom du fichier d'entrée, puis les colonnes à garder.
     */
    public static void main(String[] args) throws IOException {
        if (args.length < 2)
            throw new IllegalArgumentException("Pas assez d'arguments ("+args.length+"), entrez au moins le chemin du fichier et une colonne à garder.");
        
        // création du reader
        Path path = Paths.get(args[0]);
        BufferedReader reader = Files.newBufferedReader(path);

        // création du writer
        Path resultPath = Paths.get(getResultPath(args[0]));
        BufferedWriter writer = Files.newBufferedWriter(resultPath);

        // création du tableau des id de colonnes
        int[] colonnes = new int[args.length-1];
        for (int i = 0; i < colonnes.length; i++) {
            colonnes[i] = Integer.parseInt(args[i+1]);
        }

        // le traitement
//        String ligne;
//        while ((ligne = reader.readLine()) != null) {
//            String[] tableau = ligne.split(Pattern.quote(SEPARATOR));
//            tableau = garderColonnes(tableau, colonnes);
//            String nvLigne = joinLine(tableau);
//            writer.write(nvLigne, 0, nvLigne.length());
//            writer.newLine();
//        }
        String exemple = "1||||||||||2";
        String[] tab = exemple.split(Pattern.quote(SEPARATOR));
        exemple = joinLine(tab);
        System.out.println(exemple);

        writer.close();
    }

    /**
     * @param tab Une ligne sous forme de tableau de mots
     * @param colonnes Les identifiants des colonnes à garder (démarre à 1)
     * @return Un tableau de mots correspondant à la même ligne, mais en ne gardant que les colonnes précisées
     */
    public static String[] garderColonnes(String[] tab, int... idColonnes) {
        if (tab == null || tab.length == 0)
            throw new IllegalArgumentException("Le tableau est vide ou nul");
        
        if (idColonnes == null)
            idColonnes = new int[0];
        idColonnes = IntStream.of(idColonnes).sorted().distinct().toArray();

        if (idColonnes[0] < 1)
            throw new IllegalArgumentException("id de colonne invalide \""+idColonnes[0]+"\", doit être >= 1");
        if (idColonnes[idColonnes.length-1] > tab.length)
            throw new IllegalArgumentException("id de colonne invalide \""+idColonnes[idColonnes.length-1]+"\", doit être <= aux nombre de colonnes "+tab.length);
        
        // on retire 1 pour passer de [1,n] à [0,n)
        for (int i = 0; i < idColonnes.length; i++)
        idColonnes[i]--;
        
        String[] r = new String[idColonnes.length];
        int idR = 0;
        for (int i = 0; i < idColonnes.length; i++) {
            int idTab = idColonnes[i];
            r[idR] = tab[idTab];
            idR++;
        }
        return r;
    }

    /*
     * insère "-traitement" avant l'extension de fichier éventuelle
     */
    private static String getResultPath(String path) {
        if (path.contains(".")) {
            int dotIndex = path.lastIndexOf(".");
            String extensionless = path.substring(0, dotIndex);
            String extension = path.substring(dotIndex, path.length());
            return extensionless + "-traitement" + extension;
        } else {
            return path + "-traitement";
        }
    }

    private static String joinLine(String[] tab) {
        StringBuilder r = new StringBuilder();
        for (int i = 0; i < tab.length-1; i++) {
            r.append(tab[i]);
            r.append(SEPARATOR);
        }
        r.append(tab[tab.length-1]);
        return r.toString();
    }
} 
