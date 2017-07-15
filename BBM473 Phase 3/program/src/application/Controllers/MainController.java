package application.Controllers;

import application.Models.ColumnDetailModel;
import application.Models.DBModel;
import application.Models.DataRowModel;
import application.Models.UserTableModel;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.ResourceBundle;

/**
 * Controller for the MainView screen
 * ----------------------------------
 * MainView contains two parts:
 * - table names and their row numbers on the left side
 * - Column details and records of the selected table on the right side
 *
 */
public class MainController implements Initializable {

    @FXML
    private TableView userTableView;    // grid for the user tables
    @FXML
    private TableView columnTableView;  // grid for the column details of the selected user table
    @FXML
    private TableView rowTableView;     // grid for the records on selected user table
    @FXML
    private Label tableCount;           // number of user tables


    /**
     * When MainView is initialized set user tables, column details and rows.
     */
    @Override
    public void initialize(URL location, ResourceBundle resources) {
        try {
            String tablename = setUserTableView();
            setColumnTableView(tablename);
            setRowTableView(tablename);

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    /**
     * This function sets the grid view for user tables
     * @return name of the first table
     */
    private String setUserTableView() throws SQLException {
        // Get user tables from DBModel in ObservableList
        ObservableList<UserTableModel> userTables = DBModel.getUserTables();

        // Configure "Table Name" column settings
        TableColumn<UserTableModel, String> tablename = new TableColumn<>("Table Name");
        tablename.setMinWidth(250);
        tablename.setCellValueFactory(new PropertyValueFactory<>("tableName"));

        // Configure "Number of Rows" column settings
        TableColumn<UserTableModel, Integer> rowCount = new TableColumn<>("Number of Rows");
        rowCount.setMinWidth(150);
        rowCount.setCellValueFactory(new PropertyValueFactory<>("rowCount"));


        tableCount.setText(String.valueOf(userTables.size()));  // Set "Number of Tables" label

        // Add items and columns to userTableView object
        userTableView.setItems(userTables);
        userTableView.getColumns().addAll(tablename, rowCount);

        // In order to display column details and rows in a table, select the first table in user tables grid
        userTableView.getSelectionModel().selectFirst();
        return userTables.get(0).getTableName();
    }

    /**
     * This function sets the grid view for the column details of the selected table
     * @param tablename name of the selected table, it will be queried to gather column details
     */
    public void setColumnTableView(String tablename) throws SQLException {
        columnTableView.getColumns().clear();

        // Get column details from DBModel in ObservableList
        ObservableList<ColumnDetailModel> columnDetails = DBModel.getColumnDetails(tablename);

        // Configuration of the columns "Column Name", "Column Type", "Nullable", "Is Primary" and "Is Foreign"
        TableColumn<ColumnDetailModel, String> columnName = new TableColumn<>("Column Name");
        columnName.setMinWidth(225);
        columnName.setCellValueFactory(new PropertyValueFactory<>("columnName"));

        TableColumn<ColumnDetailModel, String> columnType = new TableColumn<>("Column Type");
        columnType.setMinWidth(125);
        columnType.setCellValueFactory(new PropertyValueFactory<>("columnType"));

        TableColumn<ColumnDetailModel, String> nullable = new TableColumn<>("Nullable");
        nullable.setMinWidth(100);
        nullable.setCellValueFactory(new PropertyValueFactory<>("nullable"));

        TableColumn<ColumnDetailModel, String> isPrimary = new TableColumn<>("Is Primary");
        isPrimary.setMinWidth(100);
        isPrimary.setCellValueFactory(new PropertyValueFactory<>("isPrimary"));

        TableColumn<ColumnDetailModel, String> isForeign = new TableColumn<>("Is Foreign");
        isForeign.setMinWidth(100);
        isForeign.setCellValueFactory(new PropertyValueFactory<>("isForeign"));

        // Add items and columns to columnTableView object
        columnTableView.setItems(columnDetails);
        columnTableView.getColumns().addAll(columnName, columnType, nullable, isPrimary, isForeign);
    }


    /**
     * This function sets the grid view for the data rows of the selected table
     * @param tablename name of the selected table, it will be queried to gather rows of that table
     */
    public void setRowTableView(String tablename) throws SQLException {
        // Dynamically get columns of the table and rows from DBModel in a DataRowModel instance
        DataRowModel rowDetails = DBModel.getRowDetails(tablename);
        rowTableView.getColumns().clear();

        // Add items and columns to rowTableView object
        rowTableView.getColumns().addAll(rowDetails.getColumns());
        rowTableView.setItems(rowDetails.getRows());
        rowTableView.getSelectionModel().selectFirst();
    }


    /**
     * When a user table selected, column details and rows in that table are updated in this function
     */
    @FXML
    public void onUserTableRowClicked() throws Exception {
        UserTableModel row = (UserTableModel) userTableView.getSelectionModel().getSelectedItem();
        setColumnTableView(row.getTableName());
        setRowTableView(row.getTableName());
    }

    /**
     * Show ManipulationView in INSERT_MODE
     */
    @FXML
    public void onInsertClicked() throws Exception {
        showManipulationView(DataManipulationController.INSERT_MODE, "Insert Row", null);
    }

    /**
     * Show ManipulationView in UPDATE_MODE
     */
    @FXML
    public void onUpdateClicked() throws Exception {
        ObservableList<String> selectedRow = (ObservableList<String>) rowTableView.getSelectionModel().getSelectedItem();
        if (selectedRow != null)
            showManipulationView(DataManipulationController.UPDATE_MODE, "Update Row", selectedRow);
    }

    /**
     * Show ManipulationView in DELETE_MODE
     */
    @FXML
    public void onDeleteClicked() throws Exception {
        ObservableList<String> selectedRow = (ObservableList<String>) rowTableView.getSelectionModel().getSelectedItem();
        if (selectedRow != null)
            showManipulationView(DataManipulationController.DELETE_MODE, "Delete Row", selectedRow);
    }


    /**
     * This function opens ManipulationView in a new window and configures its settings
     * @param mode INSERT_MODE, UPDATE_MODE, DELETE_MODE
     * @param title Title of the screen
     * @param selectedRow contains the values of the selected record's values (only for UPDATE_MODE and DELETE_MODE)
     */
    private void showManipulationView(int mode, String title, ObservableList<String> selectedRow) throws IOException {
        Stage manipulationStage = new Stage();
        FXMLLoader fxmlLoader = new FXMLLoader(getClass().getResource("../Views/DataManipulationView.fxml"));
        Parent root = fxmlLoader.load();
        DataManipulationController controller = fxmlLoader.getController();
        manipulationStage.setTitle(title);
        manipulationStage.setScene(new Scene(root));
        String tablename = ((UserTableModel) userTableView.getSelectionModel().getSelectedItem()).getTableName();
        controller.invokeManipulationView(mode, tablename, selectedRow, this);
        manipulationStage.show();
    }


}



