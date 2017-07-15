package application.Controllers;


import application.DBUtils.MongoDbDao;
import application.DBUtils.MysqlDao;
import application.Models.QueryModel;
import application.Models.TableModel;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.ComboBox;
import javafx.scene.control.ListCell;
import javafx.scene.control.TextField;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import javafx.util.StringConverter;

import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.ResourceBundle;

public class QueryController implements Initializable {

    @FXML
    private VBox queryBox;
    @FXML
    private ComboBox<Integer> filterNumber;

    private ObservableList<QueryModel> queryDropdownList;

    private List<HBox> hboxes;

    private static TableModel mysqlTableModel;
    private static TableModel mongoTableModel;


    @Override
    public void initialize(URL location, ResourceBundle resources) {

        queryDropdownList = FXCollections.observableArrayList();
        queryDropdownList.add(new QueryModel("Film Title", "film", "title", 1));
        queryDropdownList.add(new QueryModel("Film Release Year", "film", "release_year", 2));
        queryDropdownList.add(new QueryModel("Actor First Name", "actor", "first_name", 3));
        queryDropdownList.add(new QueryModel("Actor Last Name", "actor", "last_name", 4));
        queryDropdownList.add(new QueryModel("Category Name", "category", "name", 5));

        hboxes = new ArrayList<>();

        filterNumber.getItems().addAll(0, 1, 2, 3, 4, 5);

        filterNumber.setOnAction((event) -> {
            queryBox.getChildren().removeAll(hboxes);
            hboxes = new ArrayList<>();

            int val = filterNumber.getSelectionModel().getSelectedItem();

            for (int i = 0; i < val; i++) {
                HBox hbox = new HBox();
                hbox.setAlignment(Pos.CENTER);
                hbox.setPadding(new Insets(10, 0, 10, 0));

                ComboBox<QueryModel> cb = new ComboBox<>();
                comboBoxOptions(cb);
                cb.getSelectionModel().select(i);

                TextField textField = new TextField();

                hbox.getChildren().addAll(cb, textField);
                HBox.setMargin(cb, new Insets(0, 10, 0, 0));

                queryBox.getChildren().add(hbox);
                hboxes.add(hbox);
            }
        });

        filterNumber.setConverter(new StringConverter<Integer>() {
            @Override
            public String toString(Integer item) {
                if (item == null) {
                    return null;
                } else {
                    return "Filter Number - " + item;
                }
            }

            @Override
            public Integer fromString(String item) {
                return null; // No conversion fromString needed.
            }
        });
    }

    @FXML
    private void applyFilter() throws IOException, SQLException {
        List<QueryModel> queryList = new ArrayList<>();
        for (HBox hbox : hboxes) {
            ComboBox<QueryModel> cb = (ComboBox<QueryModel>) hbox.getChildren().get(0);
            QueryModel query = cb.getSelectionModel().getSelectedItem();
            if (query.getColumnName().equals("release_year"))
                query.setQueryTerm(((TextField) hbox.getChildren().get(1)).getText() + "-01-01");
            else
                query.setQueryTerm(((TextField) hbox.getChildren().get(1)).getText());
            queryList.add(query);
        }
        queryList.sort(new QueryPriorityOrder());
        mysqlTableModel = MysqlDao.getRowDetails(queryList);
        mongoTableModel = MongoDbDao.getResult(queryList);


        FXMLLoader fxmlLoader = new FXMLLoader(getClass().getResource("../Views/TableView.fxml"));
        Parent root = fxmlLoader.load();
        Stage selectionStage = new Stage();

        selectionStage.setTitle("Results");
        selectionStage.setScene(new Scene(root));
        selectionStage.show();

    }

    private void comboBoxOptions(ComboBox cb) {
        cb.setItems(queryDropdownList);

        cb.setCellFactory((comboBox) -> new ListCell<QueryModel>() {
            @Override
            protected void updateItem(QueryModel item, boolean empty) {
                super.updateItem(item, empty);

                if (item == null || empty) {
                    setText(null);
                } else {
                    setText(item.getFilterName());
                }
            }
        });

        cb.setConverter(new StringConverter<QueryModel>() {
            @Override
            public String toString(QueryModel item) {
                if (item == null) {
                    return null;
                } else {
                    return item.getFilterName();
                }
            }

            @Override
            public QueryModel fromString(String item) {
                return null; // No conversion fromString needed.
            }
        });

        cb.setOnAction((event) -> {
            for (HBox hbox : hboxes) {
                ComboBox c = (ComboBox) hbox.getChildren().get(0);
                if (cb != c) {
                    Object selected = c.getSelectionModel().getSelectedItem();
                    if (selected != null && selected.equals(cb.getSelectionModel().getSelectedItem())) {
                        c.getSelectionModel().clearSelection();
                        ((TextField) hbox.getChildren().get(1)).setText("");
                    }
                } else {
                    ((TextField) hbox.getChildren().get(1)).setText("");
                }

            }
        });
    }

    public static TableModel getMysqlTableModel() {
        return mysqlTableModel;
    }

    public static TableModel getMongoTableModel() {
        return mongoTableModel;
    }
}

class QueryPriorityOrder implements Comparator<QueryModel> {
    @Override
    public int compare(QueryModel o1, QueryModel o2) {
        return o1.getPriority().compareTo(o2.getPriority());
    }
}
