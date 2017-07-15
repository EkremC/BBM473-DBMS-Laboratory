package application.Models;

import javafx.collections.ObservableList;
import javafx.scene.control.TableColumn;

import java.util.List;

public class TableModel {
    private ObservableList<ObservableList<String>> rows;
    private List<TableColumn> columns;

    public TableModel(ObservableList<ObservableList<String>> rows, List<TableColumn> columns) {
        this.rows = rows;
        this.columns = columns;
    }

    public ObservableList<ObservableList<String>> getRows() {
        return rows;
    }

    public List<TableColumn> getColumns() {
        return columns;
    }
}
