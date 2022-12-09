package pretraitement;
import static pretraitement.Pretraitement.*;
import java.util.Arrays;

public final class PretraitementTest {
    private  PretraitementTest(){} // non instanciable

    public static void main(String[] args) {
        String[] ligne = {"1","2","3"};

        // Test garderColonnes
        try {
            garderColonnes(ligne, 4);
            System.out.println("✗ Erreur : accepte les nombres de colonnes trop grands");
        } catch (IllegalArgumentException e) {
            System.out.println("✓ Rejette bien les nombres de colonnes trop grands");
        }

        try {
            garderColonnes(ligne, 0);
            System.out.println("✗ Erreur : accepte les nombres de colonnes trop petits");
        } catch (IllegalArgumentException e) {
            System.out.println("✓ Rejette bien les nombres de colonnes trop petits");
        }

        String[] ligne2 = garderColonnes(ligne, 2, 3, 2);
        String[] expected = {"2","3"};
        if (Arrays.equals(expected, ligne2)) {
            System.out.println("✓ Résultat conforme pour cas trivial");
        } else {
            System.out.println("✗ Résultat anormal : "+Arrays.toString(ligne2));
        }
    }
}
