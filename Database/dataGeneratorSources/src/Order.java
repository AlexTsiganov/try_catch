import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.sql.Timestamp;
import java.util.*;

class RowOrder {
    public String date;
    public int client_id;
    public int seller_id;

    public RowOrder(String date, int client_id, int seller_id) {
        this.date = date;
        this.client_id = client_id;
        this.seller_id = seller_id;
    }
}

public class Order {
    private FileOutputStream out;
    final String insert = "INSERT INTO `old-hotel_rt-dev`.";

    final String filename = "6_orders.sql";
    final String table = "`order`";
    final String vals = " (date, client_id, seller_id) VALUES (";

    Set<RowOrder> data = new LinkedHashSet<>();

    private void generateOrders() throws IOException {
        out = new FileOutputStream(filename);
        OutputStreamWriter osw = new OutputStreamWriter(out, Charset.forName("UTF-8"));

        formingDataToInsert();
        Iterator<RowOrder> i = data.iterator();
        while (i.hasNext()) {
            RowOrder p = i.next();
            osw.write(insert + table + vals
                    + p.date + ", "
                    + p.client_id + ", "
                    + p.seller_id + ");\n");
        }

        osw.close();
    }

    private void formingDataToInsert() {
        for (int i = 1; i <= 10000; ++i) {
            data.add(new RowOrder(getRandomDate(), i, (int)(Math.random()*10+1)));
        }
    }

    private String getRandomDate() {
        long offset = Timestamp.valueOf("2015-10-01 00:00:00").getTime();
        long end = Timestamp.valueOf("2016-02-15 00:00:00").getTime();
        long diff = end - offset + 1;
        Timestamp randomDate = new Timestamp(offset + (long)(Math.random() * diff));

        while (!(randomDate.compareTo(Timestamp.valueOf("2015-12-01 00:00:00")) > -1 &&
                randomDate.compareTo(Timestamp.valueOf("2015-12-31 23:59:59")) < 1)) {
            randomDate = new Timestamp(offset + (long)(Math.random() * diff));
        }

        return "'" + randomDate.toString().substring(0, randomDate.toString().lastIndexOf('.')) + "'";
    }

    public static void main(String[] args) throws IOException {
        new Order().generateOrders();
    }
}
