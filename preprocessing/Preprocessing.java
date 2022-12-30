package preprocessing;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.regex.Pattern;
import java.util.stream.IntStream;

// Information to keep:
// - precise date  => column 9  "Date de mutation"
// - total price   => column 11 "Valeur foncière"
// - region        => column 19 "Code département"
// - surface       => column 39 "surface réelle bâti" (or 43 "surface terrain")

// java pretreatment/Pretreatment valeursfoncieres-2021.txt 9 11 19 39

public final class Preprocessing {
    private Preprocessing(){} // non-instanciable

    public static final String SEPARATOR = "|";

    /**
     * Filters columns and rows of a given file.
     * @param args The path of the file, then the indices of the columns to keep.
     */
    public static void main(String[] args) throws IOException {
        if (args.length < 2)
            throw new IllegalArgumentException("Too few arguments ("+args.length+"), give at least the file path and the indices of the columns to keep.");
        
        // creating reader
        Path path = Paths.get(args[0]);
        BufferedReader reader = Files.newBufferedReader(path);

        // creating writer
        Path resultPath = Paths.get(getResultPath(args[0]));
        BufferedWriter writer = Files.newBufferedWriter(resultPath);

        // creating array of column indices
        int[] columns = new int[args.length-1];
        for (int i = 0; i < columns.length; i++) {
            columns[i] = Integer.parseInt(args[i+1]);
        }

        // The processing
        String line;
        while ((line = reader.readLine()) != null) {
            String[] array = line.split(Pattern.quote(SEPARATOR));
            array = keepColumns(array, columns);
            String newLine = joinLine(array);
            writer.write(newLine, 0, newLine.length());
            writer.newLine();
        }

//        String example = "1||||||||||2";
//        String[] tab = example.split(Pattern.quote(SEPARATOR));
//        example = joinLine(tab);
//        System.out.println(example);

        writer.close();
    }

    /**
     * @param tab A line of text as an array of words
     * @param colonnes The indices of the columns to keep (starts at 1)
     * @return An array of words corresponding to the same line, but only keeping said columns
     */
    public static String[] keepColumns(String[] tab, int... columnIds) {
        if (tab == null || tab.length == 0)
            throw new IllegalArgumentException("The array is empty or null");
        
        if (columnIds == null)
            columnIds = new int[0];
        columnIds = IntStream.of(columnIds).sorted().distinct().toArray();

        if (columnIds[0] < 1)
            throw new IllegalArgumentException("Invalid column index \""+columnIds[0]+"\", should be >= 1");
        if (columnIds[columnIds.length-1] > tab.length)
            throw new IllegalArgumentException("Invalid column index \""+columnIds[columnIds.length-1]+"\", should be <= number of columns "+tab.length);
        
        // subtracting 1 to go from [1,n] to [0,n)
        for (int i = 0; i < columnIds.length; i++)
            columnIds[i]--;
        
        String[] r = new String[columnIds.length];
        int idR = 0;
        for (int i = 0; i < columnIds.length; i++) {
            int idArray = columnIds[i];
            r[idR] = tab[idArray];
            idR++;
        }
        return r;
    }

    /*
     * inserts "-traitement" before possible file extension
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
