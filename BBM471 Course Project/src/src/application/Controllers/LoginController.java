package application.Controllers;

import application.DBUtils.MongoDbDao;
import application.DBUtils.MysqlDao;
import application.Main;
import application.Utils.MysqlToMongo;
import application.Utils.SakilaDataGenerator;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.CheckBox;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

import java.io.IOException;
import java.sql.SQLException;

public class LoginController {

    @FXML
    private TextField mysqlUrlField;
    @FXML
    private TextField mysqlUsernameField;
    @FXML
    private PasswordField mysqlPasswordField;
    @FXML
    private CheckBox generateData;
    @FXML
    private CheckBox migrateToMongo;

    @FXML
    public void login() {

        String mysqlUrl = mysqlUrlField.getText();
        String mysqlUsername = mysqlUsernameField.getText();
        String mysqlPassword = mysqlPasswordField.getText();
        try {
            // Make connections to MySQL and MongoDB
            MysqlDao.connect(mysqlUrl, mysqlUsername, mysqlPassword);
            MongoDbDao.connect();

            // if first checkbox is selected,
            // generate random data and export it into csv files
            // then import them into MySQL
            if (generateData.isSelected()) {
                SakilaDataGenerator.run();
            }

            // if second checkbox is selected,
            // migrate MySQL sakila database to MongoDB
            if (migrateToMongo.isSelected()) {
                MysqlToMongo.run();
            }

            MysqlDao.getConn().setCatalog("sakila");
            showQueryView();

        } catch (ClassNotFoundException | SQLException | IOException e) {
            e.printStackTrace();
        }

    }

    private void showQueryView() throws IOException {
        Stage selectionStage = Main.getPrimaryStage();

        Parent root = FXMLLoader.load(getClass().getResource("../Views/QueryView.fxml"));

        selectionStage.setTitle("Filter");
        selectionStage.setScene(new Scene(root));
        selectionStage.centerOnScreen();
        selectionStage.show();
    }
}
