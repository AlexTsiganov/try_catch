import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.util.*;

class RowCategory {
    public String name;
    public String pid;

    public RowCategory(String name, String pid) {
        this.name = name;
        this.pid = pid;
    }
}

public class Category {
    private FileOutputStream out;

    final String insert = "INSERT INTO ";
    String db = "`old-hotel_rt-dev`";
    String table;
    String vals;

    Set<RowCategory> data = new LinkedHashSet<>();

    private void generateCategories() throws IOException {
        out = new FileOutputStream("1_categories.sql");
        OutputStreamWriter osw = new OutputStreamWriter(out, Charset.forName("UTF-8"));
        table = db + ".category ";
        vals = "(name, pid) VALUES (";

        formingDataToInsert();
        Iterator<RowCategory> i = data.iterator();
        while (i.hasNext()) {
            RowCategory p = i.next();
            osw.write(insert + table + vals + p.name + ", " + p.pid + ");\n");
        }

        osw.close();
    }

    private void formingDataToInsert() {
        data.add(new RowCategory("'Интернет'", "null"));
        data.add(new RowCategory("'Телевидение'", "null"));
        data.add(new RowCategory("'Цифровое телевидение'", "null"));
        data.add(new RowCategory("'Телефония'", "null"));
    }

    public static void main(String[] args) throws IOException {
        new Category().generateCategories();
    }
}
