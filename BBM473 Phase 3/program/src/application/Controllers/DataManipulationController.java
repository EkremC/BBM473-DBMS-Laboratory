package application.Controllers;

import application.CustomFields.DateTimePicker;
import application.CustomFields.NumberTextField;
import application.Models.ColumnDetailModel;
import application.Models.DBModel;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Node;
import javafx.scene.control.*;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.Priority;
import javafx.stage.Stage;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.math.BigDecimal;
import java.net.URL;
import java.sql.SQLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.regex.Pattern;

/**
 * Controller for the DataManipulationView
 * ---------------------------------------
 * Handles insert, update and delete operations on database
 */
public class DataManipulationController implements Initializable {

    // Constants for data manipulation modes
    public static final int INSERT_MODE = 0;
    public static final int UPDATE_MODE = 1;
    public static final int DELETE_MODE = 2;

    // Regex constants for column types
    public static final String STRING_TYPE = "CHAR|VARCHAR2|VARCHAR|NCHAR|NVARCHAR2";
    public static final String NUMERIC_TYPE = "NUMBER|FLOAT";
    public static final String DATE_TYPE = "DATE";

    public static final String DATE_TIME_FORMAT = "yyyy-MM-dd HH:mm:ss.S";

    @FXML
    private GridPane formView;  // form for the fields of the table to be inserted/updated/deleted
    @FXML
    private Button commitBtn;   // Commits the values that user entered.
                                // Text of the button is changed according to manipulationMode


    private int manipulationMode;   // Current mode of the manipulation view
    private String tablename;       // Current name of the table that we are trying to apply manipulations on it
    private MainController mainController;  // After manipulation is done, screens on the MainView is updated using this object
    private ObservableList<String> selectedRow; // Values of the selected record in current table
    private ObservableList<ColumnDetailModel> columnDetails; // column details of the current table
    private List<String[]> foreignKeyDependencies;  // foreign key dependencies of the table to use in combobox
    private int foreignIndex;

    @Override
    public void initialize(URL location, ResourceBundle resources) {
    }

    /**
     *
     * @param manipulationMode INSERT_MODE, UPDATE_MODE, DELETE_MODE
     * @param tablename name of the table that we are trying to apply manipulations on it
     * @param selectedRow values of the selected record in current table
     * @param mainController after manipulation is done, screens on the MainView is updated using this object
     */
    public void invokeManipulationView(int manipulationMode, String tablename, ObservableList<String> selectedRow, MainController mainController) {
        this.manipulationMode = manipulationMode;
        this.tablename = tablename;
        this.selectedRow = selectedRow;
        this.mainController = mainController;

        try {
            initializeForm();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    /**
     * Initializes form, prepares field names and their types
     * If manipulation mode is update or delete, then fields will be filled from selectedRow object
     */
    private void initializeForm() throws SQLException {
        this.columnDetails = DBModel.getColumnDetails(tablename);
        this.foreignKeyDependencies = containsForeignKey() ? DBModel.getForeignKeyDependencies(tablename) : null;
        this.foreignIndex = 0;

        for (int i = 0; i < columnDetails.size(); i++) {

            ColumnDetailModel col = columnDetails.get(i);

            // set label of the field
            Label label = new Label(col.getColumnName());
            label.setMinWidth(2000);

            // set field with its type and value
            // get the value of current field if manipulation mode is not INSERT_MODE
            String value = manipulationMode == INSERT_MODE ? null : selectedRow.get(i);
            Control field = getField(col, value);

            formView.add(label, 0, i);
            formView.add(field, 1, i);
            GridPane.setMargin(label, new Insets(10, 10, 10, 50));
            GridPane.setMargin(field, new Insets(10, 50, 10, 10));
        }

        // set text of the commit button according to manipulation mode
        switch (manipulationMode) {
            case INSERT_MODE:
                commitBtn.setText("Insert Row");
                break;
            case UPDATE_MODE:
                commitBtn.setText("Update Row");
                break;
            case DELETE_MODE:
                commitBtn.setText("Delete Row");
                break;
        }
    }

    private Control getField(ColumnDetailModel col, String value) throws SQLException {

        // if column is foreign key, then get the values from its source table
        // and create a combobox with these values
        if (col.getIsForeign().equals("True")) {
            ObservableList<String> comboboxValues = DBModel.getForeignData(
                    foreignKeyDependencies.get(foreignIndex)[0], foreignKeyDependencies.get(foreignIndex)[1]);
            foreignIndex++;
            ComboBox<String> comboBox = new ComboBox<>(comboboxValues);
            comboBox.setValue(value);
            return comboBox;
        }

        // if it is not a foreign key, then create a field according to its type
        String type = col.getColumnType();
        if (Pattern.matches(STRING_TYPE, type)) {
            return manipulationMode == INSERT_MODE ? new TextField() : new TextField(value);
        } else if (Pattern.matches(NUMERIC_TYPE, type)) {
            return manipulationMode == INSERT_MODE ? new NumberTextField() : new NumberTextField(new BigDecimal(value));
        } else if (Pattern.matches(DATE_TYPE, type)) {
            DateTimeFormatter formatter = DateTimeFormatter.ofPattern(DATE_TIME_FORMAT);
            DateTimePicker dateTimePicker = new DateTimePicker();
            dateTimePicker.setFormat(DATE_TIME_FORMAT);
            if (manipulationMode != INSERT_MODE)
                dateTimePicker.setDateTimeValue(LocalDateTime.parse(value, formatter));
            return dateTimePicker;
        }
        return new TextField();
    }

    /**
     * When commit button is clicked, this function is invoked.
     * It collects the values from fields, then it calls function from DBModel
     * to manipulate on database according to manipulation mode.
     */
    @FXML
    public void commitChanges() {
        // Collect values from fields
        List<String> values = new ArrayList<>();
        if (manipulationMode != DELETE_MODE) {
            ObservableList<Node> fields = formView.getChildren();
            for (int i = 0; i < columnDetails.size(); i++) {
                final int j = 2 * i;
                String fieldType = columnDetails.get(i).getColumnType();
                String fieldValue = "";
                try {
                    if (Pattern.matches(STRING_TYPE, fieldType)) {
                        fieldValue = ((TextField) fields.get(j + 1)).getText();
                    } else if (Pattern.matches(NUMERIC_TYPE, fieldType)) {
                        fieldValue = ((NumberTextField) fields.get(j + 1)).getText();
                    } else if (Pattern.matches(DATE_TYPE, fieldType)) {
                        DateTimeFormatter formatter = DateTimeFormatter.ofPattern(DATE_TIME_FORMAT);
                        LocalDateTime date = ((DateTimePicker) fields.get(j + 1)).getDateTimeValue();
                        fieldValue = date.format(formatter);
                    }
                } catch (ClassCastException e) {
                    fieldValue = ((ComboBox<String>) fields.get(j + 1)).getValue();
                }
                values.add(fieldValue);
            }
        }

        // apply manipulations according to manipulation mode
        try {
            switch (manipulationMode) {
                case INSERT_MODE:
                    DBModel.insert(tablename, columnDetails, values);
                    break;
                case UPDATE_MODE:
                    DBModel.update(tablename, columnDetails, selectedRow, values);
                    break;
                case DELETE_MODE:
                    DBModel.delete(tablename, columnDetails, selectedRow);
                    break;
            }
            successAlert();

            Stage stage = (Stage) commitBtn.getScene().getWindow();
            stage.close();

            // update MainView
            mainController.setColumnTableView(tablename);
            mainController.setRowTableView(tablename);

        } catch (SQLException e) {
            exceptionAlert(e);
            e.printStackTrace();
        }
    }

    /**
     * @return is table contains at least one foreign key
     */
    private boolean containsForeignKey() {
        for (ColumnDetailModel col : columnDetails) {
            if (col.getIsForeign().equals("True"))
                return true;
        }
        return false;
    }

    /**
     * Fires a popup screen on successful manipulations
     */
    private void successAlert() {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        if (manipulationMode == INSERT_MODE) {
            alert.setTitle("Insert Operation");
            alert.setContentText("Insert Operation Successful!");
        } else if (manipulationMode == UPDATE_MODE) {
            alert.setTitle("Update Operation");
            alert.setContentText("Update Operation Successful!");
        } else if (manipulationMode == DELETE_MODE) {
            alert.setTitle("Delete Operation");
            alert.setContentText("Delete Operation Successful!");
        }
        alert.setHeaderText(null);
        alert.showAndWait();
    }

    /**
     * Fires a popup screen on failed manipulations with exception details
     */
    private void exceptionAlert(Exception ex) {
        Alert alert = new Alert(Alert.AlertType.ERROR);
        if (manipulationMode == INSERT_MODE) {
            alert.setHeaderText("Insert Operation Failed!");
        } else if (manipulationMode == UPDATE_MODE) {
            alert.setHeaderText("Update Operation Failed!");
        } else if (manipulationMode == DELETE_MODE) {
            alert.setHeaderText("Delete Operation Failed!");
        }
        alert.setTitle("Error");


        // When a not-null columns is empty, the message "<column-name> cannot be empty" will be printed on the screen.
        if (ex.getMessage().contains("cannot insert NULL")) {
            String[] split = ex.getMessage().split("(\".\")|(\"[)])");
            alert.setContentText(split[split.length - 2] + " cannot be empty!");
        } else {
            alert.setContentText("An exception occured!");
        }

        StringWriter sw = new StringWriter();
        PrintWriter pw = new PrintWriter(sw);
        ex.printStackTrace(pw);
        String exceptionText = sw.toString();

        Label label = new Label("The exception stacktrace was:");

        TextArea textArea = new TextArea(exceptionText);
        textArea.setEditable(false);
        textArea.setWrapText(true);

        textArea.setMaxWidth(Double.MAX_VALUE);
        textArea.setMaxHeight(Double.MAX_VALUE);
        GridPane.setVgrow(textArea, Priority.ALWAYS);
        GridPane.setHgrow(textArea, Priority.ALWAYS);

        GridPane expContent = new GridPane();
        expContent.setMaxWidth(Double.MAX_VALUE);
        expContent.add(label, 0, 0);
        expContent.add(textArea, 0, 1);

        alert.getDialogPane().setExpandableContent(expContent);

        alert.showAndWait();
    }

}
