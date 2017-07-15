package application.Utils;

import application.DBUtils.MysqlDao;
import javafx.scene.control.Alert;

import java.io.*;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class SakilaDataGenerator {

    private static final char COMMA = ',';
    private static final char QUOTE = '"';

    private static final int BATCH_SIZE = 500000;


    private static final int FILM_MAX = 200000;
    private static final int ACTOR_MAX = 600;
    private static final int SAKILA_FILM_COUNT = 1000;
    private static final int SAKILA_ACTOR_COUNT = 200;
    private static final int SAKILA_CATEGORY_COUNT = 16;

    private static final String SAMPLE_DATE = "2006-02-15 04:34:33.0";

    private static List<String> fileNames = new ArrayList<>();


    public static void run() throws SQLException, IOException {

        long start = System.currentTimeMillis();

        recreateSakilaDatabase();
        MysqlDao.getConn().setCatalog("sakila");

        removeCSVFiles();
        System.out.println("CSV Files removed");


        List<List<String>> film_tbl = getTable("film");
        insertTable("film", film_tbl, FILM_MAX);
        System.out.println("film.csv created");


        List<List<String>> actor_tbl = getTable("actor");
        insertTable("actor", actor_tbl, ACTOR_MAX);
        System.out.println("actor.csv created");


        List<List<String>> film_actor_tbl = getTable("film_actor");
        insertRelation("film_actor", film_actor_tbl,
                SAKILA_FILM_COUNT, FILM_MAX, ACTOR_MAX, new int[]{10, 20}, true);
        System.out.println("film_actor.csv created");


        List<List<String>> film_category_tbl = getTable("film_category");
        insertRelation("film_category", film_category_tbl,
                SAKILA_FILM_COUNT, FILM_MAX, SAKILA_CATEGORY_COUNT, new int[]{1, 3}, false);
        System.out.println("film_category.csv created");


        String[] tableNames = {"film", "actor", "film_actor", "film_category"};
        for (String tableName : tableNames) {
            deleteTableContent(tableName);
            System.out.println(tableName + " contents deleted");
        }


        long elapsedTimeMillis;
        float elapsedTimeMin;
        for (String filename : fileNames) {
            System.out.print(filename + ".csv is importing to mysql... ");
            csvToMysql(filename);
            elapsedTimeMillis = System.currentTimeMillis() - start;
            elapsedTimeMin = elapsedTimeMillis / (60 * 1000F);
            System.out.println("Done.\tElapsed Time: " + elapsedTimeMin);
        }

        elapsedTimeMillis = System.currentTimeMillis() - start;
        elapsedTimeMin = elapsedTimeMillis / (60 * 1000F);


        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("Finished");
        alert.setContentText("Elapsed Time: " + elapsedTimeMin);
        alert.setHeaderText(null);
        alert.showAndWait();
    }

    private static List<List<String>> getTable(String tableName) throws SQLException {
        String query = "SELECT * FROM " + tableName;
        Statement stmt = MysqlDao.getConn().createStatement();
        ResultSet rs = stmt.executeQuery(query);

        List<List<String>> table = new ArrayList<>();

        List<String> columns = new ArrayList<>();
        for (int i = 0; i < rs.getMetaData().getColumnCount(); i++) {
            columns.add(rs.getMetaData().getColumnName(i + 1));
        }
        table.add(columns);

        while (rs.next()) {
            List<String> row = new ArrayList<>();
            for (int i = 0; i < rs.getMetaData().getColumnCount(); i++) {
                String val = rs.getString(i + 1);
                if (rs.getMetaData().getColumnTypeName(i + 1).equals("YEAR"))
                    val = val.split("-")[0];
                row.add(val);
            }
            table.add(row);
        }
        stmt.close();
        return table;
    }

    private static void insertTable(String tableName, List<List<String>> table, int max) throws SQLException, IOException {
        Random rand = new Random();

        int number_of_rows = table.size() - 1;
        int number_of_columns = table.get(0).size();

        // add existing rows
        StringBuilder values = convertExistingRowsToCSV(table);

        // add random generated rows
        table.remove(0);
        for (int i = 0; i < max - number_of_rows; i++) {
            int id = number_of_rows + i + 1;
            values.append(QUOTE).append(id).append(QUOTE).append(COMMA);
            for (int j = 1; j < number_of_columns; j++) {
                int random_num = rand.nextInt(table.size() - 1) + 1;
                String val = table.get(random_num).get(j);
                if (val == null)
                    values.append("\\N");
                else
                    values.append(QUOTE).append(val).append(QUOTE);
                if (j != number_of_columns - 1)
                    values.append(COMMA);
            }
            values.append("\n");

            if (i % BATCH_SIZE == 0 & i != 0) {
                writeCSV(tableName, values.toString());
                values = new StringBuilder();
            }
        }
        writeCSV(tableName, values.toString());
        fileNames.add(tableName);

    }

    private static void insertRelation(String relationName, List<List<String>> table, int begin_id, int tableSize_1, int tableSize_2,
                                       int[] random_interval, boolean swap) throws IOException {

        Random rand = new Random();

        // add existing rows
        StringBuilder values = convertExistingRowsToCSV(table);


        // add random generated rows
        for (int i = begin_id; i < tableSize_1; i++) {
            int id_1 = i + 1;
            int boundary = rand.nextInt(random_interval[1] - random_interval[0] + 1) + random_interval[0];
            List<Integer> insertedIds = new ArrayList<>();
            for (int j = 0; j < boundary; j++) {
                int id_2;
                while (true) {
                    id_2 = rand.nextInt(tableSize_2) + 1;
                    if (!insertedIds.contains(id_2))
                        break;
                }
                insertedIds.add(id_2);

                if (swap) {
                    int temp = id_2;
                    id_2 = id_1;
                    id_1 = temp;
                }

                values.append(QUOTE).append(id_1).append(QUOTE).append(COMMA);
                values.append(QUOTE).append(id_2).append(QUOTE).append(COMMA);
                values.append(QUOTE).append(SAMPLE_DATE).append(QUOTE);
                values.append("\n");
            }


            if (i % BATCH_SIZE == 0 & i != 0) {
                writeCSV(relationName, values.toString());
                values = new StringBuilder();
            }
        }
        writeCSV(relationName, values.toString());
        fileNames.add(relationName);
    }

    private static void writeCSV(String tableName, String values) throws IOException {
        File f = new File("csv-files/" + tableName + ".csv");
        long fileLength = f.length();
        RandomAccessFile raf = new RandomAccessFile(f, "rw");
        raf.seek(fileLength);
        raf.writeBytes(values);
        raf.close();
    }

    private static void csvToMysql(String tableName) throws SQLException {

        String abs_path = new File("csv-files/" + tableName + ".csv").getAbsolutePath();
        String[] script = {"SET FOREIGN_KEY_CHECKS = 0",
                "LOAD DATA LOCAL INFILE '" + abs_path + "' INTO TABLE " + tableName +
                        " FIELDS TERMINATED BY ',' " +
                        " ENCLOSED BY '\"' " +
                        " LINES TERMINATED BY '\\n'" +
                        " IGNORE 1 LINES",
                "SET FOREIGN_KEY_CHECKS = 1"};

        Statement stmt = MysqlDao.getConn().createStatement();
        for (String s : script) {
            stmt.executeQuery(s);
        }
        stmt.close();
    }

    private static void recreateSakilaDatabase() throws SQLException, IOException {
        try {
            Statement stmt = MysqlDao.getConn().createStatement();
            String sql = "DROP DATABASE sakila";
            stmt.executeUpdate(sql);
            stmt.close();
        } catch (Exception ignored) {
        }

        ScriptRunner runner = new ScriptRunner(MysqlDao.getConn(), false, true);
        runner.runScript(new BufferedReader(new FileReader("sakila/sakila-schema.sql")));
        runner.runScript(new BufferedReader(new FileReader("sakila/sakila-data.sql")));
    }

    private static StringBuilder convertExistingRowsToCSV(List<List<String>> table) {
        StringBuilder values = new StringBuilder();
        for (List<String> row : table) {
            for (int j = 0; j < row.size(); j++) {
                String val = row.get(j);
                values.append(QUOTE).append(val).append(QUOTE);
                if (j != row.size() - 1)
                    values.append(COMMA);
            }
            values.append("\n");
        }
        return values;
    }

    private static void deleteTableContent(String tableName) throws SQLException {
        String foreign_off = "SET FOREIGN_KEY_CHECKS = 0";
        String delete_sql = "DELETE FROM " + tableName;
        String foreign_on = "SET FOREIGN_KEY_CHECKS = 1";

        Statement stmt = MysqlDao.getConn().createStatement();
        stmt.execute(foreign_off);
        stmt.executeUpdate(delete_sql);
        stmt.execute(foreign_on);
        stmt.close();

    }

    private static void removeCSVFiles() {
        File dir = new File("csv-files");
        for (File file : dir.listFiles())
            if (!file.isDirectory())
                file.delete();
    }
}
