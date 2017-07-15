package application.Controllers;

import application.DBUtils.MongoDbDao;
import application.DBUtils.MysqlDao;
import application.Models.TableModel;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.TableView;

import java.net.URL;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class TableController implements Initializable {

    @FXML
    private TableView mysqlTable;
    @FXML
    private TableView mongoTable;

    @FXML
    private Label mysqlQueryExecutionTime;
    @FXML
    private Label mysqlTableRenderingTime;
    @FXML
    private Label mongoQueryExecutionTime;
    @FXML
    private Label mongoTableRenderingTime;

    @Override
    public void initialize(URL location, ResourceBundle resources) {
        try {
            setRowTableView();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }


    public void setRowTableView() throws SQLException {

        TableModel mysqlTableModel = QueryController.getMysqlTableModel();

        mysqlTable.getColumns().addAll(mysqlTableModel.getColumns());
        mysqlTable.setItems(mysqlTableModel.getRows());
        mysqlTable.getSelectionModel().selectFirst();

        TableModel mongoTableModel = QueryController.getMongoTableModel();

        mongoTable.getColumns().addAll(mongoTableModel.getColumns());
        mongoTable.setItems(mongoTableModel.getRows());
        mongoTable.getSelectionModel().selectFirst();


        mysqlQueryExecutionTime.setText("Query Execution Time: " + MysqlDao.getQueryExecutionTime() + " ms");
        mysqlTableRenderingTime.setText("Table Rendering Time: " + MysqlDao.getTableRenderingTime() + " ms");
        mongoQueryExecutionTime.setText("Query Execution Time: " + MongoDbDao.getQueryExecutionTime() + " ms");
        mongoTableRenderingTime.setText("Table Rendering Time: " + MongoDbDao.getTableRenderingTime() + " ms");


    }


}
