package application.Utils;

import application.DBUtils.MongoDbDao;
import application.DBUtils.MysqlDao;
import com.mongodb.*;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class MysqlToMongo { /*
                         * Load some MySQL data into MongoDb
						 */

    private static PreparedStatement actorQry;
    private static PreparedStatement categoryQry;

    private static BasicDBList getActors(Integer filmId)
            throws SQLException {
        BasicDBList actorList = new BasicDBList();

        actorQry.setInt(1, filmId);
        ResultSet actorsRs = actorQry.executeQuery();

        while (actorsRs.next()) { // For each actor

            // Create the actor document
            BasicDBObject actorDoc = new BasicDBObject();
            actorDoc.put("actor_id", actorsRs.getInt("ACTOR_ID"));
            actorDoc.put("first_name", actorsRs.getString("FIRST_NAME"));
            actorDoc.put("last_name", actorsRs.getString("LAST_NAME"));
            actorDoc.put("actor_last_update", actorsRs.getString("ACTOR_LAST_UPDATE"));
            // Add actors to the list of actors
            actorList.add(actorDoc);

        }
        return (actorList);
    }


    private static BasicDBList getCategories(Integer filmId)
            throws SQLException {
        BasicDBList categoryList = new BasicDBList();

        categoryQry.setInt(1, filmId);
        ResultSet categoriesRs = categoryQry.executeQuery();

        while (categoriesRs.next()) { // For each category

            // Create the category document
            BasicDBObject categoryDoc = new BasicDBObject();
            categoryDoc.put("category_id", categoriesRs.getInt("CATEGORY_ID"));
            categoryDoc.put("name", categoriesRs.getString("NAME"));
            categoryDoc.put("category_last_update", categoriesRs.getString("CATEGORY_LAST_UPDATE"));
            // Add category to the list of categories
            categoryList.add(categoryDoc);

        }
        return (categoryList);
    }


    private static void initializeSQL(Connection mysqlConn) throws SQLException {
        String actorSQL = "SELECT actor.first_name, actor.last_name , film_actor.actor_id, actor.actor_last_update "
                + "FROM  sakila.film_actor film_actor "
                + "   INNER JOIN sakila.actor actor "
                + "     ON (film_actor.actor_id = actor.actor_id) where film_id=?";
        actorQry = mysqlConn.prepareStatement(actorSQL);

        String categorySQL = "SELECT category.name, film_category.category_id, category.category_last_update "
                + "   FROM  sakila.film_category film_category "
                + "   INNER JOIN sakila.category category "
                + "     ON (film_category.category_id = category.category_id) where film_id=?";
        categoryQry = mysqlConn.prepareStatement(categorySQL);
    }

    private static void insertFilms(Connection mysqlConn, DB mongoDb,
                                    String mongoCollection) throws SQLException {

        List<Integer> ids = new ArrayList<>();

        String filmSQL = "SELECT * FROM film ";
        Statement query = mysqlConn.createStatement();
        ResultSet fileRs = query.executeQuery(filmSQL);

        DBCollection filmCollection = mongoDb.getCollection(mongoCollection);
        filmCollection.drop();

        Integer filmCount = 0;

        while (fileRs.next()) { // For each film

            // Create the actors document
            BasicDBObject filmDoc = new BasicDBObject();
            Integer filmId = fileRs.getInt("FILM_ID");
            filmDoc.put("_id", filmId);
            filmDoc.put("title", fileRs.getString("TITLE"));
            filmDoc.put("description", fileRs.getString("DESCRIPTION"));
            filmDoc.put("release_year", fileRs.getString("RELEASE_YEAR"));
            filmDoc.put("language_id", fileRs.getString("LANGUAGE_ID"));
            filmDoc.put("original_language_id", fileRs.getString("ORIGINAL_LANGUAGE_ID"));
            filmDoc.put("rental_duration", fileRs.getString("RENTAL_DURATION"));
            filmDoc.put("rental_rate", fileRs.getString("RENTAL_RATE"));
            filmDoc.put("length", fileRs.getString("LENGTH"));
            filmDoc.put("replacement_cost", fileRs.getString("REPLACEMENT_COST"));
            filmDoc.put("rating", fileRs.getString("RATING"));
            filmDoc.put("special_features", fileRs.getString("SPECIAL_FEATURES"));
            filmDoc.put("film_last_update", fileRs.getString("FILM_LAST_UPDATE"));


            BasicDBList categoryList = getCategories(filmId);
            // put the category list into the film document
            filmDoc.put("category", categoryList);


            BasicDBList actorList = getActors(filmId);
            // put the actor list into the film document
            filmDoc.put("actor", actorList);

            if (filmCount % 50000 == 0) {
                System.out.print(".");
            }
            ids.add(filmId);
            filmCollection.insert(filmDoc); // insert the film
            filmCount++;
        }
        System.out.println("");
        System.out.println(filmCount + " films loaded into " + mongoCollection);
    }

    public static void run() {
        try {

            Class.forName("com.mysql.jdbc.Driver").newInstance();
            Connection myConnection = MysqlDao.getConn();
            myConnection.setCatalog("sakila");
            initializeSQL(myConnection);

            insertFilms(myConnection, MongoDbDao.getDb(), "films");
            System.out.println("Done");

        } catch (Exception x) {
            x.printStackTrace();
            System.exit(2);
        }

    }
}