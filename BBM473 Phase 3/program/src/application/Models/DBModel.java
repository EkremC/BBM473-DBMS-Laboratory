package application.Models;


import javafx.beans.property.SimpleStringProperty;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.TableColumn;

import java.sql.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import static application.Controllers.DataManipulationController.DATE_TYPE;

/**
 * DBModel handles SQL queries
 */
public class DBModel {

    private static Connection conn;

    private final static String ORACLE_DATE_FORMAT = "YYYY/MM/DD HH24:MI:SS";

    public static void connect(String dbURL, String username, String password) throws ClassNotFoundException, SQLException {
        Class.forName("oracle.jdbc.driver.OracleDriver");
        conn = DriverManager.getConnection(dbURL, username, password);
    }

    /**
     * @return List of UserTableModel objects, which contains name of the tables and their rows
     */
    public static ObservableList<UserTableModel> getUserTables() throws SQLException {
        String query = "SELECT table_name FROM user_tables";
        Statement stmt = conn.createStatement();
        ResultSet rs = stmt.executeQuery(query);

        ObservableList<UserTableModel> userTables = FXCollections.observableArrayList();
        while (rs.next()) {
            String tablename = rs.getString("table_name");
            int rowcount = getRowCount(tablename);
            userTables.add(new UserTableModel(tablename, rowcount));
        }
        return userTables;
    }

    /**
     * @return column details with column name, data type, nullable, is primary and is foreign fields
     * @throws SQLException
     */
    public static ObservableList<ColumnDetailModel> getColumnDetails(String tablename) throws SQLException {
        /*This query returns information about columns in a table. It joins two sub-query, first one
          consists of column_name, data_type and nullable values while the second one consists of
          column_name and constraint_name. We apply left outer join on column names so that
          columns without constraints are also be returned in this query.
          */
        String query = "SELECT A.COLUMN_NAME, A.DATA_TYPE, A.NULLABLE, B.CONSTRAINT_TYPE FROM (" +
                "  SELECT usrcols.COLUMN_NAME, usrcols.DATA_TYPE, usrcols.NULLABLE" +
                "  FROM user_tab_cols usrcols" +
                "  WHERE usrcols.table_name = '" + tablename + "'" +
                "  ORDER BY usrcols.column_id" +
                ") A " +
                "LEFT OUTER JOIN (" +
                "  SELECT cols.column_name, cons.constraint_type" +
                "  FROM user_constraints cons, user_cons_columns cols" +
                "  WHERE cols.table_name = '" + tablename + "'" +
                "  AND cons.constraint_name = cols.constraint_name" +
                ") B " +
                "ON A.COLUMN_NAME = B.COLUMN_NAME";

        Statement stmt = conn.createStatement();
        ResultSet rs = stmt.executeQuery(query);
        ObservableList<ColumnDetailModel> columnDetails = FXCollections.observableArrayList();
        while (rs.next()) {
            String columnName = rs.getString("COLUMN_NAME");
            String columnType = rs.getString("DATA_TYPE");
            char nullable = rs.getString("NULLABLE").charAt(0);
            String constraintType = rs.getString("CONSTRAINT_TYPE");
            String isPrimary = "False";
            String isForeign = "False";
            if (constraintType != null && constraintType.equals("P")) {
                isPrimary = "True";
            } else if (constraintType != null && constraintType.equals("R")) {
                isForeign = "True";
            }

            int columnIndex = getColumnIndex(columnDetails, columnName);
            if (columnIndex != -1) {
                columnDetails.get(columnIndex).setIsPrimary(isPrimary);
                columnDetails.get(columnIndex).setIsForeign(isForeign);
            } else {
                columnDetails.add(new ColumnDetailModel(columnName, columnType, nullable, isPrimary, isForeign));
            }
        }
        return columnDetails;
    }

    /**
     * This function retrieves data from given table.
     *
     * @return DataRowModel object that contains list of columns and list of rows
     * @throws SQLException
     */
    public static DataRowModel getRowDetails(String tablename) throws SQLException {
        ObservableList<ObservableList<String>> rows = FXCollections.observableArrayList();
        List<TableColumn> columns = new ArrayList<>();
        String sql = "select * from " + tablename;
        ResultSet rs = conn.createStatement().executeQuery(sql);

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
        return new DataRowModel(rows, columns);
    }


    private static int getRowCount(String tablename) throws SQLException {
        Statement stmt = conn.createStatement();
        String query = "SELECT COUNT(*) FROM " + tablename;
        ResultSet rs = stmt.executeQuery(query);
        rs.next();
        return rs.getInt(1);
    }

    /**
     * This function creates sql string for insert operation
     */
    public static void insert(String tablename, ObservableList<ColumnDetailModel> columns, List<String> values) throws SQLException {
        String columnsString = " (";
        String valuesString = " (";
        for (int i = 0; i < columns.size(); i++) {
            ColumnDetailModel column = columns.get(i);

            columnsString += column.getColumnName();
            columnsString += i < columns.size() - 1 ? ", " : ") ";

            if (column.getColumnType().equals(DATE_TYPE)) {
                valuesString += sqlToDate(values.get(i));
            } else {
                valuesString += values.get(i) == null ? null : "'" + values.get(i) + "'";
            }

            valuesString += i < columns.size() - 1 ? ", " : ") ";
        }

        Statement stmt = conn.createStatement();
        String sql = "INSERT INTO " + tablename + columnsString + "VALUES" + valuesString;
        stmt.executeUpdate(sql);
    }

    /**
     * This function creates sql string for update operation
     */
    public static void update(String tablename, ObservableList<ColumnDetailModel> columns, List<String> oldValues, List<String> values) throws SQLException {
        String updateString = "";
        String conditionString = "";
        for (int i = 0; i < columns.size(); i++) {
            ColumnDetailModel column = columns.get(i);

            updateString += column.getColumnName() + " = ";
            conditionString += column.getColumnName();
            if (column.getColumnType().equals(DATE_TYPE)) {
                updateString += sqlToDate(values.get(i));
                conditionString += " = " + sqlToDate(oldValues.get(i));
            } else {
                updateString += values.get(i) == null ? null : "'" + values.get(i) + "'";
                conditionString += oldValues.get(i) == null ? " IS NULL " : " = '" + oldValues.get(i) + "'";
            }

            if (i < columns.size() - 1) {
                updateString += ", ";
                conditionString += " AND ";
            }
        }

        Statement stmt = conn.createStatement();
        String sql = "UPDATE " + tablename + " SET " + updateString + " WHERE " + conditionString;
        stmt.executeUpdate(sql);
    }

    /**
     * This function creates sql string for delete operation
     */
    public static void delete(String tablename, ObservableList<ColumnDetailModel> columns, List<String> values) throws SQLException {
        String conditionString = "";
        for (int i = 0; i < columns.size(); i++) {
            ColumnDetailModel column = columns.get(i);

            conditionString += column.getColumnName();
            if (column.getColumnType().equals(DATE_TYPE)) {
                conditionString += " = " + sqlToDate(values.get(i));
            } else {
                conditionString += values.get(i) == null ? " IS NULL " : " = '" + values.get(i) + "'";
            }

            conditionString += (i < (columns.size() - 1)) ? " AND " : "";
        }

        Statement stmt = conn.createStatement();
        String sql = "DELETE FROM " + tablename + " WHERE " + conditionString;
        stmt.executeUpdate(sql);
    }


    /**
     * @return foreign key dependencies of the given table in list of source table and column name of the foreign key
     */
    public static List<String[]> getForeignKeyDependencies(String tableName) throws SQLException {
        /*This query finds the table name and column name where foreign keys in a table belong to.
          user_constraints table is used for accessing the constraint type and user_cons_columns
          table is used for accessing column names of the reference type constraints.
         */
        String query = "SELECT " +
                "src_tbl.TABLE_NAME, cons_col.COLUMN_NAME " +
                "FROM user_constraints src_tbl, user_constraints ref_tbl, user_cons_columns cons_col " +
                "WHERE ref_tbl.constraint_type = 'R' " +
                "AND src_tbl.constraint_name = ref_tbl.r_constraint_name " +
                "AND cons_col.constraint_name = ref_tbl.r_constraint_name " +
                "AND ref_tbl.table_name = '" + tableName + "'";
        Statement stmt = conn.createStatement();
        ResultSet rs = stmt.executeQuery(query);

        List<String[]> foreignKeyDependencies = new ArrayList<>();
        while (rs.next()) {
            String srcTableName = rs.getString("TABLE_NAME");
            String srcColumnName = rs.getString("COLUMN_NAME");
            String[] foreignKeyDependency = {srcTableName, srcColumnName};
            foreignKeyDependencies.add(foreignKeyDependency);
        }
        return foreignKeyDependencies;
    }

    public static ObservableList<String> getForeignData(String tableName, String columnName) throws SQLException {
        String query = "SELECT " + columnName + " FROM " + tableName;
        Statement stmt = conn.createStatement();
        ResultSet rs = stmt.executeQuery(query);
        ObservableList<String> values = FXCollections.observableArrayList();
        while (rs.next()) {
            values.add(rs.getString(columnName));
        }
        return values;
    }


    private static String sqlToDate(String date) {
        return "to_date( substr('" + date + "', 1, 19), '" + ORACLE_DATE_FORMAT + "' )";
    }

    private static int getColumnIndex(List<ColumnDetailModel> list, String columnName) {
        for (int i = 0; i < list.size(); i++) {
            if (list.get(i).getColumnName().equals(columnName))
                return i;
        }
        return -1;
    }

}
