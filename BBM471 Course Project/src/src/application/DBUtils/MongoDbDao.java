package application.DBUtils;

import application.Models.QueryModel;
import application.Models.TableModel;
import com.mongodb.*;
import javafx.beans.property.SimpleStringProperty;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.TableColumn;


import java.util.*;

public class MongoDbDao {
    private static DB db;

    private static long queryExecutionTime;
    private static long tableRenderingTime;

    public static void connect() {
        MongoClient mongoClient = new MongoClient("localhost", 27017);

        @SuppressWarnings("deprecation")
        DB db = mongoClient.getDB("sakila");
        MongoDbDao.db = db;
    }

    public static DB getDb() {
        return db;
    }


    public static TableModel getResult(List<QueryModel> queryList) {


        boolean join = false;
        QueryModel actor = null;
        QueryModel category = null;

        BasicDBObjectBuilder builder = BasicDBObjectBuilder.start();
        for (QueryModel query : queryList) {
            if (query.getPriority() > 2) {

                if (query.getTableName().equals("actor"))
                    actor = query;
                else if (query.getTableName().equals("category"))
                    category = query;
                if (query.getQueryTerm() != null && !query.getQueryTerm().equals(""))
                    builder.add(query.getTableName() + "." + query.getColumnName(), query.getQueryTerm());
            } else {
                join = true;
                if (query.getQueryTerm() != null && !query.getQueryTerm().equals(""))
                    builder.add(query.getColumnName(), query.getQueryTerm());
            }
        }

        TableModel resultTable;

        List<TableColumn> columns = new ArrayList<>();
        ObservableList<ObservableList<String>> rows = FXCollections.observableArrayList();

        DBCollection films = db.getCollection("films");


        long start1;
        long start2;
        if (join) {
            start1 = System.currentTimeMillis();
            DBCursor cursor = films.find(builder.get());
            start2 = System.currentTimeMillis();

            Set<String> keySet = null;
            while (cursor.hasNext()) {
                DBObject item = cursor.next();
                if (keySet == null) {
                    keySet = item.keySet();
                    columns = getColumns(new ArrayList<>(keySet));
                }
                ObservableList<String> row = FXCollections.observableArrayList();
                for (String key : keySet) {
                    Object val = item.get(key);
                    if (val != null)
                        row.add(item.get(key).toString());
                    else
                        row.add("");
                }
                rows.add(row);
            }
            resultTable = new TableModel(rows, columns);

        } else {
            start1 = System.currentTimeMillis();
            Iterable<DBObject> rs = null;
            if (actor != null) { // if only actor related query is selected

                rs = films.aggregate(Arrays.asList(
                        // find films that matches actors with the given query
                        new BasicDBObject("$match", new BasicDBObject("actor." + actor.getColumnName(), actor.getQueryTerm())),
                        // unwind actor field
                        new BasicDBObject("$unwind", "$actor"),
                        // find actors that matches with the given query
                        new BasicDBObject("$match", new BasicDBObject("actor." + actor.getColumnName(), actor.getQueryTerm())),
                        // take distinct actors
                        new BasicDBObject("$group", new BasicDBObject("_id", "$actor"))
                )).results();

            } else if (category != null) { // if only category name query is selected

                rs = films.aggregate(Arrays.asList(
                        new BasicDBObject("$match", new BasicDBObject("category." + category.getColumnName(), category.getQueryTerm())),
                        new BasicDBObject("$unwind", "$category"),
                        new BasicDBObject("$match", new BasicDBObject("category." + category.getColumnName(), category.getQueryTerm())),
                        new BasicDBObject("$group", new BasicDBObject("_id", "$category"))
                )).results();

            }
            start2 = System.currentTimeMillis();

            Set<String> keySet = null;
            if (rs != null) {
                for (DBObject item : rs) {
                    if (keySet == null) {
                        keySet = item.keySet();
                        columns = getColumns(new ArrayList<>(keySet));
                    }
                    ObservableList<String> row = FXCollections.observableArrayList();
                    for (String key : keySet) {
                        row.add(item.get(key).toString());
                    }
                    rows.add(row);
                }
            }

            resultTable = new TableModel(rows, columns);

        }
        queryExecutionTime = start2 - start1;
        tableRenderingTime = System.currentTimeMillis() - start2;
        return resultTable;
    }


    private static List<TableColumn> getColumns(List<String> columns) {
        List<TableColumn> tableColumns = new ArrayList<>();
        for (int i = 0; i < columns.size(); i++) {
            final int j = i;
            TableColumn col = new TableColumn(columns.get(i));
            col.setCellValueFactory(param ->
            {
                Object prop = ((TableColumn.CellDataFeatures<ObservableList, String>) param).getValue().get(j);
                return prop == null ? new SimpleStringProperty() : new SimpleStringProperty(prop.toString());
            });
            tableColumns.add(col);
        }
        return tableColumns;
    }

    public static long getQueryExecutionTime() {
        return queryExecutionTime;
    }

    public static long getTableRenderingTime() {
        return tableRenderingTime;
    }

}

