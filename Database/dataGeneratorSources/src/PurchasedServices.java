import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.nio.charset.Charset;
import java.sql.*;
import java.util.*;

class RowPurchased {
    public int order_id;
    public int service_id;
    public int backed_price;

    public RowPurchased(int order_id, int service_id, int backed_price) {
        this.order_id = order_id;
        this.service_id = service_id;
        this.backed_price = backed_price;
    }
}

public class PurchasedServices {
    private FileOutputStream out;
    final String insert = "INSERT INTO `old-hotel_rt-dev`.";

    final String filename = "7_purchased.sql";
    final String table = "`purchased_services`";
    final String vals = " (order_id, service_id, backed_price) VALUES (";

    Set<RowPurchased> data = new LinkedHashSet<>();

    private void generateOrders() throws IOException {
        out = new FileOutputStream(filename);
        OutputStreamWriter osw = new OutputStreamWriter(out, Charset.forName("UTF-8"));

        formingDataToInsert();
        Iterator<RowPurchased> i = data.iterator();
        while (i.hasNext()) {
            RowPurchased p = i.next();
            osw.write(insert + table + vals
                    + p.order_id + ", "
                    + p.service_id + ", "
                    + p.backed_price + ");\n");
        }

        osw.close();
    }

    private void formingDataToInsert() {
        DBConnector db = new DBConnector();
        int service_id;
        int backedPrice;
        Random rand = new Random(System.currentTimeMillis());

        for (int i = 1; i <= 1000; ++i) {
            service_id = rand.nextInt((7-1)+1)+1;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 1001; i <= 2000; ++i) {
            service_id = rand.nextInt((24-19)+1)+19;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 2001; i <= 3500; ++i) {
            service_id = rand.nextInt((12-8)+1)+8;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 3501; i <= 4000; ++i) {
            service_id = rand.nextInt((18-13)+1)+13;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 4001; i <= 6500; ++i) {
            service_id = rand.nextInt((12-8)+1)+8;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((24-19)+1)+19;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 6501; i <= 8000; ++i) {
            service_id = rand.nextInt((12-8)+1)+8;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((24-19)+1)+19;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((7-1)+1)+1;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }

        for (int i = 8001; i <= 10000; ++i) {
            service_id = rand.nextInt((7-1)+1)+1;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((12-8)+1)+8;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((18-13)+1)+13;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));

            service_id = rand.nextInt((24-19)+1)+19;
            backedPrice = db.getBackedPrice(service_id);
            data.add(new RowPurchased(i, service_id, backedPrice));
        }
    }


    public static void main(String[] args) throws IOException {
        new PurchasedServices().generateOrders();
    }
}

class DBConnector {
    // JDBC URL, username and password of MySQL server
    private static final String url = "jdbc:mysql://localhost:3306/old-hotel_rt-dev";
    private static final String user = "admin";
    private static final String password = "admin";

    // JDBC variables for opening and managing connection
    private static Connection con;
    private static Statement stmt;
    private static ResultSet rs;



    public int getBackedPrice(int serviceId) {
        String query = "select connection_cost from service where id="+serviceId;
        int connectionCost = -1;

        try {
            // opening database connection to MySQL server
            con = DriverManager.getConnection(url, user, password);

            // getting Statement object to execute query
            stmt = con.createStatement();

            // executing SELECT query
            rs = stmt.executeQuery(query);

            while (rs.next()) {
                connectionCost = rs.getInt("connection_cost");
            }


        } catch (SQLException sqlEx) {
            sqlEx.printStackTrace();
        } finally {
            //close connection ,stmt and resultset here
            try { con.close(); } catch(SQLException se) { /*can't do anything */ }
            try { stmt.close(); } catch(SQLException se) { /*can't do anything */ }
            try { rs.close(); } catch(SQLException se) { /*can't do anything */ }
        }

        return connectionCost;
    }

}