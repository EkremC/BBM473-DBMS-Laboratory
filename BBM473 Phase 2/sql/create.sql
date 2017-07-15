
CREATE TABLE RoleTbl(
   roleID int NOT NULL, 
   rolename VARCHAR2(30) NOT NULL, 
   description VARCHAR2(200) NOT NULL, 
   CONSTRAINT role_pk PRIMARY KEY (roleID)
   );  
   

  
CREATE TABLE PermissionTbl(
  permissionID int NOT NULL,
  permission_name VARCHAR2(30) NOT NULL, 
  description VARCHAR2(200) NOT NULL,
  CONSTRAINT permission_pk PRIMARY KEY (permissionID)
  );
  
CREATE TABLE RolePermission(
  roleID int NOT NULL, 
  permissionID int NOT NULL, 
  CONSTRAINT fk_role FOREIGN KEY (roleID) REFERENCES RoleTbl(roleID) ON DELETE CASCADE,
  CONSTRAINT fk_permission FOREIGN KEY (permissionID) REFERENCES PermissionTbl(permissionID) ON DELETE CASCADE
  );
  

CREATE TABLE UserTbl(
  userid int NOT NULL,
  username VARCHAR2(30) NOT NULL,
  user_password VARCHAR2(30) NOT NULL,
  first_name VARCHAR2(30) NOT NULL,
  surname VARCHAR2(30) NOT NULL,
  region VARCHAR2(30) NOT NULL,
  CONSTRAINT userid_pk PRIMARY KEY (userid),
  CONSTRAINT username_unique UNIQUE (username)
  );
  
CREATE TABLE SystemUser(
  userid int NOT NULL,
  roleID int NOT NULL,
  isActive NUMBER(1),
  CONSTRAINT systemuser_pk PRIMARY key (userid),
  CONSTRAINT fk_user_system FOREIGN KEY (userid) REFERENCES UserTbl(userid) ON DELETE CASCADE,
  CONSTRAINT fk_user_role FOREIGN KEY (roleID) REFERENCES RoleTbl(roleID)
  );  
  

CREATE TABLE Contact(
  userid int NOT NULL, 
  country VARCHAR2(30) NOT NULL, 
  city VARCHAR2(30) NOT NULL, 
  phone VARCHAR2(30) NOT NULL, 
  CONSTRAINT contact_pk PRIMARY KEY (userid),
  CONSTRAINT fk_contact FOREIGN KEY (userid) REFERENCES UserTbl(userid)
  );
  
  
CREATE TABLE CommercialUser(
  userid int NOT NULL,
  isPremium NUMBER(1),
  CONSTRAINT commercial_pk PRIMARY KEY (userid),
  CONSTRAINT fk_commercial FOREIGN KEY (userid) REFERENCES UserTbl(userid) ON DELETE CASCADE
  );  
  
  
CREATE TABLE PaymentDetail(
  userid int NOT NULL,
  credit_card_no VARCHAR2(16) NOT NULL,
  security_no VARCHAR2(3) NOT NULL,
  bill_address VARCHAR2(200) NOT NULL,
  expire_date VARCHAR2(5) NOT NULL,
  CONSTRAINT payment_pk PRIMARY KEY (userid),
  CONSTRAINT fk_payment FOREIGN KEY (userid) REFERENCES UserTbl(userid) ON DELETE CASCADE
  );
  

CREATE TABLE Book(
  bookID int NOT NULL,
  bookname VARCHAR2(30) NOT NULL,
  book_summary VARCHAR2(750) NOT NULL,
  cover_image VARCHAR2(30) NOT NULL, 
  insert_user int NOT NULL, 
  last_update_user int NOT NULL, 
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT book_pk PRIMARY KEY (bookID),
  CONSTRAINT fk_insert_book FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_book FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );  

CREATE TABLE Author(
  authorID int NOT NULL,
  author_name VARCHAR2(30) NOT NULL,
  author_summary VARCHAR2(750) NOT NULL,
  image VARCHAR2(30), 
  insert_user int NOT NULL, 
  last_update_user int NOT NULL, 
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT author_pk PRIMARY KEY (authorID),
  CONSTRAINT fk_insert_author FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_author FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );
  
CREATE TABLE BookAuthor(
  bookID int NOT NULL,
  authorID int NOT NULL, 
  insert_user int NOT NULL, 
  last_update_user int NOT NULL, 
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT bookauthor_pk PRIMARY KEY (bookID, authorID),
  CONSTRAINT fk_book_bookauthor FOREIGN KEY (bookID) REFERENCES Book(bookID) ON DELETE CASCADE,
  CONSTRAINT fk_author_author FOREIGN KEY (authorID) REFERENCES Author(authorID) ON DELETE CASCADE,
  CONSTRAINT fk_insert_bookauthor FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_bookauthor FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );

  
CREATE TABLE Publisher(
  publisherID int NOT NULL,
  publisher_name VARCHAR2(30) NOT NULL,
  publisher_summary VARCHAR2(750) NOT NULL, 
  insert_user int NOT NULL, 
  last_update_user int NOT NULL, 
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT publisher_pk PRIMARY KEY (publisherID),
  CONSTRAINT fk_insert_publisher FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_publisher FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );
  
CREATE TABLE CategoryTbl(
  categoryID int NOT NULL,
  category_name VARCHAR2(30) NOT NULL,
  insert_user int NOT NULL,
  last_update_user int NOT NULL, 
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT category_pk PRIMARY KEY (categoryID),
  CONSTRAINT fk_insert_category FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_category FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );
  
CREATE TABLE CategoryInheritance(
  parent_categoryID  int NOT NULL, 
  subcategoryID int NOT NULL, 
  insert_user int NOT NULL,
  last_update_user int NOT NULL,
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT parent_pk  PRIMARY KEY ( parent_categoryID, subcategoryID),
  CONSTRAINT fk_parent_inht FOREIGN KEY (parent_categoryID) REFERENCES CategoryTbl(categoryID) ON DELETE CASCADE,
  CONSTRAINT fk_sub_inht FOREIGN KEY (subcategoryID) REFERENCES CategoryTbl(categoryID) ON DELETE CASCADE,
  CONSTRAINT fk_insert_category_inh FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_category_inh FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );
  
CREATE TABLE FileTbl(
  fileID int NOT NULL,
  file_size FLOAT NOT NULL,
  file_language VARCHAR2(30) NOT NULL,
  page_number int NOT NULL, 
  bookID int NOT NULL,
  publisherID int NOT NULL,
  insert_user int NOT NULL,
  last_update_user int NOT NULL,
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  publish_date DATE DEFAULT sysdate NULL,
  CONSTRAINT file_pk PRIMARY KEY (fileID),
  CONSTRAINT fk_book_file FOREIGN KEY (bookID) REFERENCES Book(bookID) ON DELETE CASCADE,
  CONSTRAINT fk_publisher_file FOREIGN KEY (publisherID) REFERENCES Publisher(publisherID) ON DELETE CASCADE,
  CONSTRAINT fk_insert_file FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_file FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );
  
CREATE TABLE BookCategory(
  bookID int NOT NULL, 
  categoryID int NOT NULL, 
  insert_user int NOT NULL,
  last_update_user int NOT NULL,
  insert_date DATE DEFAULT sysdate NULL, 
  last_update_date DATE DEFAULT sysdate NULL,
  CONSTRAINT book_category_pk PRIMARY KEY (bookID, categoryID),
  CONSTRAINT fk_categoryfile_file FOREIGN KEY (bookID) REFERENCES Book(bookID) ON DELETE CASCADE,
  CONSTRAINT fk_categoryfile_category FOREIGN KEY (categoryID) REFERENCES CategoryTbl(categoryID) ON DELETE CASCADE,
  CONSTRAINT fk_insert_filecategory FOREIGN KEY (insert_user) REFERENCES SystemUser(userid),
  CONSTRAINT fk_update_filecategory FOREIGN KEY (last_update_user) REFERENCES SystemUser(userid)
  );

  
CREATE TABLE Ebook(
  fileID int NOT NULL, 
  ebook_file VARCHAR2(30),
  CONSTRAINT ebook_pk PRIMARY KEY (fileID),
  CONSTRAINT fk_ebook FOREIGN KEY (fileID) REFERENCES FileTbl(fileID) ON DELETE CASCADE
  );
  
CREATE TABLE AudioBook(
  fileID int NOT NULL, 
  total_duration FLOAT NOT NULL,
  audio_file VARCHAR2(30), 
  CONSTRAINT audiobook_pk PRIMARY KEY (fileID),
  CONSTRAINT fk_audiobook FOREIGN KEY (fileID) REFERENCES FileTbl(fileID) ON DELETE CASCADE
  );
  
CREATE TABLE LibraryTbl(
  userid int NOT NULL, 
  fileID int NOT NULL, 
  current_page int NOT NULL, 
  CONSTRAINT library_pk PRIMARY KEY (userid, fileID),
  CONSTRAINT fk_user_library FOREIGN KEY (userid) REFERENCES UserTbl(userid) ON DELETE CASCADE,
  CONSTRAINT fk_file_library FOREIGN KEY (fileID) REFERENCES FileTbl(fileID) ON DELETE CASCADE
  );


CREATE TABLE Shelf(
  shelfID int NOT NULL,
  shelfname VARCHAR2(30) NOT NULL,
  userid int NOT NULL,
  isPublic NUMBER(1),
  CONSTRAINT shelf_pk PRIMARY KEY (shelfID, userid),
  CONSTRAINT fk_shelf FOREIGN KEY (userid) REFERENCES UserTbl(userid) ON DELETE CASCADE
  );
  
CREATE TABLE ShelfFile(
  shelfID int NOT NULL, 
  userid int NOT NULL, 
  fileID int NOT NULL, 
  CONSTRAINT shelffile_pk PRIMARY KEY (shelfID, userid, fileID),
  CONSTRAINT fk_shelffile_shelf FOREIGN KEY (shelfID, userid) REFERENCES Shelf(shelfID, userid) ON DELETE CASCADE,
  CONSTRAINT fk_shelffile_file FOREIGN KEY (fileID) REFERENCES FileTbl(fileID) ON DELETE CASCADE
  );
  


CREATE SEQUENCE permission_seq START WITH 1;

CREATE OR REPLACE TRIGGER permission_trig 
BEFORE INSERT ON PERMISSIONTBL 
FOR EACH ROW

BEGIN
  SELECT permission_seq.NEXTVAL
  INTO   :new.PERMISSIONID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE permission_insert(
  p_permissionname IN PERMISSIONTBL.PERMISSION_NAME%type,
  p_description IN PERMISSIONTBL.DESCRIPTION%type)
IS
BEGIN

  INSERT INTO PERMISSIONTBL ("PERMISSION_NAME", "DESCRIPTION")
  VALUES (p_permissionname, p_description);

  COMMIT;

END;
/

CREATE SEQUENCE role_seq START WITH 1;

CREATE OR REPLACE TRIGGER role_trig 
BEFORE INSERT ON ROLETBL 
FOR EACH ROW

BEGIN
  SELECT role_seq.NEXTVAL
  INTO   :new.ROLEID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE role_insert(
  p_rolename IN ROLETBL.ROLENAME%type,
  p_description IN ROLETBL.DESCRIPTION%type)
IS
BEGIN

  INSERT INTO ROLETBL ("ROLENAME", "DESCRIPTION")
  VALUES (p_rolename, p_description);

  COMMIT;

END;
/
CREATE OR REPLACE PROCEDURE rolepermission_insert (
  p_roleid IN ROLEPERMISSION.ROLEID%type,
  p_permissionid IN ROLEPERMISSION.PERMISSIONID%type
)
IS
BEGIN
  INSERT INTO ROLEPERMISSION (ROLEID, PERMISSIONID)
  VALUES (p_roleid, p_permissionid);
  
  COMMIT;
END;
/

CREATE SEQUENCE user_seq START WITH 1;

CREATE OR REPLACE TRIGGER user_trig 
BEFORE INSERT ON USERTBL 
FOR EACH ROW

BEGIN
  SELECT user_seq.NEXTVAL
  INTO   :new.USERID
  FROM   dual;
END;
/


CREATE OR REPLACE PROCEDURE user_insert(
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type
  )
IS
BEGIN

  INSERT INTO USERTBL (USERNAME, USER_PASSWORD, FIRST_NAME, SURNAME, REGION)
  VALUES (p_username, p_userpassword, p_firstname, p_surname, p_region);
  
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE contact_insert (
  p_userid IN CONTACT.USERID%type,
  p_country IN CONTACT.COUNTRY%type,
  p_city IN CONTACT.CITY%type,
  p_phone IN CONTACT.PHONE%type
)
IS
BEGIN
  INSERT INTO CONTACT (USERID, COUNTRY, CITY, PHONE)
  VALUES (p_userid, p_country, p_city, p_phone);  
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE systemuser_insert (
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type,
  p_roleid IN SYSTEMUSER.ROLEID%type,
  p_isactive IN SYSTEMUSER.ISACTIVE%type,
  p_country IN CONTACT.COUNTRY%type,
  p_city IN CONTACT.CITY%type,
  p_phone IN CONTACT.PHONE%type
)
IS
BEGIN
  USER_INSERT(p_username, p_userpassword, p_firstname, p_surname, p_region);
              
  CONTACT_INSERT(user_seq.CURRVAL, p_country, p_city, p_phone);                  
  
  INSERT INTO SYSTEMUSER (USERID, ROLEID, ISACTIVE)
  VALUES (user_seq.CURRVAL, p_roleid, p_isactive);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE paymentdetail_insert (
  p_userid IN PAYMENTDETAIL.USERID%type,
  p_ccard_no IN PAYMENTDETAIL.CREDIT_CARD_NO%type,
  p_security_no IN PAYMENTDETAIL.SECURITY_NO%type,
  p_bill_address IN PAYMENTDETAIL.BILL_ADDRESS%type,
  p_expire_date IN PAYMENTDETAIL.EXPIRE_DATE%type
)
IS
BEGIN
  INSERT INTO PAYMENTDETAIL (USERID, CREDIT_CARD_NO, SECURITY_NO, BILL_ADDRESS, EXPIRE_DATE)
  VALUES (p_userid, p_ccard_no, p_security_no, p_bill_address, p_expire_date);  
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE commercialuser_insert (
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type,
  p_ispremium IN COMMERCIALUSER.ISPREMIUM%type,
  p_ccard_no IN PAYMENTDETAIL.CREDIT_CARD_NO%type,
  p_security_no IN PAYMENTDETAIL.SECURITY_NO%type,
  p_bill_address IN PAYMENTDETAIL.BILL_ADDRESS%type,
  p_expire_date IN PAYMENTDETAIL.EXPIRE_DATE%type
)
IS
BEGIN
  USER_INSERT (p_username, p_userpassword, p_firstname, p_surname, p_region);
  
  PAYMENTDETAIL_INSERT (user_seq.CURRVAL, p_ccard_no, p_security_no, p_bill_address, p_expire_date);
              
  INSERT INTO COMMERCIALUSER (USERID, ISPREMIUM)
  VALUES (user_seq.CURRVAL, p_ispremium);
    
  COMMIT;
END;
/

CREATE SEQUENCE author_seq START WITH 1;

CREATE OR REPLACE TRIGGER author_trig 
BEFORE INSERT ON AUTHOR 
FOR EACH ROW

BEGIN
  SELECT author_seq.NEXTVAL
  INTO   :new.AUTHORID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE author_insert (
  p_author_name IN AUTHOR.AUTHOR_NAME%type,
  p_author_summary IN AUTHOR.AUTHOR_SUMMARY%type,
  p_image IN AUTHOR.IMAGE%type,
  p_insert_user IN AUTHOR.INSERT_USER%type,
  p_last_update_user IN AUTHOR.LAST_UPDATE_USER%type,
  p_insert_date IN AUTHOR.INSERT_DATE%type,
  p_last_update_date IN AUTHOR.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO AUTHOR (AUTHOR_NAME, AUTHOR_SUMMARY, IMAGE, INSERT_USER, 
                      LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_author_name, p_author_summary, p_image, p_insert_user, 
          p_last_update_user, p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/

CREATE SEQUENCE book_seq START WITH 1;

CREATE OR REPLACE TRIGGER book_insert_trig 
BEFORE INSERT ON BOOK 
FOR EACH ROW

BEGIN
  SELECT book_seq.NEXTVAL
  INTO   :new.BOOKID
  FROM   dual;
END;
/
CREATE OR REPLACE PROCEDURE book_insert(
  p_bookname IN BOOK.BOOKNAME%type,
  p_book_summary IN BOOK.BOOK_SUMMARY%type,
  p_cover_image IN BOOK.COVER_IMAGE%type,
  p_insert_user IN BOOK.INSERT_USER%type,
  p_last_update_user IN BOOK.LAST_UPDATE_USER%type,
  p_insert_date IN BOOK.INSERT_DATE%type,
  p_last_update_date IN BOOK.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO BOOK (BOOKNAME, BOOK_SUMMARY, COVER_IMAGE, INSERT_USER,
                    LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_bookname, p_book_summary, p_cover_image, p_insert_user, 
          p_last_update_user, p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/
  
CREATE OR REPLACE PROCEDURE bookauthor_insert (
  p_bookid IN BOOKAUTHOR.BOOKID%type,
  p_authorid IN BOOKAUTHOR.AUTHORID%type,
  p_insert_user IN BOOKAUTHOR.INSERT_USER%type,
  p_last_update_user IN BOOKAUTHOR.LAST_UPDATE_USER%type,
  p_insert_date IN BOOKAUTHOR.INSERT_DATE%type,
  p_last_update_date IN BOOKAUTHOR.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO BOOKAUTHOR (BOOKID, AUTHORID, INSERT_USER, 
                          LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_bookid, p_authorid, p_insert_user, p_last_update_user, 
          p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/

CREATE SEQUENCE category_seq START WITH 1;

CREATE OR REPLACE TRIGGER category_insert_trig 
BEFORE INSERT ON CATEGORYTBL 
FOR EACH ROW

BEGIN
  SELECT category_seq.NEXTVAL
  INTO   :new.CATEGORYID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE category_insert (
  p_category_name IN CATEGORYTBL.CATEGORY_NAME%type,
  p_insert_user IN CATEGORYTBL.INSERT_USER%type,
  p_last_update_user IN CATEGORYTBL.LAST_UPDATE_USER%type,
  p_insert_date IN CATEGORYTBL.INSERT_DATE%type,
  p_last_update_date IN CATEGORYTBL.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO CATEGORYTBL (CATEGORY_NAME, INSERT_USER, LAST_UPDATE_USER, 
                          INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_category_name, p_insert_user, p_last_update_user, 
          p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE categoryinheritance_insert (
  p_parent_cid IN CATEGORYINHERITANCE.PARENT_CATEGORYID%type,
  p_sub_cid IN CATEGORYINHERITANCE.SUBCATEGORYID%type,
  p_insert_user IN CATEGORYINHERITANCE.INSERT_USER%type,
  p_last_update_user IN CATEGORYINHERITANCE.LAST_UPDATE_USER%type,
  p_insert_date IN CATEGORYINHERITANCE.INSERT_DATE%type,
  p_last_update_date IN CATEGORYINHERITANCE.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO CATEGORYINHERITANCE (PARENT_CATEGORYID, SUBCATEGORYID, 
        INSERT_USER, LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_parent_cid, p_sub_cid, p_insert_user, p_last_update_user, 
          p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/


CREATE OR REPLACE PROCEDURE bookcategory_insert (
  p_bookid IN BOOKCATEGORY.BOOKID%type,
  p_categoryid IN BOOKCATEGORY.CATEGORYID%type,
  p_insert_user IN BOOKCATEGORY.INSERT_USER%type,
  p_last_update_user IN BOOKCATEGORY.LAST_UPDATE_USER%type,
  p_insert_date IN BOOKCATEGORY.INSERT_DATE%type,
  p_last_update_date IN BOOKCATEGORY.LAST_UPDATE_DATE%type
)
IS
BEGIN 
  INSERT INTO BOOKCATEGORY (BOOKID, CATEGORYID, INSERT_USER, LAST_UPDATE_USER,
  INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_bookid, p_categoryid, p_insert_user, p_last_update_user, 
          p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/

CREATE SEQUENCE file_seq START WITH 1;

CREATE OR REPLACE TRIGGER file_insert_trig 
BEFORE INSERT ON FILETBL 
FOR EACH ROW

BEGIN
  SELECT file_seq.NEXTVAL
  INTO   :new.FILEID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE file_insert (
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type
)
IS
BEGIN
  INSERT INTO FILETBL (FILE_SIZE, FILE_LANGUAGE, PAGE_NUMBER, BOOKID, PUBLISHERID,
  INSERT_USER, LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE, PUBLISH_DATE)
  VALUES (p_file_size, p_file_language, p_page_number, p_bookid, p_publisherid, 
  p_insert_user, p_last_update_user, p_insert_date, p_last_update_date, p_publish_date);

  COMMIT;
END;
/
CREATE OR REPLACE PROCEDURE ebook_insert (
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type,
  p_ebook_file IN EBOOK.EBOOK_FILE%type
)
IS
BEGIN
  FILE_INSERT (p_file_size, p_file_language, p_page_number, p_bookid, p_publisherid, 
  p_insert_user, p_last_update_user, p_insert_date, p_last_update_date, p_publish_date);
  
  INSERT INTO EBOOK (FILEID, EBOOK_FILE)
  VALUES (file_seq.CURRVAL, p_ebook_file);
  
  COMMIT;
END;
/
CREATE OR REPLACE PROCEDURE audiobook_insert (
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type,
  p_duration IN AUDIOBOOK.TOTAL_DURATION%type,
  p_audio_file IN AUDIOBOOK.AUDIO_FILE%type
)
IS
BEGIN
  FILE_INSERT (p_file_size, p_file_language, p_page_number, p_bookid, p_publisherid, 
  p_insert_user, p_last_update_user, p_insert_date, p_last_update_date, p_publish_date);
  
  INSERT INTO AUDIOBOOK (FILEID, TOTAL_DURATION, AUDIO_FILE)
  VALUES (file_seq.CURRVAL, p_duration, p_audio_file);
  
  COMMIT;
END;
/


CREATE OR REPLACE PROCEDURE library_insert (
  p_userid IN LIBRARYTBL.USERID%type,
  p_fileid IN LIBRARYTBL.FILEID%type
)
IS
BEGIN
  INSERT INTO LIBRARYTBL (USERID, FILEID, CURRENT_PAGE)
  VALUES (p_userid, p_fileid, 0);
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE shelffile_insert(
  p_userid IN SHELFFILE.USERID%type,
  p_shelfid IN SHELFFILE.SHELFID%type,
  p_fileid IN SHELFFILE.FILEID%type
)
IS
BEGIN
  LIBRARY_INSERT (p_userid, p_fileid);
  INSERT INTO SHELFFILE (USERID, SHELFID, FILEID)
  VALUES (p_userid, p_shelfid, p_fileid);
  
  COMMIT;
END;
/

CREATE SEQUENCE shelf_seq START WITH 1;

CREATE OR REPLACE TRIGGER shelf_trig 
BEFORE INSERT ON SHELF 
FOR EACH ROW

BEGIN
  SELECT shelf_seq.NEXTVAL
  INTO   :new.SHELFID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE shelf_insert (
  p_shelfname IN SHELF.SHELFNAME%type,
  p_userid IN SHELF.USERID%type,
  p_ispublic IN SHELF.ISPUBLIC%type
)
IS
BEGIN
  INSERT INTO SHELF (SHELFNAME, USERID, ISPUBLIC)
  VALUES (p_shelfname, p_userid, p_ispublic);
  
  COMMIT;
END;
/

CREATE SEQUENCE publisher_seq START WITH 1;

CREATE OR REPLACE TRIGGER publisher_trig 
BEFORE INSERT ON PUBLISHER
FOR EACH ROW

BEGIN
  SELECT publisher_seq.NEXTVAL
  INTO   :new.PUBLISHERID
  FROM   dual;
END;
/

CREATE OR REPLACE PROCEDURE publisher_insert (
  p_publisher_name IN PUBLISHER.PUBLISHER_NAME%type,
  p_publisher_summary IN PUBLISHER.PUBLISHER_SUMMARY%type,
  p_insert_user IN PUBLISHER.INSERT_USER%type,
  p_last_update_user IN PUBLISHER.LAST_UPDATE_USER%type,
  p_insert_date IN PUBLISHER.INSERT_DATE%type,
  p_last_update_date IN PUBLISHER.LAST_UPDATE_DATE%type
)
IS
BEGIN
  INSERT INTO PUBLISHER (PUBLISHER_NAME, PUBLISHER_SUMMARY, INSERT_USER, 
                        LAST_UPDATE_USER, INSERT_DATE, LAST_UPDATE_DATE)
  VALUES (p_publisher_name, p_publisher_summary, p_insert_user, 
          p_last_update_user, p_insert_date, p_last_update_date);
  
  COMMIT;
END;
/



CREATE OR REPLACE PROCEDURE user_update(
  p_userid IN USERTBL.USERID%type,
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type
  )
IS
BEGIN
  UPDATE USERTBL SET USERID = p_userid, 
                     USERNAME = p_username,
                     USER_PASSWORD = p_userpassword,
                     FIRST_NAME = p_firstname,
                     SURNAME = p_surname,
                     REGION = p_region
                 WHERE USERID = p_userid;
                     
    COMMIT;
    
END;
/

CREATE OR REPLACE PROCEDURE permission_update(
  p_permissionid IN PERMISSIONTBL.PERMISSIONID%type,
  p_permissionname IN PERMISSIONTBL.PERMISSION_NAME%type,
  p_description IN PERMISSIONTBL.DESCRIPTION%type)
IS
BEGIN

  UPDATE PERMISSIONTBL SET PERMISSIONID = p_permissionid,
                           PERMISSION_NAME = p_permissionname,
                           DESCRIPTION = p_description
                       WHERE PERMISSIONID = p_permissionid;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE role_update(
  p_roleid IN ROLETBL.ROLEID%type,
  p_rolename IN ROLETBL.ROLENAME%type,
  p_description IN ROLETBL.DESCRIPTION%type)
IS
BEGIN

  UPDATE ROLETBL SET ROLEID = p_roleid,
                     ROLENAME = p_rolename,
                     DESCRIPTION = p_description
                 WHERE ROLEID = p_roleid;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE contact_update (
  p_userid IN CONTACT.USERID%type,
  p_country IN CONTACT.COUNTRY%type,
  p_city IN CONTACT.CITY%type,
  p_phone IN CONTACT.PHONE%type
)
IS
BEGIN
  UPDATE CONTACT SET USERID = p_userid,
                     COUNTRY = p_country,
                     CITY = p_city,
                     PHONE = p_phone
                 WHERE USERID = p_userid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE systemuser_update (
  p_userid IN SYSTEMUSER.USERID%type,
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type,
  p_roleid IN SYSTEMUSER.ROLEID%type,
  p_isactive IN SYSTEMUSER.ISACTIVE%type,
  p_country IN CONTACT.COUNTRY%type,
  p_city IN CONTACT.CITY%type,
  p_phone IN CONTACT.PHONE%type
)
IS
BEGIN
  USER_UPDATE(p_userid, p_username, p_userpassword, p_firstname, p_surname, p_region);
              
  CONTACT_UPDATE(p_userid, p_country, p_city, p_phone);                  
  
  UPDATE SYSTEMUSER SET USERID = p_userid,
                     ROLEID = p_roleid,
                     ISACTIVE = p_isactive
                 WHERE USERID = p_userid;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE paymentdetail_update (
  p_userid IN PAYMENTDETAIL.USERID%type,
  p_ccard_no IN PAYMENTDETAIL.CREDIT_CARD_NO%type,
  p_security_no IN PAYMENTDETAIL.SECURITY_NO%type,
  p_bill_address IN PAYMENTDETAIL.BILL_ADDRESS%type,
  p_expire_date IN PAYMENTDETAIL.EXPIRE_DATE%type
)
IS
BEGIN
  UPDATE PAYMENTDETAIL SET USERID = p_userid,
                     CREDIT_CARD_NO = p_ccard_no,
                     SECURITY_NO = p_security_no,
                     BILL_ADDRESS = p_bill_address,
                     EXPIRE_DATE = p_expire_date
                 WHERE USERID = p_userid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE commercialuser_update (
  p_userid IN COMMERCIALUSER.USERID%type,
  p_username IN USERTBL.USERNAME%type,
  p_userpassword IN USERTBL.USER_PASSWORD%type,
  p_firstname IN USERTBL.FIRST_NAME%type,
  p_surname IN USERTBL.SURNAME%type,
  p_region IN USERTBL.REGION%type,
  p_ispremium IN COMMERCIALUSER.ISPREMIUM%type
)
IS
BEGIN
  USER_UPDATE (p_userid, p_username, p_userpassword, p_firstname, p_surname, p_region);
                
  UPDATE COMMERCIALUSER SET USERID = p_userid,
                     ISPREMIUM = p_ispremium
                 WHERE USERID = p_userid;              

    
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE author_update (
  p_authorid IN AUTHOR.AUTHORID%type,
  p_author_name IN AUTHOR.AUTHOR_NAME%type,
  p_author_summary IN AUTHOR.AUTHOR_SUMMARY%type,
  p_image IN AUTHOR.IMAGE%type,
  p_insert_user IN AUTHOR.INSERT_USER%type,
  p_last_update_user IN AUTHOR.LAST_UPDATE_USER%type,
  p_insert_date IN AUTHOR.INSERT_DATE%type,
  p_last_update_date IN AUTHOR.LAST_UPDATE_DATE%type
)
IS
BEGIN

  UPDATE AUTHOR SET AUTHORID = p_authorid,
                    AUTHOR_NAME = p_author_name,
                    AUTHOR_SUMMARY = p_author_summary,
                    IMAGE = p_image,
                    INSERT_USER = p_insert_user,
                    LAST_UPDATE_USER = p_last_update_user,
                    INSERT_DATE = p_insert_date,
                    LAST_UPDATE_DATE = p_last_update_date
                 WHERE AUTHORID = p_authorid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE book_update(
  p_bookid IN BOOK.BOOKID%type,
  p_bookname IN BOOK.BOOKNAME%type,
  p_book_summary IN BOOK.BOOK_SUMMARY%type,
  p_cover_image IN BOOK.COVER_IMAGE%type,
  p_insert_user IN BOOK.INSERT_USER%type,
  p_last_update_user IN BOOK.LAST_UPDATE_USER%type,
  p_insert_date IN BOOK.INSERT_DATE%type,
  p_last_update_date IN BOOK.LAST_UPDATE_DATE%type
)
IS
BEGIN
  UPDATE BOOK SET BOOKID = p_bookid,
                    BOOKNAME = p_bookname,
                    BOOK_SUMMARY = p_book_summary,
                    COVER_IMAGE = p_cover_image,
                    INSERT_USER = p_insert_user,
                    LAST_UPDATE_USER = p_last_update_user,
                    INSERT_DATE = p_insert_date,
                    LAST_UPDATE_DATE = p_last_update_date
                 WHERE BOOKID = p_bookid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE category_update (
  p_categoryid IN CATEGORYTBL.CATEGORYID%type,
  p_category_name IN CATEGORYTBL.CATEGORY_NAME%type,
  p_insert_user IN CATEGORYTBL.INSERT_USER%type,
  p_last_update_user IN CATEGORYTBL.LAST_UPDATE_USER%type,
  p_insert_date IN CATEGORYTBL.INSERT_DATE%type,
  p_last_update_date IN CATEGORYTBL.LAST_UPDATE_DATE%type
)
IS
BEGIN

  UPDATE CATEGORYTBL SET CATEGORYID = p_categoryid,
                    CATEGORY_NAME = p_category_name,
                    INSERT_USER = p_insert_user,
                    LAST_UPDATE_USER = p_last_update_user,
                    INSERT_DATE = p_insert_date,
                    LAST_UPDATE_DATE = p_last_update_date
                 WHERE CATEGORYID = p_categoryid;
  
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE file_update (
  p_fileid IN FILETBL.FILEID%type,
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type
)
IS
BEGIN
  UPDATE FILETBL SET FILEID = p_fileid,
                    FILE_SIZE = p_file_size,
                    FILE_LANGUAGE = p_file_language,
                    PAGE_NUMBER = p_page_number,
                    BOOKID = p_bookid,
                    PUBLISHERID = p_publisherid,
                    INSERT_USER = p_insert_user,
                    LAST_UPDATE_USER = p_last_update_user,
                    INSERT_DATE = p_insert_date,
                    LAST_UPDATE_DATE = p_last_update_date,
                    PUBLISH_DATE = p_publish_date
                 WHERE FILEID = p_fileid;
  

  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE ebook_update (
  p_fileid IN EBOOK.FILEID%type,
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type,
  p_ebook_file IN EBOOK.EBOOK_FILE%type
)
IS
BEGIN
  FILE_UPDATE (p_fileid, p_file_size, p_file_language, p_page_number, p_bookid, p_publisherid, 
  p_insert_user, p_last_update_user, p_insert_date, p_last_update_date, p_publish_date);
  
  UPDATE EBOOK SET FILEID = p_fileid,
                   EBOOK_FILE = p_ebook_file
               WHERE FILEID = p_fileid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE audiobook_update (
  p_fileid IN AUDIOBOOK.FILEID%type,
  p_file_size IN FILETBL.FILE_SIZE%type,
  p_file_language IN FILETBL.FILE_LANGUAGE%type,
  p_page_number IN FILETBL.PAGE_NUMBER%type,
  p_bookid IN FILETBL.BOOKID%type,
  p_publisherid IN FILETBL.PUBLISHERID%type,
  p_insert_user IN FILETBL.INSERT_USER%type,
  p_last_update_user IN FILETBL.LAST_UPDATE_USER%type,
  p_insert_date IN FILETBL.INSERT_DATE%type,
  p_last_update_date IN FILETBL.LAST_UPDATE_DATE%type,
  p_publish_date IN FILETBL.PUBLISH_DATE%type,
  p_total_duration IN AUDIOBOOK.TOTAL_DURATION%type,
  p_audio_file IN AUDIOBOOK.AUDIO_FILE%type
)
IS
BEGIN

  FILE_UPDATE (p_fileid, p_file_size, p_file_language, p_page_number, p_bookid, p_publisherid, 
   p_insert_user, p_last_update_user, p_insert_date, p_last_update_date, p_publish_date);
   
   UPDATE AUDIOBOOK SET FILEID = p_fileid,
                   TOTAL_DURATION = p_total_duration,
                   AUDIO_FILE = p_audio_file
               WHERE FILEID = p_fileid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE library_update (
  p_userid IN LIBRARYTBL.USERID%type,
  p_fileid IN LIBRARYTBL.FILEID%type,
  p_current_page IN LIBRARYTBL.CURRENT_PAGE%type
)
IS
BEGIN

  UPDATE LIBRARYTBL SET USERID = p_userid,
                        FILEID = p_fileid,
                        CURRENT_PAGE = p_current_page
                    WHERE USERID = p_userid AND  FILEID = p_fileid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE shelf_update (
  p_shelfid IN SHELF.SHELFID%type,
  p_shelfname IN SHELF.SHELFNAME%type,
  p_userid IN SHELF.USERID%type,
  p_ispublic IN SHELF.ISPUBLIC%type
)
IS
BEGIN
  
  UPDATE SHELF SET SHELFID = p_shelfid,
                   SHELFNAME = p_shelfname,
                   USERID = p_userid,
                   ISPUBLIC = p_ispublic
                WHERE SHELFID = p_shelfid;
  
  COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE publisher_update (
  p_publisherid IN PUBLISHER.PUBLISHERID%type,
  p_publisher_name IN PUBLISHER.PUBLISHER_NAME%type,
  p_publisher_summary IN PUBLISHER.PUBLISHER_SUMMARY%type,
  p_insert_user IN PUBLISHER.INSERT_USER%type,
  p_last_update_user IN PUBLISHER.LAST_UPDATE_USER%type,
  p_insert_date IN PUBLISHER.INSERT_DATE%type,
  p_last_update_date IN PUBLISHER.LAST_UPDATE_DATE%type
)
IS
BEGIN
  UPDATE PUBLISHER SET PUBLISHERID = p_publisherid,
                    PUBLISHER_NAME = p_publisher_name,
                    PUBLISHER_SUMMARY = p_publisher_summary,
                    INSERT_USER = p_insert_user,
                    LAST_UPDATE_USER = p_last_update_user,
                    INSERT_DATE = p_insert_date,
                    LAST_UPDATE_DATE = p_last_update_date
                 WHERE PUBLISHERID = p_publisherid;
  
  
  COMMIT;
END;
/



CREATE OR REPLACE PROCEDURE PERMISSION_DELETE(
  p_permissionid IN PERMISSIONTBL.PERMISSIONID%type
)
IS
BEGIN
    DELETE FROM ROLEPERMISSION WHERE PERMISSIONID = p_permissionid;
END;
/

CREATE OR REPLACE PROCEDURE ROLE_DELETE(
  p_roleid IN ROLETBL.ROLEID%type
)
IS
BEGIN
    DELETE FROM ROLETBL WHERE ROLEID = p_roleid;
END;
/

CREATE OR REPLACE PROCEDURE ROLEPERMISSION_DELETE(
  p_roleid IN ROLEPERMISSION.ROLEID%type,
  p_permissionid IN ROLEPERMISSION.PERMISSIONID%type
)
IS
BEGIN
    DELETE FROM ROLEPERMISSION 
    WHERE ROLEID = p_roleid AND PERMISSIONID = p_permissionid;
END;
/

CREATE OR REPLACE PROCEDURE USER_DELETE (
  p_userid IN USERTBL.USERID%type
)
IS
BEGIN
  DELETE FROM USERTBL WHERE USERID = p_userid;
END;
/

CREATE OR REPLACE PROCEDURE SYSTEMUSER_DELETE(
  p_userid IN SYSTEMUSER.USERID%type
)
IS
BEGIN
    UPDATE SYSTEMUSER SET ISACTIVE = 0 WHERE USERID = p_userid;
END;
/

CREATE OR REPLACE PROCEDURE COMMERCIALUSER_DELETE(
  p_userid IN COMMERCIALUSER.USERID%type
)
IS
BEGIN
    USER_DELETE(p_userid);
END;
/


CREATE OR REPLACE PROCEDURE FILE_DELETE (
  p_fileid IN FILETBL.FILEID%type
)
IS
BEGIN
  DELETE FROM FILETBL WHERE FILEID = p_fileid;
END;
/


CREATE OR REPLACE PROCEDURE EBOOK_DELETE(
  p_fileid IN EBOOK.FILEID%type
)
IS
BEGIN
    FILE_DELETE(p_fileid);
END;
/

CREATE OR REPLACE PROCEDURE AUDIOBOOK_DELETE(
  p_fileid IN AUDIOBOOK.FILEID%type
)
IS
BEGIN
    FILE_DELETE(p_fileid);
END;
/

CREATE OR REPLACE PROCEDURE SHELFFILE_DELETE(
  p_userid IN SHELFFILE.USERID%type,
  p_shelfid IN SHELFFILE.SHELFID%type,
  p_fileid IN SHELFFILE.FILEID%type
)
IS
BEGIN
  DELETE FROM SHELFFILE WHERE USERID    = p_userid 
                        AND   SHELFID = p_shelfid
                        AND   FILEID    = p_fileid;
END;
/

CREATE OR REPLACE PROCEDURE SHELF_DELETE (
  p_userid IN SHELF.USERID%type,
  p_shelfid IN SHELF.USERID%type
)
IS
BEGIN
  DELETE FROM SHELF WHERE USERID  = p_userid 
                    AND   SHELFID = p_shelfid;
END;
/

CREATE OR REPLACE PROCEDURE LIBRARY_SINGLE_DELETE(
  p_userid IN LIBRARYTBL.USERID%type,
  p_fileid IN LIBRARYTBL.FILEID%type
)
IS
BEGIN
  DELETE FROM LIBRARYTBL WHERE USERID = p_userid AND FILEID = p_fileid;
END;
/

CREATE OR REPLACE PROCEDURE LIBRARY_ALL_DELETE (
  p_userid IN LIBRARYTBL.USERID%type
)
IS
BEGIN
  DELETE FROM LIBRARYTBL WHERE USERID = p_userid;
END;
/


CREATE OR REPLACE PROCEDURE AUTHOR_DELETE (
  p_authorid IN AUTHOR.AUTHORID%type
)
IS
BEGIN
  DELETE FROM AUTHOR WHERE AUTHORID = p_authorid;
END;
/


CREATE OR REPLACE PROCEDURE BOOK_DELETE (
  p_bookid IN BOOK.BOOKID%type
)
IS
BEGIN
  DELETE FROM BOOK WHERE BOOKID = p_bookid;
END;
/



CREATE OR REPLACE PROCEDURE BOOKAUTHOR_DELETE (
  p_bookid IN BOOKAUTHOR.BOOKID%type,
  p_authorid IN BOOKAUTHOR.AUTHORID%type
)
IS
BEGIN
  DELETE FROM BOOKAUTHOR WHERE BOOKID = p_bookid AND AUTHORID = p_authorid;
END;
/


CREATE OR REPLACE PROCEDURE CATEGORY_DELETE (
  p_categoryid IN CATEGORYTBL.CATEGORYID%type
)
IS
BEGIN
  DELETE FROM CATEGORYTBL WHERE CATEGORYID = p_categoryid;
END;
/

CREATE OR REPLACE PROCEDURE CATEGORYINHERITANCE_DELETE (
  p_parentcid IN CATEGORYINHERITANCE.PARENT_CATEGORYID%type,
  p_subcid IN CATEGORYINHERITANCE.SUBCATEGORYID%type
)
IS
BEGIN
  DELETE FROM CATEGORYINHERITANCE WHERE PARENT_CATEGORYID = p_parentcid
                                  AND   SUBCATEGORYID = p_subcid;
END;
/


CREATE OR REPLACE PROCEDURE CONTACT_DELETE (
  p_userid IN CONTACT.USERID%type
)
IS
BEGIN
  DELETE FROM CONTACT WHERE USERID = p_userid;
END;
/



CREATE OR REPLACE PROCEDURE BOOKCATEGORY_DELETE (
  p_bookid IN BOOKCATEGORY.BOOKID%type,
  p_categoryid IN BOOKCATEGORY.CATEGORYID%type
)
IS
BEGIN
  DELETE FROM BOOKCATEGORY WHERE BOOKID = p_bookid
                           AND CATEGORYID = p_categoryid;
END;
/



CREATE OR REPLACE PROCEDURE PAYMENTDETAIL_DELETE (
  p_userid IN PAYMENTDETAIL.USERID%type
)
IS
BEGIN
  USER_DELETE(p_userid);
END;
/


CREATE OR REPLACE PROCEDURE PUBLISHER_DELETE (
  p_publisherid IN PUBLISHER.PUBLISHERID%type
)
IS
BEGIN
  DELETE FROM PUBLISHER WHERE PUBLISHERID = p_publisherid;
END;
/

