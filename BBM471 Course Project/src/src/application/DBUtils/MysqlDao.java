package application.DBUtils;

import application.Models.QueryModel;
import application.Models.TableModel;
import com.mysql.jdbc.Connection;
import javafx.beans.property.SimpleStringProperty;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.TableColumn;

import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.*;

public class MysqlDao {

    private static Connection conn;

    private static long queryExecutionTime;
    private static long tableRenderingTime;


    public static void connect(String dbURL, String username, String password) throws ClassNotFoundException, SQLException {
        Class.forName("com.mysql.jdbc.Connection");
        Properties properties = new Properties();
        properties.setProperty("user", username);
        properties.setProperty("password", password);
        properties.setProperty("useSSL", "false");
        properties.setProperty("useServerPrepStmts", "false");
        properties.setProperty("rewriteBatchedStatements", "true");
        conn = (Connection) DriverManager.getConnection(dbURL, properties);
    }


    public static Connection getConn() {
        return conn;
    }

    /**
     * This function retrieves data from given table.
     *
     * @return TableModel object that contains list of columns and list of rows
     * @throws SQLException
     */
    public static TableModel getRowDetails(List<QueryModel> queryList) throws SQLException {

        ObservableList<ObservableList<String>> rows = FXCollections.observableArrayList();
        List<TableColumn> columns = new ArrayList<>();
        StringBuilder tables = createTableQuery(queryList);
        StringBuilder conditions = createWhereConditions(queryList);
        String sql = "SELECT * FROM " + tables + " " + conditions + " ";

        long start1 = System.currentTimeMillis();
        ResultSet rs = conn.createStatement().executeQuery(sql);
        long start2 = System.currentTimeMillis();


        // dynamically create columns
        for (int i = 0; i < rs.getMetaData().getColumnCount(); i++) {
            final int j = i;
            TableColumn col = new TableColumn(rs.getMetaData().getColumnName(i + 1));
            col.setCellValueFactory(param ->
            {
                Object prop = ((TableColumn.CellDataFeatures<ObservableList, String>) param).getValue().get(j);
                return prop == null ? new SimpleStringProperty() : new SimpleStringProperty(prop.toString());
            });
            columns.add(col);
        }

        while (rs.next()) {
            ObservableList<String> rowDetail = FXCollections.observableArrayList();
            for (int i = 1; i <= rs.getMetaData().getColumnCount(); i++) {
                rowDetail.add(rs.getString(i));
            }
            rows.add(rowDetail);
        }

        queryExecutionTime = start2 - start1;
        tableRenderingTime = System.currentTimeMillis() - start2;
        return new TableModel(rows, columns);
    }

    public static StringBuilder createTableQuery(List<QueryModel> queryList) {
        StringBuilder tables = new StringBuilder();
        LinkedHashSet<String> tableSet = new LinkedHashSet<>();
        boolean film = false;
        boolean actor = false;
        boolean category = false;

        for (QueryModel aQueryList : queryList) {
            tableSet.add(aQueryList.getTableName());
        }

        int hashSize = tableSet.size();
        Iterator<String> iterator = tableSet.iterator();
        if (hashSize == 1) {
            tables.append(iterator.next());
        } else {
            while (iterator.hasNext()) {
                String tableName = iterator.next();

                film = film || tableName.equals("film");
                actor = actor || tableName.equals("actor");
                category = category || tableName.equals("category");
            }

            if (film & actor & category) {
                tables.append(" film NATURAL JOIN film_actor NATURAL JOIN actor NATURAL JOIN film_category NATURAL JOIN category ");
            } else if (film & actor) {
                tables.append(" film NATURAL JOIN film_actor NATURAL JOIN actor ");
            } else if (film & category) {
                tables.append(" film NATURAL JOIN film_category NATURAL JOIN category ");
            } else if (actor & category) {
                tables.append(" actor NATURAL JOIN category ");
            }


        }

        System.out.println("tables: " + tables);
        return tables;

    }

    public static StringBuilder createWhereConditions(List<QueryModel> queryList) {
        StringBuilder conditions = new StringBuilder();

        int mysqlSize = queryList.size();
        conditions.append(" WHERE ");
        for (int i = 0; i < mysqlSize; i++) {
            if (!queryList.get(i).getQueryTerm().equals("")) {
                conditions.append(queryList.get(i).getColumnName() + " = " + "'"
                        + queryList.get(i).getQueryTerm() + "'" + " AND ");
            }

        }
        int length = conditions.length();
        if (conditions.lastIndexOf(" AND") == -1)
            conditions.delete(conditions.lastIndexOf(" WHERE"), length);
        else
            conditions.delete(conditions.lastIndexOf(" AND"), length);

        System.out.println("conditions: " + conditions);
        return conditions;
    }

    public static long getQueryExecutionTime() {
        return queryExecutionTime;
    }

    public static long getTableRenderingTime() {
        return tableRenderingTime;
    }
}
