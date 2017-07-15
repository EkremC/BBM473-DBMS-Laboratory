package application.Models;

public class ColumnDetailModel {
    private String columnName;
    private String columnType;
    private char nullable;
    private String isPrimary;
    private String isForeign;


    public ColumnDetailModel(String columnName, String columnType, char nullable, String isPrimary, String isForeign) {
        this.columnName = columnName;
        this.columnType = columnType;
        this.nullable = nullable;
        this.isPrimary = isPrimary;
        this.isForeign = isForeign;
    }

    public String getColumnName() {
        return columnName;
    }

    public String getColumnType() {
        return columnType;
    }

    public char getNullable() {
        return nullable;
    }

    public String getIsPrimary() {
        return isPrimary;
    }

    public String getIsForeign() {
        return isForeign;
    }

    public void setIsPrimary(String isPrimary) {
        if (!this.isPrimary.equals("True"))
            this.isPrimary = isPrimary;
    }

    public void setIsForeign(String isForeign) {
        if (!this.isForeign.equals("True"))
            this.isForeign = isForeign;
    }
}
