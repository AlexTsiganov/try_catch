import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.util.*;

class RowService {
    public int price_per_month;
    public int category_id;
    public String name;
    public int connection_cost;

    public RowService(int price_per_month, int category_id, String name, int connection_cost) {
        this.price_per_month = price_per_month;
        this.category_id = category_id;
        this.name = name;
        this.connection_cost = connection_cost;
    }
}

public class Service {
    private FileOutputStream out;
    final String insert = "INSERT INTO sales_test_db.";

    final String filename = "services.sql";
    final String table = "service";
    final String vals = " (price_per_month, category_id, name, connection_cost) VALUES (";

    Set<RowService> data = new LinkedHashSet<>();

    private void generateServices() throws IOException {
        out = new FileOutputStream(filename);
        OutputStreamWriter osw = new OutputStreamWriter(out, Charset.forName("UTF-8"));

        formingDataToInsert();
        Iterator<RowService> i = data.iterator();
        while (i.hasNext()) {
            RowService p = i.next();
            osw.write(insert + table + vals
                    + p.price_per_month + ", "
                    + p.category_id + ", "
                    + p.name + ", "
                    + p.connection_cost + ");\n");
        }

        osw.close();
    }

    private void formingDataToInsert() {
        data.add(new RowService(85000, 1, "'Игровой 200 Мбит/с'", 85000));
        data.add(new RowService(80000, 1, "'Игровой 4 Мбит/с'", 80000));
        data.add(new RowService(89000, 1, "'Домашний Интернет 200'", 89000));
        data.add(new RowService(69000, 1, "'Домашний Интернет 100'", 69000));
        data.add(new RowService(59000, 1, "'Домашний Интернет 80'", 59000));
        data.add(new RowService(48000, 1, "'Домашний Интернет 45'", 48000));
        data.add(new RowService(34900, 1, "'Домашний Интернет 8'", 34900));

        data.add(new RowService(32000, 2, "'Твой стартовый'", 32000));
        data.add(new RowService(42000, 2, "'Твой оптимальный'", 42000));
        data.add(new RowService(52000, 2, "'Твой продвинутый'", 52000));
        data.add(new RowService(62000, 2, "'Твой премьерный'", 62000));
        data.add(new RowService(170000, 2, "'Твой максимальный'", 170000));

        // There are some special conditions for these services, which ignored for now.
        data.add(new RowService(23000, 3, "'Популярный'", 23000));
        data.add(new RowService(35000, 3, "'HD-Премиум'", 35000));
        // --------
        data.add(new RowService(19900, 3, "'Amedia Premium'", 19900));
        data.add(new RowService(9000, 3, "'Ночной'", 9000));
        data.add(new RowService(21900, 3, "'Наш Футбол'", 21900));
        data.add(new RowService(38000, 3, "'ПЛЮС ФУТБОЛ'", 38000));

        data.add(new RowService(45500, 4, "'Безлимитный'", 45500));
        data.add(new RowService(34000, 4, "'Абонентский'", 34000));
        data.add(new RowService(34000, 4, "'Комбинированный 400'", 34000));
        data.add(new RowService(25100, 4, "'Комбинированный 100'", 25100));
        data.add(new RowService(34500, 4, "'Выходной'", 34500));
        data.add(new RowService(20500, 4, "'Повременный'", 20500));
    }

    public static void main(String[] args) throws IOException {
        new Service().generateServices();
    }
}
