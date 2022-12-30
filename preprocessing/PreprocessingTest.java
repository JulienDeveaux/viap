package preprocessing;
import static preprocessing.Preprocessing.*;

import java.util.Arrays;

public final class PreprocessingTest {
    private PreprocessingTest(){} // non-instanciable

    public static void main(String[] args) {
        String[] line = {"1","2","3"};

        // Test keepColumns
        try {
            keepColumns(line, 4);
            System.out.println("✗ Error : accepts column indices too big");
        } catch (IllegalArgumentException e) {
            System.out.println("✓ Rejects column indices too big");
        }

        try {
            keepColumns(line, 0);
            System.out.println("✗ Error : accepts column indices too small");
        } catch (IllegalArgumentException e) {
            System.out.println("✓ Rejects column indices too small");
        }

        String[] ligne2 = keepColumns(line, 2, 3, 2);
        String[] expected = {"2","3"};
        if (Arrays.equals(expected, ligne2)) {
            System.out.println("✓ Correct output for trivial case");
        } else {
            System.out.println("✗ Incorrect output: "+Arrays.toString(ligne2));
        }
    }
}
