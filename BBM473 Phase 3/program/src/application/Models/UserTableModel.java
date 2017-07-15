package application.Models;

public class UserTableModel {
    private String tableName;
    private Integer rowCount;

    public UserTableModel(String tableName, int rowCount) {
        this.tableName = tableName;
        this.rowCount = rowCount;
    }

    public String getTableName() {
        return tableName;
    }

    public int getRowCount() {
        return rowCount;
    }
}
