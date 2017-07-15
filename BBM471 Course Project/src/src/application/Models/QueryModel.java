package application.Models;

public class QueryModel {
    private String filterName;
    private String tableName;
    private String columnName;
    private String queryTerm;
    private int priority;

    public QueryModel(String filterName, String tableName, String columnName, int priority) {
        this.filterName = filterName;
        this.tableName = tableName;
        this.columnName = columnName;
        this.priority = priority;
    }

    public String getFilterName() {
        return filterName;
    }

    public String getTableName() {
        return tableName;
    }

    public String getColumnName() {
        return columnName;
    }

    public Integer getPriority() {
        return priority;
    }

    public String getQueryTerm() {
        return queryTerm;
    }

    public void setQueryTerm(String queryTerm) {
        this.queryTerm = queryTerm;
    }
}
