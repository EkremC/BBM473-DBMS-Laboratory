package application.Controllers;

import application.Main;
import javafx.concurrent.Task;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Cursor;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;

import application.Models.DBModel;

/**
 * Controller for the LoginView
 * ----------------------------
 * Note: Codes in this class can look a bit messy, because we did try to change cursor type to WAIT
 * To do that, we have to create a task and do the necessary operations on this task to login.
 */
public class LoginController {

    @FXML
    private TextField dburlField;
    @FXML
    private TextField usernameField;
    @FXML
    private PasswordField passwordField;
    @FXML
    private Label connStatusLabel;

    private static Connection conn;

    public void login() throws IOException {
        Stage primaryStage = Main.getPrimaryStage();

        primaryStage.getScene().getRoot().setCursor(Cursor.WAIT);

        // Make the connection
        Task<Void> task = new Task<Void>() {
            @Override
            public Void call() throws Exception {
                String dbURL = dburlField.getText();
                String username = usernameField.getText();
                String password = passwordField.getText();
                DBModel.connect(dbURL, username, password);
                return null;
            }
        };

        // Print out necessary messages when connection failures happen
        task.exceptionProperty().addListener((observable, oldValue, newValue) -> {
            if (newValue != null) {
                try {
                    ClassNotFoundException ex = (ClassNotFoundException) newValue;
                    connStatusLabel.setText("Connection Failed: JDBC Driver is not installed");
                } catch (ClassCastException e) {
                    SQLException ex = (SQLException) newValue;
                    connStatusLabel.setText("Connection Failed: invalid username/password");
                }
            }
        });

        task.setOnFailed(e -> primaryStage.getScene().getRoot().setCursor(Cursor.DEFAULT));

        // Open MainView if login succeeded
        task.setOnSucceeded(e -> {
            primaryStage.getScene().getRoot().setCursor(Cursor.DEFAULT);
            // switch to user table view
            Parent root = null;
            try {
                root = FXMLLoader.load(getClass().getResource("../Views/MainView.fxml"));
            } catch (IOException e1) {
                e1.printStackTrace();
            }
            primaryStage.setTitle("User Tables");
            primaryStage.setScene(new Scene(root));
            primaryStage.centerOnScreen();
            primaryStage.show();
        });
        new Thread(task).start();


    }


}
